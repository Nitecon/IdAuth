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

namespace Iap\Provider\DbTable;

use Iap\Provider\Interfaces\IdentityInterface;

class DbIdentity implements IdentityInterface
{

    protected $username;
    protected $firstName;
    protected $lastName;
    protected $email;
    protected $roles;

    public function getUsername()
    {
        return $this->username;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getRoles()
    {
        if (is_array($this->roles)) {
            return $this->roles;
        } else {
            return array('guest', 'anonymous');
        }
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;
    }
}
