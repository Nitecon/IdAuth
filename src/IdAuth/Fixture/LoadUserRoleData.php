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
use IdAuth\Provider\Doctrine\Entity\Roles;

class LoadUserRoleData extends AbstractFixture
{

    public function load(ObjectManager $manager)
    {
        $adminRole = new Roles();
        $adminRole->setName('Administrator');
        $superUser = new Roles();
        $superUser->setName('SuperUser');
        $superUser->setParent($adminRole);
        $userRole = new Roles();
        $userRole->setName('User');
        $userRole->setParent($superUser);
        $anonRole = new Roles();
        $anonRole->setName('Anonymous');
        $anonRole->setParent($userRole);

        $manager->persist($adminRole);
        $manager->persist($superUser);
        $manager->persist($userRole);
        $manager->persist($anonRole);
        $manager->flush();

        // store reference to admin role for User relation to Role
        $this->addReference('admin-role', $adminRole);
    }
}
