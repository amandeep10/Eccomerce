<?php
App::uses('Sanitize', 'Utility');
App::uses('AppController', 'Controller');

class CategoriesController extends AppController{
	public $uses = array('Category');
	public $components = array('Paginator');
	public static $catId;
	public static $paRs=array();

	public function admin_index(){
		$catRs=array();
		
		$this->paginate = array(
		'limit' => 2,//
		'order' => array(
				'cat_name' => 'asc'
			)
		); 
		$rs = $this->paginate('Category');
		$pageLinks=array('controller'=>'categories','action'=>'index');
		//$rs=array_merge($rs,$pageLinks);
		$this->set('cat',$rs);
	}
	public function getParentCategory($res,$catID=6,$rec=false){
		
		static $a = 0;
		//unset(self::$paRs[0]);
		if($rec == false){
			for($k=0;$k<=count(self::$paRs)+1;$k++){
				unset(self::$paRs[$k]);
			}
		}
		self::$catId = $catID;
						
		$pId=$res['Category']['PARENT_CAT_ID'];
		$pCat=$this->Category->find('first',array('conditions'=>array('ID' => $res['Category']['PARENT_CAT_ID'])));
		echo $pCat['Category']['CAT_NAME'];	
		self::$paRs[][self::$catId] = $pCat['Category']['CAT_NAME']/* .'_'.$pId */;
		if($pCat['Category']['PARENT_CAT_ID'] !=0){
			$this->getParentCategory($pCat,self::$catId,true);
		}
		
		$a++;
		return self::$paRs;
	}
	public function admin_add(){
		$cats=array();
		$allCat = $this->Category->findAllCategories();
		 
		foreach($allCat as $cat){
			$cat_name='';
			for($k=(count($cat)-1);$k>=0;$k--){
				if($cat['cat'.$k]["cat".$k."_name"] !=''){
					$cat_name .= $cat['cat'.$k]["cat".$k."_name"].' > ';
				}
				if($k==0){
					$id=$cat['cat0']["id"];
					$cats[$id]=rtrim($cat_name,' > ');
				}
			}
		}
		if($this->request->isPost()){
			$data=$this->request->data;
			$image=$data['Category']['image'];
			$rootPath=WWW_ROOT.'uploads'.DS.$image['name'];
			if(move_uploaded_file($image['tmp_name'],$rootPath)){
				$data['Category']['image']=$image['name'];
				//$this->Category->save($data);
				$this->Session->setFlash(
					'Data is save successfully',
					'default',
					array('class' => 'example_class')
				);
				return $this->redirect(
					array('controller' => 'categories')
				);
				
			}else{
				$this->Session->setFlash(
					'Some error occur, please try later',
					'default',
					array('class' => 'example_class')
				);
				return $this->redirect(
					array('controller' => 'categories')
				);
			}
			
		}
		$this->set('allCat',$cats);
	}
}