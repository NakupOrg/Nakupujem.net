<?php 

namespace Product\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Photo implements InputFilterAwareInterface
{

	public $id;
	public $product_id;
	public $photo_url;

	protected $inputFilter;

	public function exchangeArray($data)
	{
		$this->id 			= (!empty($data['id']))   			? $data['id']   		: null;
		$this->product_id; 	= (!empty($data['product_id;'])) 	? $data['product_id;'] 	: null;
		$this->photo_url; 	= (!empty($data['photo_url;'])) 	? $data['photo_url;'] 	: null;
	}
	
	public function getArrayCopy()
     {
         return get_object_vars($this);
     }

     public function setInputFilter(InputFilterInterface $inputFilter) {
		throw new Exception("Nepoužité");
		
	}


}