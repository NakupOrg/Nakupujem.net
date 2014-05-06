<?php

namespace Product\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Form\Element\File;
use Zend\File\Transfer\Adapter\Http;
class ProductForm extends Form
{
public function __construct($category_options)
{

parent::__construct('product');

$this->add(array(
'name' => 'id',
'type' => 'Hidden',
));
$this->add(array(
'name' => 'photoId',
'type' => 'Hidden',
));

$this->add(array(
'name' => 'title',
'type' => 'text',
'options'=> array(
'label' => 'Názov inzerátu:',
),
));

$this->add(array(
'name' => 'description',
'type' => 'text',
'options' => array(
'label' => 'Popis inzererátu:',
),
));

$this->add(array(
'name' => 'category_id',
'type' => 'Zend\Form\Element\Select',
'options' => array(
'label' => 'Kategória inzerátu:',
'value_options' => $category_options
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
'name' => 'price',
'type' => 'text',
'options' => array(
'label' => 'Cena:',
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
'name' => 'shipping',
'type' => 'text',
'options' => array(
'label' => 'Odosiela do:',
),
));

$this->add(array(
'name' => 'top',
'type' => 'Zend\Form\Element\Select',
'options' => array(
'label' =>'Topovať inzerát?',
'value_options' => array(
'nie' => 'Nie',
'ano' => 'Áno'
),
),
));

$this->add(array(
'name' => 'foto1',
'attributes' => array(
'type' => 'file',
),
'options' => array(
'label' => 'Fotky:',
),
));

$this->add(array(
'name' => 'foto2',
'attributes' => array(
'type' => 'file',
),
'options' => array(
'label' => 'Fotky:',
),
));

$this->add(array(
'name' => 'foto3',
'attributes' => array(
'type' => 'file',
),
'options' => array(
'label' => 'Fotky:',
),
));

$this->add(array(
'name' => 'foto4',
'attributes' => array(
'type' => 'file',
),
'options' => array(
'label' => 'Fotky:',
),
));

$this->add(array(
'name' => 'foto5',
'attributes' => array(
'type' => 'file',
),
'options' => array(
'label' => 'Fotky:',
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