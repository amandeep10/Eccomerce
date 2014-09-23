<?php
App::uses('AppModel', 'Model');

class Category extends AppModel{
	var $name = 'Category';
    var $useTable = 'categories';
    var $actsAs = array('Tree');
	public $total;
	public $rs;
	public function findAllCategories($recursive = null, $extra = array()){
		
		$rs="select cat0.cat_name as cat0_name ,cat0.id, cat0.content,cat0.meta_title,cat0.meta_keywords,cat0.meta_description,cat0.image,cat0.status,cat1.cat_name as    cat1_name , cat1.id as cat1_id ,cat2.cat_name as cat2_name ,cat2.id as cat2_id, cat3.cat_name as cat3_name, cat3.id as cat3_id, cat4.cat_name as cat4_name,cat4.id as cat4_id from categories as cat0
			left outer 
			  join categories as cat1 
				on cat1.id = cat0.parent_id  
			left outer 
			  join categories as cat2
				on cat2.id = cat1.parent_id  
			left outer 
			  join categories as cat3
				on cat3.id = cat2.parent_id
			left outer 
			  join categories as cat4
			  on cat4.id = cat3.parent_id
			  where cat0.status =1
			  order by cat0_name ";	
		
		$this->recursive = $recursive;
		$results = $this->query($rs);
		
		return $results;
	}
	
	public function paginate($conditions, $fields, $order, $limit, $page = 1,$recursive = null, $extra = array()) {
		
		//$page= ($page==1) ? 0: $page;
		$start=($page-1)*$limit;
		$rs="select cat0.cat_name as cat0_name ,cat0.id, cat0.content,cat0.meta_title,cat0.meta_keywords,cat0.meta_description,cat0.image,cat0.status,cat1.cat_name as    cat1_name , cat1.id as cat1_id ,cat2.cat_name as cat2_name ,cat2.id as cat2_id, cat3.cat_name as cat3_name, cat3.id as cat3_id, cat4.cat_name as cat4_name,cat4.id as cat4_id from categories as cat0
			left outer 
			  join categories as cat1 
				on cat1.id = cat0.parent_id  
			left outer 
			  join categories as cat2
				on cat2.id = cat1.parent_id  
			left outer 
			  join categories as cat3
				on cat3.id = cat2.parent_id
			left outer 
			  join categories as cat4
			  on cat4.id = cat3.parent_id
			  where cat0.status =1
			  order by cat0_name limit $start,$limit";	
		
		$this->recursive = $recursive;
		$results = $this->query($rs);
		
		return $results;
	}

	public function paginateCount($conditions = null, $recursive = 0,$extra = array()) {
		
		 $sql="select count(*) as total  from categories as cat0
			left outer 
			  join categories as cat1 
				on cat1.id = cat0.parent_id  
			left outer 
			  join categories as cat2
				on cat2.id = cat1.parent_id  
			left outer 
			  join categories as cat3
				on cat3.id = cat2.parent_id
			left outer 
			  join categories as cat4
				on cat4.id = cat3.parent_id
			  where cat0.status =1";	
		$this->recursive = $recursive;
		$results = $this->query($sql);
		return $results[0][0]['total'];
	} 
}