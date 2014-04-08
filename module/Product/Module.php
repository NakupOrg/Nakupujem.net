<?php 
namespace Product;

 use Product\Model\Product;
 use Product\Model\ProductTable;
 use Product\Model\Category;
 use Product\Model\CategoryTable;
 use Zend\Db\ResultSet\ResultSet;
 use Zend\Db\TableGateway\TableGateway;


class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    // Add this method:
     public function getServiceConfig()
     {
         return array(
             'factories' => array(
                 'Product\Model\ProductTable' =>  function($sm) {
                     $tableGateway = $sm->get('ProductTableGateway');
                     $table = new ProductTable($tableGateway);
                     return $table;
                 },
                 'ProductTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Product());
                     return new TableGateway('product', $dbAdapter, null, $resultSetPrototype);
                 },
                   'Product\Model\CategoryTable' =>  function($sm)
                {
                    //get the tableGateway just below in his own factory
                    $tableGateway = $sm->get('CategoryTableGateway');
                    //inject the tableGateway in the Table
                    $table = new CategoryTable($tableGateway);
                    return $table;
                },
                //here is the tableGateway Factory for the category
                'CategoryTableGateway' => function($sm)
                {
                    //get adapter to donnect dataBase
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    // create a resultSet
                    $resultSetPrototype = new ResultSet();
                    //define the prototype of the resultSet 
                    // => what object will be cloned to get the results
                    $resultSetPrototype->setArrayObjectPrototype(new Category());
                    //here you define your database table (category) 
                    //when you return the tableGateway to the CategoryTable factory
                    return new TableGateway('category', $dbAdapter, null, $resultSetPrototype);
                },
                'Product\Model\PhotoTable' =>  function($sm)
                {
                    //get the tableGateway just below in his own factory
                    $tableGateway = $sm->get('PhotoTableGateway');
                    //inject the tableGateway in the Table
                    $table = new PhotoTable($tableGateway);
                    return $table;
                },
                'PhotoTableGateway' => function($sm)
                {
                    //get adapter to donnect dataBase
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Photo());
                    return new TableGateway('photos', $dbAdapter, null, $resultSetPrototype);
                },
             ),
         );
     }

}
?>