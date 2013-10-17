<?php

return array(
    'idAuth' => array(
        'providerOptions' => array(
            'DbTable' => array(
            ),
            'Doctrine' => array(
            ),
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'idAuth_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/IdAuth/Provider/Doctrine/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'IdAuth\Provider\Doctrine\Entity' => 'idAuth_entities'
                )
            )
        )
    ),
    'data-fixture' => array(
        'IdAuth_fixture' => __DIR__ . '/../src/IdAuth/Fixture',
    ),
    'invokables' => array(
        'IdAuth\Collector\IdAuthCollector' => 'IdAuth\Collector\IdAuthCollector',
    ),
    'controllers' => array(
        'invokables' => array(
            'IdAuth\Controller\User' => 'IdAuth\Controller\UserController',
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'IdAuth\Service\IaServiceProvider' => 'IdAuth\Service\IaServiceProvider',
        ),
        'factories' => array(
            'IdAuth\Config' => 'IdAuth\Service\Factory\Config',
            'IdAuth\Collector' => 'IdAuth\Service\Factory\Collector',
            'IdAuth\Adapter\DbTable' => 'IdAuth\Service\Factory\Adapter\DbTable',
            'IdAuth\Adapter\Doctrine' => 'IdAuth\Service\Factory\Adapter\Doctrine',
            'IdAuth\Storage' => 'IdAuth\Service\Factory\Storage',
            'IdAuth\Session' => 'IdAuth\Service\Factory\Storage\Session',
            'IdAuthService' => 'IdAuth\Service\Factory\IdAuthService',
        ),
    ),
    'router' => array(
        'routes' => array(
            'idAuth' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/user',
                    'defaults' => array(
                        '__NAMESPACE__' => 'IdAuth\Controller',
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
                                '__NAMESPACE__' => 'IdAuth\Controller',
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
                                '__NAMESPACE__' => 'IdAuth\Controller',
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
                                '__NAMESPACE__' => 'IdAuth\Controller',
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
        'template_map' => include __DIR__ . '/../template_map.php',
    ),
    'zenddevelopertools' => array(
        'profiler' => array(
            'collectors' => array(
                'idAuth' => 'IdAuthCollector',
            ),
        ),
        'toolbar' => array(
            'entries' => array(
                'idAuth' => 'zend-developer-tools/toolbar/idAuth'
            )
        )
    ),
);
