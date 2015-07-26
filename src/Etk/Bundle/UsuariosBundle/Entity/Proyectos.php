<?php

namespace Etk\Bundle\UsuariosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proyectos
 */
class Proyectos
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var \DateTime
     */
    private $fechaComienzo;

    /**
     * @var string
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $createddate;

    /**
     * @var \DateTime
     */
    private $modifieddate;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Proyectos
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Proyectos
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set fechaComienzo
     *
     * @param \DateTime $fechaComienzo
     * @return Proyectos
     */
    public function setFechaComienzo($fechaComienzo)
    {
        $this->fechaComienzo = $fechaComienzo;

        return $this;
    }

    /**
     * Get fechaComienzo
     *
     * @return \DateTime 
     */
    public function getFechaComienzo()
    {
        return $this->fechaComienzo;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Proyectos
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createddate
     *
     * @param \DateTime $createddate
     * @return Proyectos
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
     * Set modifieddate
     *
     * @param \DateTime $modifieddate
     * @return Proyectos
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
