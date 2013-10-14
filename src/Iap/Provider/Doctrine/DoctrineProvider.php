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

namespace Iap\Provider\Doctrine;

use Iap\Provider\ProviderResult;
use Iap\Provider\Interfaces\ProviderInterface;
use Zend\Authentication\AuthenticationService;

class DoctrineProvider implements ProviderInterface
{

    protected $serviceManager;

    public function __construct(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceManager = $serviceLocator;
    }

    public function authenticate(array $credentials)
    {
        $username = $credentials['username'];
        $password = $credentials['password'];
        $dbAdapter = $this->serviceManager->get('Zend\Db\Adapter\Adapter');
        $dbTableAuthAdapter = new DbTableAuthAdapter($dbAdapter, 'users', 'username', 'password', 'MD5(?)');
        $dbTableAuthAdapter->setIdentity($username);
        $dbTableAuthAdapter->setCredential($password);

        $authService = new AuthenticationService();
        $authService->setAdapter($dbTableAuthAdapter);
        //$authService->setStorage($this->getServiceManager()->get('Iap\Storage'));

        $authResult = $authService->authenticate();
        $result = new ProviderResult();
        $result->setAuthCode($authResult->getCode());
        $result->setMessages($authResult->getMessages());
        $result->setIsAuthenticated($authResult->isValid());
        $result->setName('Iap\Providers\DbTable');
        $config = $this->serviceManager->get('Config');
        $options = $config['iap']['providerOptions']['DbTable'];
        $result->setOptions($options);

        if ($authResult->isValid()) {
            $result->setIdentity($this->queryIdentity($username));
        }
        return $result;
    }

    public function queryIdentity($username)
    {
        $adapter = $this->serviceManager->get('Zend\Db\Adapter\Adapter');
        $qi = function ($name) use ($adapter) {
                    return $adapter->platform->quoteIdentifier($name);
        };
        $fp = function ($name) use ($adapter) {
                    return $adapter->driver->formatParameterName($name);
        };
        /* @var $statement Zend\Db\Adapter\DriverStatementInterface */
        $statement = $adapter->query('SELECT * FROM ' . $qi('users') . ' WHERE username = ' . $fp('username'));

        /* @var $results Zend\Db\ResultSet\ResultSet */
        $results = $statement->execute(array('username' => $username));

        $user = $results->current();
        $identity = new DbIdentity();
        $identity->setFirstName($user['firstName']);
        $identity->setLastName($user['lastName']);
        $identity->setUsername($username);
        $identity->setEmail($user['email']);
        // Not setting roles right now
        return $identity;
    }

    public function updateIdentity(\Iap\Provider\Interfaces\IdentityInterface $identity)
    {
        return $identity;
    }

    public function resetPassword(array $credentials)
    {
        return false;
    }
}
