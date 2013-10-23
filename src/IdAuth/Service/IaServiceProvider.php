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

namespace IdAuth\Service;

use Zend\Authentication\Storage\StorageInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IAServiceProvider extends \Zend\Authentication\AuthenticationService
{

    /**
     * An array of available providers
     * @var array
     */
    protected $availProviders;
    protected $chainResult;

    /**
     *  This is the identity to be returned and should implement ZfcRbac\Identity\IdentityInterface
     * @var ZfcRbac\Identity\IdentityInterface
     */
    protected $identity = null;
    protected $credential;

    /**
     * Array of string messages
     * @var array
     */
    protected $messages;

    /**
     * Name of the current authentication provider
     * @var string
     */
    protected $name;

    /**
     *
     * @var ServiceLocatorInterface
     */
    protected $serviceManager;

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceManager = $serviceLocator;
        $config = $this->serviceManager->get('IdAuth\Config');
        $this->availProviders = $config['tryAdapters'];
        $storage = $this->serviceManager->get('IdAuth\Storage');
        $this->setStorage($storage);
    }

    public function authenticate(\Zend\Authentication\Adapter\AdapterInterface $adapter = null)
    {

        foreach ($this->availProviders as $adapterName) {
            $adapter = $this->serviceManager->get($adapterName);
            $adapter->setIdentity($this->getIdentity());
            $adapter->setCredential($this->getCredential());
            $result = $adapter->authenticate();
            $d = new \Zend\Debug\Debug();
            $d->dump(array('result' => $result, 'adapter' => $adapterName, 'identity' => $this->getIdentity()));
            die;
            if ($result->isValid()) {
                $this->setChainResult($result);
                /**
                 * ZF-7546 - prevent multiple successive calls from storing inconsistent results
                 * Ensure storage has clean state
                 */
                if ($this->hasIdentity()) {
                    $this->clearIdentity();
                }
                $this->getStorage()->write($result);
                $this->setName($adapter);
                return $result;
            }
        }
        return $this;
    }

    public function getChainResult()
    {
        return $this->chainResult;
    }

    public function setChainResult($chainResult)
    {
        $this->chainResult = $chainResult;
    }

    public function getCredential()
    {
        return $this->credential

        ;
    }

    public function setCredential($credential)
    {
        $this->credential = $credential

        ;
    }

    public function setIdentity($identity)
    {
        $this->identity = $identity

        ;
    }

    public function getName()
    {
        return $this->name

        ;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}
