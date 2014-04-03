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
 use Product\Model\Product;
 use Product\Form\ProductForm;



class ProductController extends AbstractActionController
 {
    protected $productTable;

    public function getProductTable()
     {
        if (!$this->productTable) {
             $sm = $this->getServiceLocator();
             $this->productTable = $sm->get('Product\Model\ProductTable');
         }
         return $this->productTable; 
     }

     public function indexAction()
     {
          return new ViewModel(array(
             'products' => $this->getProductTable()->fetchAll(),
             )); 
     }

     public function addAction()
     {
        $form = new ProductForm();
         $form->get('submit')->setValue('Add');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $product = new Product();
             $form->setInputFilter($product->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $product->exchangeArray($form->getData());
                 $this->getProductTable()->saveProduct($product);

                 // Redirect to list of albums
                 return $this->redirect()->toRoute('product');
             }
         }
         return array('form' => $form);
     }

     public function editAction()
     {
     }

     public function deleteAction()
     {
     }

     
 }
?>