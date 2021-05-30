<?php
App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
/**
 * User Model
 *
 */
class User extends AppModel {

    public $validate = array(
        'username' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A username is required'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            )
        ),
        'email' => array(
            'email' => array(
                'rule'    => array('email', true),
                'message' => 'Please supply a valid email address.'
            ),
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A email is required'
            )
        ),

		'address' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Address is required'
			)
		),
		'city' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'City is required'
			)
		),
		'state' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'State is required'
			)
		),
		'country' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Country is required'
			)
		),
		'zipcode' => array(
			'rule' => array('postal', null, 'us')
		),
		'timezone' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Timezone is required'
			)
		),

    );


    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new SimplePasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }
        return true;
    }

}
