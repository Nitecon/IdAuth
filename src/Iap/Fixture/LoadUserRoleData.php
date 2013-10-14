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

namespace Iap\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Iap\Provider\Doctrine\Entity\Roles;

class LoadUserRoleData extends AbstractFixture
{

    public function load(ObjectManager $manager)
    {
        $adminRole = new Roles();
        $adminRole->setRole('Administrator');
        $anonRole = new Roles();
        $anonRole->setRole('Anonymous');
        
        $manager->persist($adminRole);
        $manager->persist($anonRole);
        $manager->flush();
        
        // store reference to admin role for User relation to Role
        $this->addReference('admin-role', $adminRole);
    }
}