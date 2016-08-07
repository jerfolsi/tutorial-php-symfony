<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface, \JsonSerializable
{

    //-------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------
    // PROPERTIES
    //-------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=255)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var bool
     * @ORM\Column(name="is_admin", type="boolean", nullable=true)
     *
     */
    private $isAdmin;

    /**
     * @var bool
     * @ORM\Column(name="is_manager", type="boolean", nullable=true)
     */
    private $isManager;

    /**
     * @var \DateTime
     * @ORM\Column(name="last_authenticated_at", type="datetime", nullable=true)
     */
    private $lastAuthenticatedAt;
    

    //-------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------
    // GETTER / SETTER
    //-------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------

    /**
     * @return \DateTime
     */
    public function getLastAuthenticatedAt()
    {
        return $this->lastAuthenticatedAt;
    }

    /**
     * @param \DateTime $lastAuthenticatedAt
     * @return User
     */
    public function setLastAuthenticatedAt($lastAuthenticatedAt)
    {
        $this->lastAuthenticatedAt = $lastAuthenticatedAt;
        return $this;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set login
     *
     * @param string $login
     *
     * @return User
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return boolean
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * @param boolean $isAdmin
     * @return User
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsManager()
    {
        return $this->isManager;
    }

    /**
     * @param mixed $isManager
     * @return User
     */
    public function setIsManager($isManager)
    {
        $this->isManager = $isManager;
        return $this;
    }



    //-------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------
    // Interface : UserInterface
    //-------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------

    public function getRoles()
    {
        $roles = ['ROLE_USER'];
        if($this->getIsAdmin()){
            $roles[] = 'ROLE_ADMIN';
        }
        return $roles;
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
        return null;
    }

    public function getUsername()
    {
        // TODO: Implement getUsername() method.
        return $this->getLogin();
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    //-------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------
    // JSON - SERIALIZATION
    //-------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------

    public function jsonSerialize()
    {
        return [
            "id" => $this->getId(),
            "login" => $this->getLogin(),
        ];
    }


}

