<?php 
/* **Product Controller** 
* module/Product/src/Product/Controller/ProductController.php
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
          return new ViewModel(array(
             'products' => $this->getAlbumTable()->fetchAll(),
             )); 
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

     public function getProductTable()
     {
         if (!$this->productTable) {
             $sm = $this->getServiceLocator();
             $this->productTable = $sm->get('Product\Model\ProductTable');
         }
         return $this->productTable;
     }
 }
?>