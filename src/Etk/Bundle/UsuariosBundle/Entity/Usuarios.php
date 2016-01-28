<?php

namespace Etk\Bundle\UsuariosBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Usuarios
 */
class Usuarios implements \Symfony\Component\Security\Core\User\UserInterface
{
    
    const NOT_VALIDATED = 'NOT_VALIDATED';
    const ACTIVE = 'ACTIVE';
    const DISABLED = 'DISABLED';
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $apellido;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max = 4096)
     */
    private $plainPassword;
    /**
     * @var \DateTime
     */
    private $createddate;

    /**
     * @var \DateTime
     */
    private $unitbanneddate;

    /**
     * @var \DateTime
     */
    private $modifieddate;

    /**
     * @var string
     */
    private $status;
    
    /**
     * @var string
     */
    private $role;

    /**
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var \Etk\Bundle\UsuariosBundle\Entity\Grupo
     */
    private $userGroup;


    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Usuarios
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     * @return Usuarios
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Usuarios
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return Usuarios
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Usuarios
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
     * Set createddate
     *
     * @param \DateTime $createddate
     * @return Usuarios
     */
    public function setCreateddate($createddate)
    {
        $this->createddate = $createddate;

        return $this;
    }

    /**
     * Get createddate
     *
     * @return \DateTime 
     */
    public function getCreateddate()
    {
        return $this->createddate;
    }

    /**
     * Set unitbanneddate
     *
     * @param \DateTime $unitbanneddate
     * @return Usuarios
     */
    public function setUnitbanneddate($unitbanneddate)
    {
        $this->unitbanneddate = $unitbanneddate;

        return $this;
    }

    /**
     * Get unitbanneddate
     *
     * @return \DateTime 
     */
    public function getUnitbanneddate()
    {
        return $this->unitbanneddate;
    }

    /**
     * Set modifieddate
     *
     * @param \DateTime $modifieddate
     * @return Usuarios
     */
    public function setModifieddate($modifieddate)
    {
        $this->modifieddate = $modifieddate;

        return $this;
    }

    /**
     * Get modifieddate
     *
     * @return \DateTime 
     */
    public function getModifieddate()
    {
        return $this->modifieddate;
    }

        /**
     * Set nombre
     *
     * @param string $nombre
     * @return Usuarios
     */
    public function setStatus($status)
    {
        if($status === self::ACTIVE || $status === self::NOT_VALIDATED || $status === self::DISABLED){
            $this->status = $status;
            return $this;
        }
        return false;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * Set role
     *
     * @param string $role
     * @return Usuarios
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    /**
     * Set userGroup
     *
     * @param \Etk\Bundle\UsuariosBundle\Entity\Grupo $userGroup
     * @return Usuarios
     */
    public function setUserGroup(\Etk\Bundle\UsuariosBundle\Entity\Grupo $userGroup = null)
    {
        $this->userGroup = $userGroup;

        return $this;
    }

    /**
     * Get userGroup
     *
     * @return \Etk\Bundle\UsuariosBundle\Entity\Grupo 
     */
    public function getUserGroup()
    {
        return $this->userGroup;
    }

    public function getSalt(){
        return '1234567980';
    }

    public function eraseCredentials() {
        
    }

    public function getRoles() {
        $roles[] = $this->getRole();
        return $roles;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }    
}
