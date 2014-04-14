<?php 

namespace Product\Model;


class Photo
{

	public $id;
	public $product_id;
	public $photo_url;

	public function exchangeArray($data)
	{
		$this->id 			= (!empty($data['id']))   			? $data['id']   		: null;
		$this->product_id 	= (!empty($data['product_id'])) 	? $data['product_id'] 	: null;
<<<<<<< HEAD
		$this->photo_url 	= (!empty($data['photo_url'])) 	? $data['photo_url'] 	: null;
=======
		$this->photo_url 	= (!empty($data['photo_url'])) 		? $data['photo_url'] 	: null;
>>>>>>> e60f83880f3615d2939b56ae8d11dc3346de0711
	}
	
     public function getArrayCopy()
     {
         return get_object_vars($this);
     }


}