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
 use ZfcUser\Service\User as UserService;
 use ZfcUser\Options\UserControllerOptionsInterface;



class ProductController extends AbstractActionController
 {
    protected $productTable;
    protected $categoryTable;
    protected $photoTable;
    protected $userTable;
    protected $auth;
    public $category;

    public function random()
    {
        return rand(000000000000000,999999999999999).rand(000000000000000,999999999999999);
    }

    public function loadPhotos($photo_id)
    {
        $uploadPath = $this->getFileUploadLocation();
        if(!empty($_FILES[$photo_id]["name"]))
        {
            $foto = $_FILES[$photo_id]["name"].$this->random();
            $tmp_name = $_FILES[$photo_id]['tmp_name'];
            $error = $_FILES[$photo_id]['error'];
            move_uploaded_file($tmp_name,$uploadPath.$foto);
            return $foto;
        }
        else
        {
            return;
        }
    }

    public function getProductTable()
     {
        if (!$this->productTable) {
             $sm = $this->getServiceLocator();
             $this->productTable = $sm->get('Product\Model\ProductTable');
         }
         return $this->productTable;
     }

    public function getAuthService()
    {
        $sm = $app->getServiceManager();
        $this->auth = $sm->get('zfcuser_auth_service');
        return $this->auth;
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

    public function getUserTable()
    {
       if (!$this->userTable) {
            $sm = $this->getServiceLocator();
            $this->userTable = $sm->get('User\Model\UserTable');
        }
        return $this->userTable;
     }

    public function getFileUploadLocation()
    {
    // Fetch Configuration from Module Config
    $config = $this->getServiceLocator()->get('config');
    return $config['module_config']['upload_location'];
    }

    public function deletePhotos($photo_id, $id)
    {
            $product = $this->getProductTable()->getProduct($id);
            unlink('D:/Server/htdocs/nakupujem/Nakupujem.net/public/img/uploads/'.$product->$photo_id);
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
        if($this->zfcUserAuthentication()->hasIdentity()){
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
                
                $data['user_id'] = $this->zfcUserAuthentication()->getIdentity()->getId();
                $data["foto1"] = $this->loadPhotos("foto1");
                $data["foto2"] = $this->loadPhotos("foto2");
                $data["foto3"] = $this->loadPhotos("foto3");
                $data["foto4"] = $this->loadPhotos("foto4");
                $data["foto5"] = $this->loadPhotos("foto5");

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
        else return $this->redirect()->toRoute('zfcuser/login');
     }

     public function editAction()
     {
        $id = (int) $this->params()->fromRoute('id',0);
        if(!$this->zfcUserAuthentication()->hasIdentity()){
           return $this->redirect()->toRoute('zfcuser/login');
        }


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
        if ($product->user_id == $this->zfcUserAuthentication()->getIdentity()->getId()) {
            
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

        else 
        {
            return $this->redirect()->toRoute('product');
        }

        
    }


     

     public function deleteAction()
     {
        if(!$this->zfcUserAuthentication()->hasIdentity()){
           return $this->redirect()->toRoute('zfcuser/login');
        }

        $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id)
        {
            return $this->redirect()->toRoute('product');
        }
        $product = $this->getProductTable()->getProduct($id);
        if ($product->user_id == $this->zfcUserAuthentication()->getIdentity()->getId()) {

        $request = $this->getRequest();
        
        if ($request->isPost())
        {
            $del = $request->getPost('del', 'No');
        if ($del == 'Yes')
            {    
            $id = (int) $request->getPost('id');
            $this->deletePhotos('foto1', $id);
            $this->deletePhotos('foto2', $id);
            $this->deletePhotos('foto3', $id);
            $this->deletePhotos('foto4', $id);
            $this->deletePhotos('foto5', $id);
            $this->getProductTable()->deleteProduct($id);
            }

        return $this->redirect()->toRoute('product');
        }
        return array(
             'id' => $id,
             'product' => $this->getProductTable()->getProduct($id)
         );
        }

        else 
        {
            return $this->redirect()->toRoute('product');
        }
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