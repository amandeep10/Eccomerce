<?php
App::uses('ModelBehavior', 'Model');

class PagingBehavior extends ModelBehavior{

	public function paginate(Model $model, $conditions, $fields, $order, $limit,
		$page = 1, $recursive = null, $extra = array()) {
		// method content
		
	}

	public function paginateCount(Model $model, $conditions = null, $recursive = 0,
		$extra = array()) {
		
		 $sql = "select cat0.cat_name as cat0_name , cat0.content,cat0.meta_title,cat0.meta_keywords,cat0.meta_description,cat0.image,cat1.cat_name as    cat1_name , cat2.cat_name as cat2_name , cat3.cat_name as cat3_name, cat4.cat_name as cat4_name from categories as cat0
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
			order
		by cat0_name";
		$this->recursive = $recursive;
		$results = $this->query($sql);
		return count($results);
	}
}