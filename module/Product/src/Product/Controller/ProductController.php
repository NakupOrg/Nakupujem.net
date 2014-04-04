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
    protected $categoryTable;

    public function getProductTable()
     {
        if (!$this->productTable) {
             $sm = $this->getServiceLocator();
             $this->productTable = $sm->get('Product\Model\ProductTable');
         }
         return $this->productTable; 
     }

    public function getCategoryTable() {
        if(!$this->categoryTable){
            $this->categoryTable = $this->getServiceLocator()
                ->get('Product\Model\CategoryTable');
        }
        return $this->categoryTable;
    }


     public function indexAction()
     {
          return new ViewModel(array(
             'products' => $this->getProductTable()->fetchAll(),
             )); 
     }

     public function showAction()
     {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
             return $this->redirect()->toRoute('product', array(
                 'action' => 'add'
             ));
        }

        try {
             $product  = $this->getProductTable()->getProduct($id);
             $category = $this->getCategoryTable()->getCategory($product->category_id);
         }
         catch (\Exception $ex) {
             
             return $this->redirect()->toRoute('product', array(
                 'action' => 'index'
             ));
         }


       return new ViewModel(array(
             'product' => $product,
             'category' => $category,
             ));  
     }

     public function addAction()
     {
        
        $categories = $this->getCategoryTable()->fetchAll();
        $category_options = array();
           foreach ($categories as $category) {
                $category_options[$category->id] = $category->name;
            }
         $form = new ProductForm($category_options);
         $form->get('submit')->setValue('Pridať inzerát');

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