<?php 

namespace User\Model;


class User 
{

	public $user_id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;
	public $location;
	public $email;
	public $phone;

	protected $inputFilter;

	public function exchangeArray($data)
	{
		$this->user_id 	  = (!empty($data['user_id']))    ? $data['user_id']    : null;
		$this->username   = (!empty($data['username']))   ? $data['username'] 	: null;
		$this->first_name = (!empty($data['first_name'])) ? $data['first_name'] : null;
		$this->last_name  = (!empty($data['last_name']))  ? $data['last_name'] 	: null;
		$this->location   = (!empty($data['location']))   ? $data['location'] 	: null;
		$this->email      = (!empty($data['email'])) 	  ? $data['email'] 		: null;
		$this->phone      = (!empty($data['phone'])) 	  ? $data['phone'] 		: null;
	}


	public function getArrayCopy()
    {
        return get_object_vars($this);
    }


}