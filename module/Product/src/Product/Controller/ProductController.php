<?php
/* **Product Controller**
* module/Product/src/Product/Controller/ProductController.php
*/
namespace Product\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Product\Model\Product;
 use Product\Form\ProductForm;
 use Zend\Form\Form;
 use Zend\Form\Element;



class ProductController extends AbstractActionController
 {
    protected $productTable;
    protected $categoryTable;
    protected $photoTable;
    protected $userTable;
    public $category;

    public function random()
    {
        return rand(000000000000000,999999999999999).rand(000000000000000,999999999999999);
    }

    public function loadFotos($photo_id)
    {
        $uploadPath = $this->getFileUploadLocation();
        $foto = $_FILES[$photo_id]["name"].$this->random();
        $tmp_name = $_FILES[$photo_id]['tmp_name'];
        $error = $_FILES[$photo_id]['error'];
        move_uploaded_file($tmp_name,$uploadPath.$foto);
        return $foto;
    }

    public function getProductTable()
     {
        if (!$this->productTable) {
             $sm = $this->getServiceLocator();
             $this->productTable = $sm->get('Product\Model\ProductTable');
         }
         return $this->productTable;
     }

    public function getUserTable()
    {
       if (!$this->userTable) {
            $sm = $this->getServiceLocator();
            $this->userTable = $sm->get('User\Model\UserTable');
        }
        return $this->userTable;
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

    public function random_string($length) 
    {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $key;
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
             $user = $this->getUserTable()->getUser($product->user_id);
         }
         catch (\Exception $ex) {
             
             return $this->redirect()->toRoute('product', array(
                 'action' => 'index'
             ));
         }


       return new ViewModel(array(
             'product' => $product,
             'category' => $category,
             'user' => $user,
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
            
            $data = $this->getRequest()->getPost();

             $product = new Product();
             

                $data["foto1"] = $this->loadFotos("foto1");
                $data["foto2"] = $this->loadFotos("foto2");
                $data["foto3"] = $this->loadFotos("foto3");
                $data["foto4"] = $this->loadFotos("foto4");
                $data["foto5"] = $this->loadFotos("foto5");

                $form->setInputFilter($product->getInputFilter());
                $form->setData($data);

             if ($form->isValid()) {
                $data = $form->getData();
                $product->exchangeArray($form->getData());
                $this->getProductTable()->saveProduct($product);     
                return $this->redirect()->toRoute('product');             
            }
            
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
        $request = $this->getRequest();
        
        if ($request->isPost())
        {
            $del = $request->getPost('del', 'No');
        if ($del == 'Yes')
            {    
            $id = (int) $request->getPost('id');
            $product = $this->getProductTable()->getProduct($id);
            unlink('D:/GitHub/Nakupujem/zf/public/img/uploads/'.$product->foto1);
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