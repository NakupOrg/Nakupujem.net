<?php 
/* **Product Controller** 
* module/Inzerat/src/Inzerat/Controller/ProductController.php
*
* 
*
*
*
*/
namespace Product\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
class ProductController extends AbstractActionController
 {
     public function indexAction()
     {
         return new ViewModel(); 
     }

     public function addAction()
     {
     }

     public function editAction()
     {
     }

     public function deleteAction()
     {
     }
 }
?>