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
 use Zend\Form\Form;
 use Zend\Form\Element;



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
            
            $data = $this->getRequest()->getPost();
            $uploadPath = $this->getFileUploadLocation();

            /*$data = array_merge_recursive(
            $request->getPost()->toArray()
            );*/
             $product = new Product();
             
                $randomId1 = rand(0,999999999999999);
                $randomId11= rand(0,999999999999999);
                $foto1 = $_FILES["foto1"]["name"].$randomId1.$randomId11;
                $tmp_name1 = $_FILES['foto1']['tmp_name'];
                $error1 = $_FILES['foto1']['error'];
                move_uploaded_file($tmp_name1,$uploadPath.$foto1);
                $data['foto1'] = $foto1;


                $randomId2 = rand(000000000000000,999999999999999);
                $randomId21= rand(000000000000000,999999999999999);
                $foto2 = $_FILES["foto2"]["name"].$randomId2.$randomId21;
                $tmp_name2 = $_FILES['foto2']['tmp_name'];
                $error2 = $_FILES['foto2']['error'];
                move_uploaded_file($tmp_name2,$uploadPath.$foto2);
                $data['foto2'] = $foto2;

                $randomId3 = rand(000000000000000,999999999999999);
                $randomId31= rand(000000000000000,999999999999999);
                $foto3 = $_FILES["foto3"]["name"].$randomId3.$randomId31;
                $tmp_name3 = $_FILES['foto3']['tmp_name'];
                $error3 = $_FILES['foto3']['error'];
                move_uploaded_file($tmp_name3,$uploadPath.$foto3);
                $data['foto3'] = $foto3;

                $randomId4 = rand(000000000000000,999999999999999);
                $randomId41= rand(000000000000000,999999999999999);
                $foto4 = $_FILES["foto4"]["name"].$randomId4.$randomId41;
                $tmp_name4 = $_FILES['foto4']['tmp_name'];
                $error4 = $_FILES['foto4']['error'];
                move_uploaded_file($tmp_name4,$uploadPath.$foto4);
                $data['foto4'] = $foto4;

                $randomId5 = rand(000000000000000,999999999999999);
                $randomId51= rand(000000000000000,999999999999999);
                $foto5 = $_FILES["foto5"]["name"].$randomId5.$randomId51;
                $tmp_name5 = $_FILES['foto5']['tmp_name'];
                $error5 = $_FILES['foto5']['error'];
                move_uploaded_file($tmp_name5,$uploadPath.$foto5);
                $data['foto5'] = $foto5;
                $form->setInputFilter($product->getInputFilter());
                $form->setData($data);


             if ($form->isValid()) {
                $data = $form->getData();
                $product->exchangeArray($form->getData());
                $this->getProductTable()->saveProduct($product);     
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