<?php 

//Product Model class

namespace Product\Model;

class Product 
{
	public $id;
	public $title;
	public $description;
	public $phone;
	public $email;
	public $location;
	public $shipping;
	public $user_id;
	public $price;
	public $date;
	public $view_counter;


	public function exchangeArray($data) {
		/*Exchange data from database to class variables */
		$this->id 	 	   	= (!empty($data['id'])) 		  ? $data['id'] 		  : null;
		$this->title 	   	= (!empty($data['title'])) 		  ? $data['title'] 		  : null;
		$this->description 	= (!empty($data['description']))  ? $data['description']  : null;
		$this->phone  	   	= (!empty($data['phone'])) 		  ? $data['phone'] 		  : null;
		$this->email 	   	= (!empty($data['email'])) 	 	  ? $data['email'] 		  : null;
		$this->location    	= (!empty($data['location'])) 	  ? $data['location'] 	  : null;
		$this->shipping    	= (!empty($data['shipping'])) 	  ? $data['shipping'] 	  : null;
		$this->user_id     	= (!empty($data['user_id'])) 	  ? $data['user_id'] 	  : null;
		$this->price       	= (!empty($data['price'])) 		  ? $data['price'] 		  : null;
		$this->date 	   	= (!empty($data['date'])) 		  ? $date['date'] 		  : null;
		$this->view_counter = (!empty($data['view_counter'])) ? $data['view_counter'] : null;
	}
}


?>