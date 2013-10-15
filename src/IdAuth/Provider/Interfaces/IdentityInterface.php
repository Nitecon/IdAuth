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

namespace IdAuth\Provider\Interfaces;

interface IdentityInterface
{

    public function getUsername();

    public function getFirstName();

    public function getLastName();

    public function getEmail();

    public function getRoles();
}
