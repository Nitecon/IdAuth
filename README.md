[![Build Status](https://travis-ci.org/neuweb/IdAuth.png?branch=master)](https://travis-ci.org/neuweb/IdAuth)
[![Latest Stable Version](https://poser.pugx.org/neuweb/IdAuth/v/stable.png)](https://packagist.org/packages/neuweb/IdAuth)
[![Coverage Status](https://coveralls.io/repos/neuweb/IdAuth/badge.png?branch=master)](https://coveralls.io/r/neuweb/IdAuth?branch=master)

PSR-2 Certified with build pass
===============================

WIP
===
The module now functional but needs a lot of work and unit tests.  Getting the module working on your
own may take quite a lot of work as I haven't had time to add proper documentation on how to configure
the module yet.  I'm working on completing the documentation once the vision of the module is more or less
implemented in the code. 

Please note the 100% coverage indicator is currently not accurate as it only has one test file with 100% coverage :)

IdAuth
=====
IdAuth is designed to be a multi provider identity and authentication system.  Where as most modules
that are currently available only allow single authentication systems the aim is to provide, access
to many different authentication systems including Facebook / Github etc as additional providers.

Installation
============

To install this module you can use composer with the following command:
<pre class="brush:sh">
    php composer.phar require nitecon/idauth:dev-master
</pre>

Please note that this module **REQUIRES** doctrine to work, and also provides fixtures to import the initial user
account into your database.  Steps to enable this module include the following:

  1. Install the module as per composer line above
  2. Add the following modules to your application.config.php
  <pre class="brush:php">
    return array(
    'modules' => array(
    'DoctrineModule',
    'DoctrineORMModule',
    'DoctrineDataFixtureModule',
    'IdAuth',
    // ... Rest of your modules
    );
  </pre>
  3. Configure your doctrine connection driver like (Generally in `config/autoload/global.php` but please make sure
    never to store your passwords in the global file, they should be stored in `config/autoload/global.php` instead:
  <pre class="brush:php">
    return array(
    'doctrine' => array(
        'connection' => array(
            // default connection name
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host' => 'localhost',
                    'port' => '3306',
                    'user' => 'testuser',
                    'password' => 'testpass',
                    'dbname' => 'testdatabase',
                )
            )
        )
    ),
    // More of your global configurations
    );
  </pre>
  4. Copy the configuration file to your autoload directory with:
  <pre class="brush:sh">
    cp ./vendor/nitecon/idauth/config/idauth.global.php.dist config/autoload/idauth.global.php
  </pre>
  Feel free to edit the file with additional changes.
  5. Install the database with the following command from your project root:
  <pre class="brush:php">
    ./vendor/bin/doctrine-module orm:schema-tool:create
  </pre>

With fixtures module active it should install the admin user to your database at this point.  If you do not
see the admin user listed in the database then you may need to run the importer manually with:

<pre class="brush:sh">
    ./vendor/bin/doctrine-module data-fixture:import
</pre>

At this point you should be installed and ready to go.  You can already attempt a log in with the default admin
user `admin` and password `Tru5tme`

To log into the application point your browser to /user/login


Objectives of this module
=========================
  1. Provide User Authentication with multiple providers at the same time
  2. Provide multiple independent identity providers active at the same time
  3. Allow plugin based authentication (eg: Facebook) - Only takes 2 classes currently to create a plugin
  4. Native LDAP provider plugin for identity & authorization
  5. Native Zend TableAdapter provider plugin for identity & authorization
  6. Native Doctrine provider plugin for identity & authorization
  7. Role based authentication readily available by adding on ZfcRbac
  8. Collector module to show specific details on current user including currently signed in provider
  9. Allow password reset independently of each provider
  10. Allow updates to identity's on providers in an independent nature.
  11. Add dedicated storage for all providers (Default: Zend\Authentication\Storage\Session)
  12. Fall through authentication between all providers until a valid authentication attempt is found.
  13. Direct access to authentication provider by specifying the provider.
  14. Native roles array to allow for easy expansion to ZfcRbac
  15. Native Authentication Service that can be added communicated with directly and added to ZfcRbac.
