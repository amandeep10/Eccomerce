<?php
App::uses('AppModel', 'Model');
/**
 * Login Model
 *
 * @property State $State
 * @property Country $Country
 * @property UserRole $UserRole
 * @property Application $Application
 * @property CandidateData $CandidateData
 * @property Communication $Communication
 * @property Contact $Contact
 * @property Document $Document
 */
class Login extends AppModel {
	var $useTable = 'users';
	
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validateLogin = array(
        'email' => array(
			'notempty' => array(
				'rule' => 'notempty',
				'required' => true,
				'message' => 'Email is a required field.'
			),
			'email' => array(
				'rule' => 'email',
				'required' => true,
				'message' => 'Invalid Email ID.'
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => 'notempty',
				'required' => true,
				'message' => 'Password is a required field.'
			),
			'rule1' => array(
				'rule'    => array('minLength', '6'),
				'required' => true,
				'message' => 'Minimum Length of password is 6.'
			),
			'rule2' => array(
				'rule'     => array('maxLength','20'),
                'required' => true,
                'message'  => 'Maximum Length of password is 20.'
			),
		),
    );
	


}
