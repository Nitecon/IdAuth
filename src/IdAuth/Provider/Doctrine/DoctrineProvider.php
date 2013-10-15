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

namespace IdAuth\Provider\Doctrine;

use IdAuth\Provider\ProviderResult;
use IdAuth\Provider\Interfaces\ProviderInterface;
use IdAuth\Provider\Interfaces\IdentityInterface;
use Zend\Crypt\Password\Bcrypt;
use Zend\ServiceManager\ServiceLocatorInterface;
use Doctrine\ORM\EntityManager;

class DoctrineProvider implements ProviderInterface
{

    /**
     *
     * @var EntityManager
     */
    protected $entityManager;

    /**
     *
     * @var ServiceLocatorInterface
     */
    protected $serviceManager;

    /**
     *
     * @var string
     */
    protected $entityName;

    /**
     *
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     */
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceManager = $serviceLocator;
        $config = $serviceLocator->get('IdAuth\Config');
        $this->entityName = $config['entity_class'];
    }

    public function authenticate(array $credentials)
    {
        $result = new ProviderResult();
        $username = $credentials['username'];
        $password = $credentials['password'];
        $repo = $this->getEntityManager()->getRepository($this->entityName);
        $userObject = $repo->findOneBy(array('username' => $username));
        if (!$userObject) {
            $result->setAuthCode(\Zend\Authentication\Result::FAILURE_IDENTITY_NOT_FOUND);
            $result->setMessages(array('A record with the supplied identity could not be found.'));
            $result->setIsAuthenticated(false);
            return $result;
        }
        $bcrypt = new Bcrypt();
        $bcrypt->setCost(14);
        if (!$bcrypt->verify($password, $userObject->getPassword())) {
            // Password does not match
            $result->setAuthCode(\Zend\Authentication\Result::FAILURE_CREDENTIAL_INVALID);
            $result->setMessages(array('Supplied credential is invalid.'));
            $result->setIsAuthenticated(false);
            return $result;
        }

        $result->setAuthCode(\Zend\Authentication\Result::SUCCESS);
        $result->setMessages(array('Authentication Successful!'));
        $result->setIsAuthenticated(true);
        $result->setName('IdAuth\Providers\Doctrine');
        $config = $this->serviceManager->get('IdAuth\Config');
        $options = $config['providerOptions']['Doctrine'];
        $result->setOptions($options);
        $result->setIdentity($userObject);
        return $result;
    }

    public function updateIdentity(IdentityInterface $identity)
    {
        return $identity;
    }

    public function resetPassword(array $credentials)
    {
        $username = $credentials['username'];
        $password = $credentials['password'];
        $em = $this->getEntityManager()->getRepository($this);
        $bcrypt = new Bcrypt();
        $bcrypt->setCost(14);
        $hash = explode('$', $userObject->getPassword());
        if ($hash[2] === $bcrypt->getCost()) {
            return;
        }

        $userObject->setPassword($bcrypt->create($password));
    }

    /**
     * Sets the EntityManager
     *
     * @param EntityManager $em
     * @access protected
     * @return PostController
     */
    protected function setEntityManager(EntityManager $em)
    {
        $this->entityManager = $em;
        return $this;
    }

    /**
     * Returns the EntityManager
     *
     * Fetches the EntityManager from ServiceLocator if it has not been initiated
     * and then returns it
     *
     * @access protected
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        if (null === $this->entityManager) {
            $this->setEntityManager($this->serviceManager->get('Doctrine\ORM\EntityManager'));
        }
        return $this->entityManager;
    }
}
