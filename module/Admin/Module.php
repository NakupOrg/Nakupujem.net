<?php 
namespace Admin;

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
   /*  public function getServiceConfig()
     {

     } */
     public function getServiceConfig()
     {
         return array(
             'abstract_factories' => array(),
             'aliases' => array(),
             'factories' => array(
                 'Admin\Model\AdminTable' =>  function($sm) {
                     $tableGateway = $sm->get('AdminTableGateway');
                     $table = new AdminTable($tableGateway);
                     return $table;
                 },
                 'AdminTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Admin());
                     return new TableGateway('user', $dbAdapter, null, $resultSetPrototype);
                 },
                ),
             );
     }

}
?>