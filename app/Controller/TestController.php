<?php
//http://book.cakephp.org/2.0/en/models/retrieving-your-data.html
//http://cakephpcheatsheet.com/
//http://sandbox.pontefamily.us/pages/cakephp_cheat_sheet

App::uses('AppController', 'Controller');

class TestController extends AppController
{
	public $name = 'Tests';
	public $components = array('Cookie','Common','Session');
	public $uses = array('Prayer','PrayerImage','PrayerCategory');
	
	public function index()
	{
		$this->set('selected_tab','Test');
		$this->Prayer->recursive = 1;
		
		/**
		 * This is example of custom join between 3 tables having ono to one relation 
				fields => 'UserJoin.*', 'Message.*
		 */		
		
		$rs=$this->Prayer->find('all',
								array(
									'fields' => array('Prayer.id','Prayer.prayername_english','Prayer.audio_english','PrayerCategories.category_id','PrayerImage.image_name'),
									'order' => array('Prayer.prayername_english' => 'asc'),
									'joins'=>array(
												array(
													'table' => 'prayer_images',
													'alias' => 'PrayerImage',
													'type' => 'LEFT',
													'conditions' => 'Prayer.id=PrayerImage.prayer_id'
												),
												array(
													'table' => 'prayer_categories',
													'alias' => 'PrayerCategories',
													'type' => 'LEFT',
													'conditions' => array('PrayerCategories.prayer_id=Prayer.id'
																	)
												)
									),
									'conditions'=>array('Prayer.id=1'),
									'limit'=> 4
								)
							);	
		//pr($rs);
		
		$result=$this->Prayer->find('all',array('conditions'=> array(
						'(prayername_english="dgd" and id=1) or id=2'
						)
					)
				);
		pr($result);
		
		/**
		 * This is example of dynamic binding and joining 3 tables having ono to many relation 
		 */
		 $this->Prayer->bindModel(
			array('hasMany' => array(
					'PrayerImage' => array(
						'className' => 'PrayerImage',
						'foreignKey' => 'prayer_id'
					)
				)
			)
		);
		$this->Prayer->bindModel(
			array('hasMany' => array(
					'PrayerCategories' => array(
						'className' => 'PrayerCategories'
					)
				)
			)
		); 
		$conditions=array('Prayer.status' => 1);
		//$res=$this->Prayer->find('all',array('conditions'=>$conditions));
		//pr($res);
		
		/**
		 * This is example of custom query
		 */
		//$rs=$this->Prayer->query("select * from prayers");
		
		/* $this->Prayer->unbindModel(
			array('hasOne' => array('PrayerCategories'))  
		);
			array('associationType' 		array('associatedModelClassName'))
		 */	
	}
}


/* 'OR' =>
        array(
               array('AND' => array(
                              array('EventCompetitor.is_black' => 1),
                              array('EventCompetitor.is_adult' => 1)
                        )),
               array('AND' => array(
                              array('EventCompetitor.is_black' => 0),
                              array('EventCompetitor.is_adult' => 0)
                        )),
             ), */
?>