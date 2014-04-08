<?php 

namespace User\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class UserForm extends Form
{
	public function __construct()
	{

		parent::__construct('user');

		$this->add(array(
			'name' => 'id',
			'type' => 'Hidden',
		));

		$this->add(array(
			'name' => 'username',
			'type' => 'text',
			'options'=> array(
				'label' => 'Užívateľské meno:',
			),
		));

		$this->add(array(
			'name' => 'password',
			'type' => 'Zend\Form\Element\Password',
			'options' => array(
				'label' => 'Heslo:',
			),
		));

		$this->add(array(
			'name' => 'first_name',
			'type' => 'text',
			'options' => array(
				'label' => 'Meno:',
				),
			));

		$this->add(array(
			'name' => 'last_name',
			'type' => 'text',
			'options' => array(
				'label' => 'Priezvisko:',
			),
		));

		$this->add(array(
			'name' => 'phone',
			'type' => 'text',
			'options' => array(
				'label' => 'Telefónne číslo:',
			),
		));

		$this->add(array(
			'name' => 'email',
			'type' => 'text',
			'options' => array(
				'label' => 'Email:',
			),
		));


		$this->add(array(
			'name' => 'location',
			'type' => 'text',
			'options' => array(
				'label' => 'Mesto:',
			),
		));

		$this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Choď',
                 'id' => 'submitbutton',
                 'class' => 'btn btn-primary'
             ),
         ));
	}

}

?>