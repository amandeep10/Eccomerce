<?php
App::uses('Sanitize', 'Utility');
App::uses('AppController', 'Controller');

class UsersController extends AppController{

	function beforeFilter(){	
		parent::beforeFilter();
		if($this->params['controller']=='users' && ($this->params['action']=='admin_login' || $this->params['action']=='admin_add')){
			$this->set('login','true');
		}	
        $this->Auth->allow('admin_add'); 
	}
	public function admin_login() {
        
        //if already logged-in, redirect
        if($this->Session->check('Auth.User')){
            $this->redirect(array('action' => 'index'));      
        }
         
        // if we get the post information, try to authenticate
        if ($this->request->is('post')) {
			$this->User->set($this->request->data);
            if ($this->Auth->login()) {
                $this->Session->setFlash(__('Welcome, '. $this->Auth->user('username')));
                $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Session->setFlash(__('Invalid username or password'));
            }
        }
		 $this->set('title_for_layout','Admin Login');
    }
    public function admin_logout() {
        $this->redirect($this->Auth->logout());
    }
	
	/**
	* add new user
	* @return void
	*/
	function admin_add(){
		if ($this->request->is('post')) {
			$this->request->data = Sanitize::clean($this->request->data);
            if ($this->User->save($this->request->data(),array('validate'=>false))) {
                $this->Session->setFlash(__('Data saved successfully.'));
                $this->redirect(array('action'=>'admin_add'));
            } else {
                $this->Session->setFlash(__('Data cannot be saved, some error occur.'));
            }
        } 	
	}
}
