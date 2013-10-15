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

namespace IdAuth\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use IdAuth\Provider\Doctrine\Entity\User;
use Zend\Crypt\Password\Bcrypt;

class LoadUserData extends AbstractFixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $adminUser = new User();
        $adminUser->setUsername('admin');
        $adminUser->setEmail('noone@nowhere.com');
        $adminUser->setFirstName('Admin');
        $adminUser->setLastName('User');
        $adminUser->setRoles($this->getReference('admin-role'));
        $bcrypt = new Bcrypt();
        $bcrypt->setCost(14);
        $adminUser->setPassword($bcrypt->create('Tru5tme'));
        $manager->persist($adminUser);
        $manager->flush();

        // store reference to admin role for User relation to Role
        $this->addReference('admin-user', $adminUser);
    }

    public function getDependencies()
    {
        return array('IdAuth\Fixture\LoadUserRoleData'); // fixture classes fixture is dependent on
    }
}
