<?php

namespace Etk\Bundle\UsuariosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Grupo
 */
class Grupo
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var \DateTime
     */
    private $createddate;

    /**
     * @var string
     */
    private $permisos;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Grupo
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
     * Set createddate
     *
     * @param \DateTime $createddate
     * @return Grupo
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
     * Set permisos
     *
     * @param string $permisos
     * @return Grupo
     */
    public function setPermisos($permisos)
    {
        $this->permisos = $permisos;

        return $this;
    }

    /**
     * Get permisos
     *
     * @return string 
     */
    public function getPermisos()
    {
        return $this->permisos;
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
}
