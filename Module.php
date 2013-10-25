<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace IdAuth;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        /* @var \Zend\EventManager\SharedEventManager $sharedEvents */
        $sharedEvents = $eventManager->getSharedManager();
        $sharedEvents->attach('Zend\Mvc\Application', MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'processUnAuth'), 1);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'invokables' => array(
                'idAuth' => 'IdAuth\View\Helper\IdAuth',
            ),
        );
    }

    public function processUnAuth(MvcEvent $e)
    {
        //$d = new \Zend\Debug\Debug(); $d->dump($e->getError());
        $error = $e->getError();
        if ($e->getError() === 'error-route-unauthorized') {
            $sm = $e->getApplication()->getServiceManager();
            $conf = $sm->get('IdAuth\Config');
            if ($conf['settings']['useDifferentLayoutForUnAuth']) {
                $user = new Forms\Login();
                $builder = new \Zend\Form\Annotation\AnnotationBuilder();
                $loginForm = $builder->createForm($user);
                $view = $e->getViewModel();
                $view->loginForm = $loginForm;
                $view->setTemplate('idauth/locked');
                $view->error = $error;
                $auth = $sm->get('IdAuthService');
                $hasIdentity = $auth->hasIdentity();
                if ($hasIdentity) {
                    $view->gravatarEmail = $auth->getIdentity()->getEmail();
                } else {
                    $view->gravatarEmail = null;
                }

                $view->hasIdentity = $auth->hasIdentity();
                $view->identity = $auth->getIdentity();
                $view->route = $e->getRouteMatch()->getMatchedRouteName();
            }
        }
    }
}
