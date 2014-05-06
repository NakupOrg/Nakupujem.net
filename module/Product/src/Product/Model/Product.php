<?php 

//Product Model class

namespace Product\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


class Product implements InputFilterAwareInterface
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
    public $top;
    public $category_id;
    public $foto1;
    public $foto2;
    public $foto3;
    public $foto4;
    public $foto5;


	protected $inputFilter;


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
		//$this->date 	   	= (!empty($data['date'])) 		  ? $date['date'] 		  : null;
		$this->view_counter = (!empty($data['view_counter'])) ? $data['view_counter'] : null;
        $this->top          = (!empty($data['top']))          ? $data['top']          : null;
        $this->category_id  = (!empty($data['category_id']))  ? $data['category_id']  : null;
        $this->foto1        = (!empty($data['foto1']))        ? $data['foto1']        : null;
        $this->foto2        = (!empty($data['foto2']))        ? $data['foto2']        : null;
        $this->foto3        = (!empty($data['foto3']))        ? $data['foto3']        : null;
        $this->foto4        = (!empty($data['foto4']))        ? $data['foto4']        : null;
        $this->foto5        = (!empty($data['foto5']))        ? $data['foto5']        : null;

	}

     public function getArrayCopy()
     {
         return get_object_vars($this);
     }


	public function setInputFilter(InputFilterInterface $inputFilter) {
		throw new Exception("Nepoužité");
		
	}

	public function getInputFilter() {
		if(!$this->inputFilter) {
			$inputFilter = new InputFilter();

			$inputFilter->add(array(
				'name' => 'id',
				'required' => true,
				'filters' => array(
					array('name' => 'Int'),
				),
			));

			$inputFilter->add(array(
                 'name'     => 'title',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));

			$inputFilter->add(array(
                 'name'     => 'description',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));

			$inputFilter->add(array(
                 'name'     => 'phone',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));

			$inputFilter->add(array(
                 'name'     => 'email',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));

			$inputFilter->add(array(
                 'name'     => 'price',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));

			$inputFilter->add(array(
                 'name'     => 'location',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));

			$inputFilter->add(array(
                 'name'     => 'shipping',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));

            $inputFilter->add(array(
                'name' => 'top',
                'required' => true,
            ));




			$this->inputFilter = $inputFilter;
		}

		return $this->inputFilter;
	}

}


?>