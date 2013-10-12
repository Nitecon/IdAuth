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

namespace Iap\Provider;

use Iap\Provider\Interfaces\IdentityInterface;

class ProviderResult
{

    /**
     * Array of messages provided by the authentication service
     * @var array
     */
    protected $messages;

    /**
     * Int value corresponding to the authentication result.
     * @var int
     */
    protected $authCode;

    /**
     * The identity of the user implementing IdentityInterface
     * @var IdentityInterface 
     */
    protected $identity;

    /**
     * Whether or not the user authentication was successful
     * @var bool
     */
    protected $isAuthenticated;

    /**
     * Name of the provider (Service manager name)
     * @var string
     */
    protected $name;

    /**
     * Array of options that the provider supports
     * @var array
     */
    protected $options;

    public function getMessages()
    {
        return $this->authMessages;
    }

    public function getAuthCode()
    {
        return $this->authCode;
    }

    /**
     * 
     * @return IdentityInterface
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * 
     * @return bool
     */
    public function getIsAuthenticated()
    {
        return $this->isAuthenticated;
    }

    /**
     * 
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function setMessages($authMessages)
    {
        $this->authMessages = $authMessages;
    }

    public function setAuthCode($authCode)
    {
        $this->authCode = $authCode;
    }

    /**
     * 
     * @param IdentityInterface $identity
     * @return void
     */
    public function setIdentity(IdentityInterface $identity)
    {
        $this->identity = $identity;
    }

    /**
     * 
     * @param bool $isAuthenticated
     * @return void
     */
    public function setIsAuthenticated($isAuthenticated)
    {
        $this->isAuthenticated = $isAuthenticated;
    }

    /**
     * 
     * @param array $options
     * @return void
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * 
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
