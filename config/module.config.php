<?php

return array(
    'iap' => array(
        'providerOptions' => array(
            'DbTable' => array(
            ),
            'Doctrine' => array(
            ),
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'iap_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Iap/Provider/Doctrine/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Iap\Provider\Doctrine\Entity' => 'iap_entities'
                )
            )
        )
    ),
    'data-fixture' => array(
        'Iap_fixture' => __DIR__ . '/../src/Iap/Fixture',
    ),
    'invokables' => array(
        'Iap\Collector\IapCollector' => 'Iap\Collector\IapCollector',
    ),
    'controllers' => array(
        'invokables' => array(
            'Iap\Controller\User' => 'Iap\Controller\UserController',
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'Iap\Service\IaServiceProvider' => 'Iap\Service\IaServiceProvider',
        ),
        'factories' => array(
            'Iap\Config' => 'Iap\Service\Factory\Config',
            'Iap\Collector' => 'Iap\Service\Factory\Collector',
            'Iap\Provider\DbTable' => 'Iap\Service\Factory\Providers\DbTable',
            'Iap\Provider\Doctrine' => 'Iap\Service\Factory\Providers\Doctrine',
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
                        'may_terminate' => true,
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
                        'may_terminate' => true,
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
                        'may_terminate' => true,
                    ),
                ),
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
