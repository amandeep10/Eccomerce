<?php 
class CommonComponent extends Component
{	
var $components = array('Session');
	
	function __construct(ComponentCollection $collection, $settings = array()) {
        parent::__construct($collection, $settings);
		  
    }
	public function initialize(Controller $controller, $settings = array()) {
		$this->controller = $controller;
	}	
	/** 
	* This is test function
	*/
	public function test(){
		echo 'here';
	}
	/**
     * This function will delete a file if exists.
     * @param	filename.
     * @return	true or false.
     * @usage	delete existing files;
     * @author	
     */
    function delFile($fileName=false) {
        if (file_exists($fileName)) {
            if (unlink($fileName)) {
                return true;
            } else {
                return false;
            }
        }
        return true;
    }//END FUNCTION
	/**
	* This function will return list of data from database to display in selection list.
	* @param	string,array,integer,array.
	* @return	html.
	* @author	
	*/
	function getList($modelName = false, $fieldsArr = '', $condition = '',$orderBy = ''){
		$options = array();
        if (!empty($fieldsArr)) {
            $options['fields'] = $fieldsArr;
        }
        if (!empty($condition)) {
			$options['conditions'] = $condition;
        }
		if (!empty($orderBy)) {
			$options['order'] = $orderBy;
        }
		if(!empty($modelName)){
			App::uses($modelName, 'Model');
			$this->$modelName = new $modelName();
			$this->$modelName->recursive = 0;
			$result = $this->$modelName->find('all',$options);
		}
        $list = '';
        if (!empty($result) && is_array($result) && count($fieldsArr) >=2) {
            foreach ($result as $value) {
				$option = $value[$modelName][$fieldsArr[1]];
				if(count($fieldsArr) > 2 && isset($value[$modelName][$fieldsArr[2]]))
					$option .= ' '.$value[$modelName][$fieldsArr[2]];
				if(count($fieldsArr) > 3 && isset($value[$modelName][$fieldsArr[3]]))
					$option .= ' '.$value[$modelName][$fieldsArr[3]];
                if (isset($value[$modelName]['id'])) {
                    $list[$value[$modelName]['id']]=ucwords($option);
                } else {
					$list[$value[$modelName][$fieldsArr[0]]]=ucwords($option);
                }
            }			
        }
        return $list;
	}
	/**
	* This function will download file
	* @param file path
	* @return download file
	* @author	
	*/
	function downloadFile($fullPath) { 
		
		if ($fd = fopen ($fullPath, "r")) {
			$fsize = filesize($fullPath);
			$path_parts = pathinfo($fullPath);
			
			$ext = strtolower($path_parts["extension"]);
			switch ($ext) {
				case "pdf":
					header("Content-type: application/pdf"); // add here more headers for diff. extensions
					header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a download
					break;
				default;
					header("Content-type: application/octet-stream");
					header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
			}
			header("Content-length: $fsize");
			header("Cache-control: private"); //use this to open files directly
			while(!feof($fd)) {
				$buffer = fread($fd, 2048);
				echo $buffer;
			}
		}
	}
	/**
	* This function will filter records based on a condition
	* @param string, string ,string , string
	* @return array
	* @author	
	*/
	function filterRecords ($modelName, $field , $filter_id , $condition='') {

        $options = array();
        if (!empty($fieldsArr)) {
            $options['fields'] = $fieldsArr;
        }

        if(!empty($modelName)){
            App::uses($modelName, 'Model');
            $this->$modelName = new $modelName();
            $this->$modelName->recursive = 0;
        }

		$conditions=array();
		
		$this->controller->set('selected_'.$field, '');	
		if(isset($this->controller->request->query[$filter_id]) && !empty($this->controller->request->query[$filter_id])) {
			if($condition==''){
				$conditions[] = array($modelName.'.'.$field=> $this->controller->request->query[$filter_id]);
			}else if($condition=='LIKE'){
				$conditions[] = array($modelName.'.'.$field.' LIKE'=> '%'.trim($this->controller->request->query[$filter_id]).'%');			
			}
			$this->controller->set('selected_'.$field, $this->controller->request->query[$filter_id]);			
		} 
		return $conditions;
    }
	/**
	* This function will remove \n character from any string
	* @param string, string 
	* @return string
	* @author	
	*/
	function removeSlashes($fieldname){
		$arr=explode("\\n",$fieldname);
		$numItems = count($arr);
		$returnValue="";
		$i = 0;
		foreach ($arr as $value){
		  if(++$i === $numItems) {
			$returnValue.=$value;
		  }else{
			$returnValue.=$value."\n";
		  }
		}
		return $returnValue;	
	}
	/**
	* This function is used to upload a file into desired destination
	* @param string, string ,string 
	* @return string
	* @author	
	*/
	function uploadFile ($modelName, $fieldName , $destinationFolder) {

        $options = array();
        if (!empty($fieldsArr)) {
            $options['fields'] = $fieldsArr;
        }

        if(!empty($modelName)){
            App::uses($modelName, 'Model');
            $this->$modelName = new $modelName();
            $this->$modelName->recursive = 0;
        }
		
		if($this->controller->data[$modelName][$fieldName]['error']===UPLOAD_ERR_OK){
			$fileName=time().$this->controller->request->data[$modelName][$fieldName]['name'];
			move_uploaded_file($this->controller->request->data[$modelName][$fieldName]['tmp_name'], $destinationFolder."/".$fileName);
			$this->controller->request->data[$modelName][$fieldName]=$fileName;
			return 'true';
		}else { 
			return $this->codeToMessage($this->controller->request->data[$modelName][$fieldName]['error']); 
		} 
    }
	/**
	* This function is used to upload a image and its thumb into desired destination 
	* It will create two folder large and thumb in destination to store image and its thumb
	* @param string, string ,string 
	* @return string
	* @author	
	*/
	function uploadImage ($modelName, $fieldName , $destinationFolder, $resizeWidth=60,$resizeHeight=60) {

        $options = array();
        if (!empty($fieldsArr)) {
            $options['fields'] = $fieldsArr;
        }

        if(!empty($modelName)){
            App::uses($modelName, 'Model');
            $this->$modelName = new $modelName();
            $this->$modelName->recursive = 0;
        }
		
		if($this->controller->data[$modelName][$fieldName]['error']==0){
			$fileName=time().$this->controller->request->data[$modelName][$fieldName]['name'];
			move_uploaded_file($this->controller->request->data[$modelName][$fieldName]['tmp_name'], $destinationFolder."/large/".$fileName);
			$this->resize($destinationFolder,$fileName,$resizeWidth,$resizeHeight);
			$this->controller->request->data[$modelName][$fieldName]=$fileName;
			return 'true';
		}else { 
			return $this->codeToMessage($this->controller->request->data[$modelName][$fieldName]['error']);
		} 
    }	
	/**
	* This function is used to get error message during file upload
	* @param int
	* @return string
	* @author	
	*/	
	function codeToMessage($code) { 
        switch ($code) { 
            case UPLOAD_ERR_INI_SIZE: 
                $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini"; 
                break; 
            case UPLOAD_ERR_FORM_SIZE: 
                $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form"; 
                break; 
            case UPLOAD_ERR_PARTIAL: 
                $message = "The uploaded file was only partially uploaded"; 
                break; 
            case UPLOAD_ERR_NO_FILE: 
                $message = "No file was uploaded"; 
                break; 
            case UPLOAD_ERR_NO_TMP_DIR: 
                $message = "Missing a temporary folder"; 
                break; 
            case UPLOAD_ERR_CANT_WRITE: 
                $message = "Failed to write file to disk"; 
                break; 
            case UPLOAD_ERR_EXTENSION: 
                $message = "File upload stopped by extension"; 
                break; 

            default: 
                $message = "Unknown upload error"; 
                break; 
        } 
        return $message; 
    } 
	/**
	* This function is used to resize images
	* @param string, string, int, int
	* @return string
	* @author	
	*/	
    function resize($destinationFolder,$fileName,$destinationWidth=60, $destinationHeight=60) { 
	 	$imagePath=$destinationFolder."/large/".$fileName;
        // The file has to exist to be resized 
        if(file_exists($imagePath)) { 

            // Gather some info about the image 
            $imageInfo = getimagesize($imagePath); 

            // Find the intial size of the image 
            $sourceWidth = $imageInfo[0]; 
            $sourceHeight = $imageInfo[1]; 
             
            // Find the mime type of the image 
            $mimeType = $imageInfo['mime']; 
			
			
			$source_aspect_ratio = $sourceWidth / $sourceHeight;
			$thumbnail_aspect_ratio = $destinationWidth / $destinationHeight;
			if ($sourceWidth <= $destinationWidth && $sourceHeight <= $destinationHeight) {
				$thumbnail_image_width = $sourceWidth;
				$thumbnail_image_height = $sourceHeight;
			} elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) {
				$thumbnail_image_width = (int) ($destinationHeight * $source_aspect_ratio);
				$thumbnail_image_height = $destinationHeight;
			} else {
				$thumbnail_image_width = $destinationWidth;
				$thumbnail_image_height =(int) ($destinationWidth / $source_aspect_ratio);	
			}             
 
            // Create the destination for the new image 
            $destination = imagecreatetruecolor($thumbnail_image_width, $thumbnail_image_height); 

			if($destinationWidth!=60 && $destinationHeight!=60){
				$path=pathinfo($fileName);
				$name=$path['filename'];
				$ext=$path['extension'];
				$fileName=$name."_".$destinationWidth."x".$destinationHeight.".".$ext;
			}
			
            // Now determine what kind of image it is and resize it appropriately 
            if($mimeType == 'image/jpeg' || $mimeType == 'image/pjpeg') {
                $source = imagecreatefromjpeg($imagePath);
                imagecopyresampled($destination, $source, 0, 0, 0, 0, $thumbnail_image_width, $thumbnail_image_height, $sourceWidth, $sourceHeight);
                imagejpeg($destination, $destinationFolder."/thumb/".$fileName,100); 
            } else if($mimeType == 'image/gif') { 
                $source = imagecreatefromgif($imagePath); 
                imagecopyresampled($destination, $source, 0, 0, 0, 0, $thumbnail_image_width, $thumbnail_image_height, $sourceWidth, $sourceHeight);
                imagegif($destination, $destinationFolder."/thumb/".$fileName,100); 
            } else if($mimeType == 'image/png' || $mimeType == 'image/x-png') {
                $source = imagecreatefrompng($imagePath);
                imagecopyresampled($destination, $source, 0, 0, 0, 0, $thumbnail_image_width, $thumbnail_image_height, $sourceWidth, $sourceHeight);
                imagepng($destination, $destinationFolder."/thumb/".$fileName,9); 
            } else { 
                return false; 
            } 
             
            // Free up memory 
            imagedestroy($source); 
            imagedestroy($destination); 
			return true;
        } else { 
            return false;
        } 
		
	} 
		
	/**
	* This function will random alpha numeric value
	* @param  length of string
	* @return ranmdom string
	*/
	function randomAlphaNum($length=6){

		$seeds = 'alphanum';
		
		// Possible seeds
		$seedings['alpha'] = 'abcdefghijklmnopqrstuvwqyz';
		$seedings['numeric'] = '0123456789';
		$seedings['alphanum'] = 'abcdefghijklmnopqrstuvwqyz0123456789';
		$seedings['hexidec'] = '0123456789abcdef';
		
		// Choose seed
		if (isset($seedings[$seeds]))
		{
			$seeds = $seedings[$seeds];
		}
		
		// Seed generator
		list($usec, $sec) = explode(' ', microtime());
		$seed = (float) $sec + ((float) $usec * 100000);
		mt_srand($seed);
		
		// Generate
		$str = '';
		$seeds_count = strlen($seeds);
		
		for ($i = 0; $length > $i; $i++)
		{
			$str .= $seeds{mt_rand(0, $seeds_count - 1)};
		}		
		return $str;
	} 	
}	