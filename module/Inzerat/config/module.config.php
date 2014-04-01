<?php
  return array(
      'controllers' => array(
          'invokables' => array(
              'Inzerat\Controller\Product' => 'Inzerat\Controller\ProductController',
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
                            'controller' => 'Inzerat\Controller\Product',
                            'action'     => 'index',
                        ),
                    ),
                ),
            ),
      ),                 
      
      'view_manager' => array(
          'template_path_stack' => array(
              'product' => __DIR__ . '/../view',
          ),
      ),
  );
?>