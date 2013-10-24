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

namespace IdAuth\Adapter;

use IdAuth\Provider\Interfaces\IdentityInterface;
use Zend\Crypt\Password\Bcrypt;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\Result as AuthResult;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

class Doctrine extends AbstractAdapter
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
     * @var mixed
     */
    protected $identity;

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

    /**
     * Performs an authentication attempt
     *
     * @return \Zend\Authentication\Result
     * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface If authentication cannot be performed
     */
    public function authenticate()
    {
        $em = $this->getEntityManager();
        $repo = $em->getRepository($this->entityName);
        $identity = $this->getIdentity();
        $userObject = $repo->findOneBy(array('username' => $identity));
        if (!$userObject) {
            $authCode = AuthResult::FAILURE_IDENTITY_NOT_FOUND;
            $messages = array('A record with the supplied identity could not be found.');
            return new AuthResult($authCode, $identity, $messages);
        }
        $bcrypt = new Bcrypt();
        $bcrypt->setCost(14);
        if (!$bcrypt->verify($this->getCredential(), $userObject->getPassword())) {
            // Password does not match
            $messages = array('Supplied credential is invalid.');
            $authCode = AuthResult::FAILURE_CREDENTIAL_INVALID;
            return new AuthResult($authCode, $identity, $messages);
        }
        $userObject->setName('IdAuth\Adapter\Doctrine');
        $hydrator = new DoctrineObject($em, $this->entityName);
        $hydrator->hydrate($userObject->getRoles(), $userObject);
        return new AuthResult(AuthResult::SUCCESS, $userObject, array('Authentication Successful'));
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

    public function getIdentity()
    {
        return $this->identity;
    }

    public function setIdentity($identity)
    {
        $this->identity = $identity;
    }
}
