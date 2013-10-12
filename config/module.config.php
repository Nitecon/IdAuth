<?php

return array(
    /* 'doctrine' => array(
      'driver' => array(
      'iap_entities' => array(
      'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
      'paths' => array(__DIR__ . '/../src/Iap/Entity')
      ),
      'orm_default' => array(
      'drivers' => array(
      'Iap\Entity' => 'iap_entities'
      )
      )
      )
      ), */
    'invokables' => array(
        'Iap\Collector\IapCollector' => 'Iap\Collector\IapCollector',
    ),
    'controllers' => array(
        'invokables' => array(
            'Iap\Controller\User' => 'Iap\Controller\UserController',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Iap\Config' => 'Iap\Service\Factory\Config',
            'Iap\Collector' => 'Iap\Service\Factory\Collector',
            'Iap\Provider\DbTable' => 'Iap\Service\Factory\Providers\DbTable',
            'Iap\Storage' => 'Iap\Service\Factory\Storage',
            'Iap\Session' => 'Iap\Service\Factory\Storage\Session',
            'IapService' => 'Iap\Service\Factory\IapService',
        ),
    ),
    'router' => array(
        'routes' => array(
            'iap' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/user',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Iap\Controller',
                        'controller' => 'User',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'auth' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/authenticate',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Iap\Controller',
                                'controller' => 'User',
                                'action' => 'authenticate',
                            ),
                        ),
                    ),
                    'login' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/login',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Iap\Controller',
                                'controller' => 'User',
                                'action' => 'login',
                            ),
                        ),
                    ),
                    'logout' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/logout',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Iap\Controller',
                                'controller' => 'User',
                                'action' => 'logout',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'Iap' => array(
        'providerOptions' => array(
            'DbTable' => array(
            ),
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => \TRUE,
        'display_exceptions' => \TRUE,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'zend-developer-tools/toolbar/iap' => __DIR__ . '/../view/zend-developer-tools/toolbar/iap.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'zenddevelopertools' => array(
        'profiler' => array(
            'collectors' => array(
                'iap' => 'IapCollector',
            ),
        ),
        'toolbar' => array(
            'entries' => array(
                'iap' => 'zend-developer-tools/toolbar/iap'
            )
        )
    ),
);
