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
// Composer autoloading
if (file_exists('./vendor/autoload.php')) {
    $loader = include './vendor/autoload.php';
}
$loader->add('IapTest', "./tests/IapTest/src/IapTest");
Zend\Mvc\Application::init(require __DIR__ . '/config/application.config.php');
