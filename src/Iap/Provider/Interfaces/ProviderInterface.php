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

namespace Iap\Provider\Interfaces;

use Iap\Provider\Interfaces\IdentityInterface;

interface ProviderInterface
{

    public function __construct(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator);

    public function authenticate(array $credentials);

    public function resetPassword(array $credentials);

    public function updateIdentity(IdentityInterface $identity);
}
