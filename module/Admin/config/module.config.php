<?php
  return array(
      'controllers' => array(
          'invokables' => array(
              'Admin\Controller\Admin' => 'Admin\Controller\AdminController',
           ),
      ),
      'router' => array(
            'routes' => array(
                'admin' => array(
                    'type' => 'segment',
                    'options' => array(
                        'route' => '/admin[/][:action][/][:id]',
                        'constraits' => array(
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'id' => '[0-9]+'
                        ),
                        'defaults' => array(
                            'controller' => 'Admin\Controller\Admin',
                            'action'     => 'index',
                        ),
                    ),
                ),
            ),
      ),                 
      
      'view_manager' => array(
        'template_path_stack' => array(
              'admin' => __DIR__ . '/../view',
              
        ),
    ),
      // MODULE CONFIGURATIONS
    'module_config' => array(
    'upload_location' => 'D:/Server/htdocs/nakupujem/Nakupujem.net/public/img/uploads/',
    //miso cesta D:/GitHub/Nakupujem/zf/public/img/uploads/
    // fero cesta D:/Server/htdocs/nakupujem/Nakupujem.net/public/img/uploads/
    ),
  );
?>