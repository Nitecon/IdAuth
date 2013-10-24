<?php

/**
 * Copyright (c) 2013 Will Hattingh (https://github.com/Nitecon
 *
 * For the full copyright and license information, please view
 * the file LICENSE.txt that was distributed with this source code.
 *
 * @author Will Hattingh <w.hattingh@nitecon.com>
 *
 *
 */

namespace IdAuth\Collector;

use Serializable;
use Zend\Mvc\MvcEvent;
use ZendDeveloperTools\Collector\CollectorInterface;

/**
 * IdAuth data collector - dumps the contents of the `Config` and `ApplicationConfig` services
 */
class IdAuthCollector implements CollectorInterface, Serializable
{

    const NAME = 'idAuth';
    const PRIORITY = 150;

    /**
     * @var array|null
     */
    protected $collectedUser = array();

    /**
     *
     * @var \Zend\ServiceManager\ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return static::NAME;
    }

    /**
     * {@inheritDoc}
     */
    public function getPriority()
    {
        return static::PRIORITY;
    }

    /**
     * {@inheritDoc}
     */
    public function collect(MvcEvent $mvcEvent)
    {
        if (!$application = $mvcEvent->getApplication()) {
            return;
        }
        $this->serviceLocator = $application->getServiceManager();


        if ($this->serviceLocator->has('Config')) {
            $this->collectedUser = $this->getUserDetails();
        }
    }

    public function getUserDetails()
    {
        $authService = $this->serviceLocator->get('IdAuthService');
        $userDetails = array(
            "firstName" => 'Anonymous',
            'lastName' => 'User',
            "email" => 'anonymous@nowhere.com',
            "identity" => 'Anonymous',
            "hasIdentity" => false,
            "extended" => false,
            "currentProvider" => "None",
        );

        if ($authService->hasIdentity()) {
            $userDetails['hasIdentity'] = true;

            if (method_exists($authService, 'getIdentity')) {
                $user = $authService->getIdentity();
                $userDetails['currentProvider'] = $user->getName();
                if (method_exists($user, 'getFirstName')) {
                    $userDetails['firstName'] = $user->getFirstName();
                    $userDetails['extended'] = true;
                }
                if (method_exists($user, 'getLastName')) {
                    $userDetails['lastName'] = $user->getLastName();
                    $userDetails['extended'] = true;
                }
                if (method_exists($user, 'getEmail')) {
                    $userDetails['email'] = $user->getEmail();
                    $userDetails['extended'] = true;
                }
                if (is_string($user)) {
                    $userDetails['identity'] = $user;
                }
                if (method_exists($user, "getRoles")) {
                    if (is_array($user->getRoles()) && count($user->getRoles()) > 0) {
                        $userDetails['roles'] = $user->getRoles();
                    }
                }
            }
        }

        return $userDetails;
    }

    /**
     * @return array|string[]
     */
    public function getCollectedUser()
    {
        return $this->collectedUser;
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {
        return serialize(array('user' => $this->collectedUser));
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($serialized)
    {
        $this->collectedUser = unserialize($serialized);
    }
}
