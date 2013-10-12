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

namespace Iap\Service\Factory;

use Iap\Collector\IapCollector;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory responsible of instantiating {@see \Iap\Collector\IapCollector}
 */
class Collector implements FactoryInterface
{

    /**
     * {@inheritDoc}
     *
     * @return \BjyAuthorize\Collector\RoleCollector
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new IapCollector();
    }
}
