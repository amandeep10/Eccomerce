<?php
/** 
 * Manage product controller
*/

App::uses('Controller', 'Controller');

class ProductsController extends AppController {

	public function beforeFilter(){
		parent::beforeFilter();
	}
	public function admin_index(){
		echo 'here';
	}

}