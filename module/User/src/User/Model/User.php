<?php 

namespace User\Model;

class User 
{

	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;
	public $location;
	public $email;
	public $phone;

	public function exchangeArray($data)
	{
		$this->id 		  = (!empty($data['id'])) 		  ? $data['id'] 		: null;
		$this->username   = (!empty($data['username']))   ? $data['username'] 	: null;
		$this->password   = (!empty($data['password']))   ? $data['password'] 	: null;
		$this->first_name = (!empty($data['first_name'])) ? $data['first_name'] : null;
		$this->last_name  = (!empty($data['last_name']))  ? $data['last_name'] 	: null;
		$this->location   = (!empty($data['location']))   ? $data['location'] 	: null;
		$this->email      = (!empty($data['email'])) 	  ? $data['email'] 		: null;
		$this->phone      = (!empty($data['phone'])) 	  ? $data['phone'] 		: null;
	}
}