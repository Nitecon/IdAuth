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

namespace IdAuth\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class Roles
{

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=true, nullable=true)
     */
    protected $name;

    /**
     * @var Roles
     * @ORM\ManyToOne(targetEntity="IdAuth\Entity\Roles")
     */
    protected $parent;

    /**
     * Get the id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the id.
     *
     * @param int $id
     *
     * @return void
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * Get the role id.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the role id.
     *
     * @param string $name
     *
     * @return void
     */
    public function setName($name)
    {
        $this->name = (string) $name;
    }

    /**
     * Get the parent role
     *
     * @return Role
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set the parent role.
     *
     * @param Roles $role
     *
     * @return void
     */
    public function setParent(Roles $parent)
    {
        $this->parent = $parent;
    }
}
