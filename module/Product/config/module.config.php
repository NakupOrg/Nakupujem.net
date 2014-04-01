<?php
  return array(
      'controllers' => array(
          'invokables' => array(
              'Product\Controller\Product' => 'Product\Controller\ProductController',
           ),
      ),
      'router' => array(
            'routes' => array(
                'product' => array(
                    'type' => 'segment',
                    'options' => array(
                        'route' => '/product[/][:action][/][:id]',
                        'constraits' => array(
                            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'id' => '[0-9]+'
                        ),
                        'defaults' => array(
                            'controller' => 'Product\Controller\Product',
                            'action'     => 'index',
                        ),
                    ),
                ),
            ),
      ),                 
      
      'view_manager' => array(
          'template_path_stack' => array(
              'Product' => __DIR__ . '/../view',
          ),
      ),
      'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'product/product/index'   => __DIR__ . '/../view/product/product/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
  );
?>