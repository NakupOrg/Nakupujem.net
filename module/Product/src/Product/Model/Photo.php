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
		$this->photo_url 	= (!empty($data['photo_url'])) 		? $data['photo_url'] 	: null;

	}
	
     public function getArrayCopy()
     {
         return get_object_vars($this);
     }


}