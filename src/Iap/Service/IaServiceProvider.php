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

namespace Iap\Service;

use Zend\Authentication\Storage\StorageInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IAServiceProvider
{

    /**
     * An array of available providers
     * @var array
     */
    protected $availProviders;

    /**
     *
     * @var bool
     */
    protected $hasIdentity;

    /**
     *  This is the identity to be returned and should implement Iap\Provider\Interfaces\IdentityInterface
     * @var DbIdentity
     */
    protected $identity;

    /**
     * Array of string messages
     * @var array
     */
    protected $messages;

    /**
     * This is the name of the actual provider being used
     * @var string
     */
    protected $name = 'Db';

    /**
     * This is the options for the adapter and should implement Iap\Provider\Interfaces\OptionsInterface
     * @var array
     */
    protected $options;

    /**
     *
     * @var ServiceLocatorInterface
     */
    protected $serviceManager;

    /**
     *
     * @var StorageInterface
     */
    protected $storage;

    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceManager = $serviceLocator;
        $config = $this->serviceManager->get('Iap\Config');
        $this->availProviders = $config['tryProviders'];
        $storage = $this->serviceManager->get('Iap\Storage');
        $this->storage = $storage;
        if ($this->storage->isEmpty()) {
            $this->hasIdentity = false;
        } else {
            $this->processStorage($storage);
        }
    }

    public function authenticate(array $credentials)
    {
        $messages = array();
        foreach ($this->availProviders as $providerName) {
            $provider = $this->serviceManager->get($providerName);
            $result = $provider->authenticate($credentials);
            $messages = array_values($result->getMessages());
            if ($result->getIsAuthenticated()) {
                $storage = $this->storage->read();
                $identity = $result->getIdentity();
                $name = $result->getName();
                $messages = $result->getMessages();
                $hasIdentity = $result->getIsAuthenticated();
                $this->hasIdentity = true;
                $this->messages = $messages;


                $this->storage->write(array(
                    'identity' => $identity,
                    'name' => $name,
                    'messages' => $messages,
                    'hasIdentity' => $hasIdentity,
                ));
                break;
            }
        }
        $this->setIdentity(null);
        $this->setName(null);
        $this->setMessages($messages);
        $this->hasIdentity = false;
        return $this;
    }

    public function clearIdentity()
    {
        $this->storage->clear();
    }

    /**
     * getCode() - Get the result code for this authentication attempt
     *
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    public function getIdentity()
    {
        return $this->identity;
    }

    public function hasIdentity()
    {
        return $this->hasIdentity;
    }

    /**
     * Returns an array of string reasons why the authentication attempt was unsuccessful
     *
     * If authentication was successful, this method returns an empty array.
     *
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setIdentity($identity)
    {
        $this->identity = $identity;
    }

    public function setMessages($messages)
    {
        $this->messages = $messages;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function processStorage($storage)
    {
        $userStorage = $storage->read();

        if (isset($userStorage['identity'])) {
            $this->setIdentity($userStorage['identity']);
            $this->setName($userStorage['name']);
            $this->setMessages($userStorage['messages']);
            $this->hasIdentity = $userStorage['hasIdentity'];
        }
    }

    public function writeStorage($contents)
    {
        $storage = $this->storage;
        $storage->write($contents);
    }
}
