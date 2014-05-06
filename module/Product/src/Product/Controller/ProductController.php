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
 use Product\Model\Photo;
  use Product\Model\PhotoTable;



class ProductController extends AbstractActionController
 {
    protected $productTable;
    protected $categoryTable;
    public $category;
    public $photoTable;

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
    public function getPhotoTable(){
        if(!$this->photoTable){
            $this->photoTable = $this->getServiceLocator()
                 ->get('Product\Model\PhotoTable');
        }
        return $this->photoTable;
    }
    public function getFileUploadLocation()
    {
    // Fetch Configuration from Module Config
    $config = $this->getServiceLocator()->get('config');
    return $config['module_config']['upload_location'];
    }


     public function indexAction()
     {
          return new ViewModel(array(
             'products' => $this->getProductTable()->fetchAll(),
             'categories' => $this->getCategoryTable()->getCategoryNames(),
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
             $product = $this->getProductTable()->getProduct($id);
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

        $uploadFile = $this->params()->fromFiles('foto1');
        
        $categories = $this->getCategoryTable()->fetchAll();
        $category_options = array();
           foreach ($categories as $category) {
                $category_options[$category->id] = $category->name;
            }
         $form = new ProductForm($category_options);
         $form->get('submit')->setValue('Pridať inzerát');

         $request = $this->getRequest();
         if ($request->isPost()) {

            $uploadPath = $this->getFileUploadLocation();
            // Save Uploaded file
            $adapter = new \Zend\File\Transfer\Adapter\Http();
            $adapter->setDestination($uploadPath);
            //if ($adapter->receive($uploadFile['name'])) {

             $product = new Product();
             $form->setInputFilter($product->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                $product->exchangeArray($form->getData());
                $this->getProductTable()->saveProduct($product);
                $data = array();
                $data = $form->getData();
                 return $this->redirect()->toRoute('product');
                }
             //}
         }
         return array('form' => $form);
     }

     public function editAction()
     {
        $id = (int) $this->params()->fromRoute('id',0);
        if(!$id)
        {
            return $this->redirect()->toRoute('product', array(
                'action' => 'add'
                ));
        }

        try
        {
          $product = $this->getProductTable()->getProduct($id);
          $category = $this->getCategoryTable()->getCategory($product->category_id);
        }

        catch(\Exception $ex)
        {
            return $this->redirect()->toRoute('product', array(
                'action' => 'index'
                ));
        }
        $categories = $this->getCategoryTable()->fetchAll();
        $category_options = array();
           foreach ($categories as $category) {
                $category_options[$category->id] = $category->name;
            }

        $form = new ProductForm($category_options);
        $form->bind($product);
        $form->get('submit')->setAttribute('value', 'Edituj')->setAttribute('class', 'btn btn-primary');

        $request = $this->getRequest();
        if($request->isPost())
        {
            $form->setInputFilter($product->getInputFilter());
            $form->setData($request->getPost());

            if($form->isValid())
            {
                $this->getProductTable()->saveProduct($product);
                //Redirect po ulozeni
                return $this->redirect()->toRoute('product');
            }
        }

        return array(
            'id' => $id,
            'form' => $form
            );

     }

     public function deleteAction()
     {
        $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id)
        {
            return $this->redirect()->toRoute('product');
        }
        // ......
        $request = $this->getRequest();
        
        if ($request->isPost())
        {
            $del = $request->getPost('del', 'No');
        if ($del == 'Yes')
            {
            $id = (int) $request->getPost('id');
            $this->getProductTable()->deleteProduct($id);
            }

        return $this->redirect()->toRoute('product');
        }
        return array(
             'id' => $id,
             'product' => $this->getProductTable()->getProduct($id)
         );
     }

     public function categoriesAction()
     {
        return new ViewModel(array(
           'categories' => $this->getCategoryTable()->fetchAll(),
            ));

     }

     public function categoryAction()
     {
        $category_id = (int) $this->params()->fromRoute('id', 0);
        if (!$category_id)
        {
            return $this->redirect()->toRoute('product', array(
                'action' => 'categories'
                ));
        }

         try {
             $product = $this->getProductTable()->getProductsByCategory($category_id);
             $category = $this->getCategoryTable()->getCategory($category_id);
         }
         catch (\Exception $ex) {
             
             return $this->redirect()->toRoute('product', array(
                 'action' => 'categories'
             ));
         }

         return new ViewModel(array(
            'products' => $product,
            'category' => $category,
            ));
     }
}
?>