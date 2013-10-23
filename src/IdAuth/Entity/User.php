<?php

namespace IdAuth\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use IdAuth\Interfaces\Identity as IdentityInterface;

/**
 * @ORM\Entity
 */
class User implements IdentityInterface
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /** @ORM\Column(type="string", length=255) */
    protected $username;

    /** @ORM\Column(type="string", length=255) */
    protected $firstName;

    /** @ORM\Column(type="string", length=255) */
    protected $lastName;

    /** @ORM\Column(type="string", length=255) */
    protected $email;

    /** @ORM\Column(type="string", length=255) */
    protected $password;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="IdAuth\Entity\Roles")
     * @ORM\JoinTable(name="UserRoleLinker",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    protected $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

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
        $roles = array();
        foreach ($this->roles->getValues() as $roleObject) {
            $roles[] = $roleObject->getName();
        }
        return $roles;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setId($id)
    {
        $this->id = $id;
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

    public function setRoles($role)
    {
        $this->roles[] = $role;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
}
