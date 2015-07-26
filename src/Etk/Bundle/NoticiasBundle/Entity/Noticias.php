<?php

namespace Etk\Bundle\NoticiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Noticias
 */
class Noticias
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
    private $fecha;

    /**
     * @var \DateTime
     */
    private $fechapublicacion;

    /**
     * @var string
     */
    private $titulo;

    /**
     * @var string
     */
    private $subtitulo;

    /**
     * @var string
     */
    private $cuerpo;

    /**
     * @var \DateTime
     */
    private $createddate;

    /**
     * @var \DateTime
     */
    private $modifieddate;

    /**
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var \Etk\Bundle\UsuariosBundle\Entity\Usuarios
     */
    private $userid;


    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Noticias
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
     * @return Noticias
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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Noticias
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set fechapublicacion
     *
     * @param \DateTime $fechapublicacion
     * @return Noticias
     */
    public function setFechapublicacion($fechapublicacion)
    {
        $this->fechapublicacion = $fechapublicacion;

        return $this;
    }

    /**
     * Get fechapublicacion
     *
     * @return \DateTime 
     */
    public function getFechapublicacion()
    {
        return $this->fechapublicacion;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return Noticias
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set subtitulo
     *
     * @param string $subtitulo
     * @return Noticias
     */
    public function setSubtitulo($subtitulo)
    {
        $this->subtitulo = $subtitulo;

        return $this;
    }

    /**
     * Get subtitulo
     *
     * @return string 
     */
    public function getSubtitulo()
    {
        return $this->subtitulo;
    }

    /**
     * Set cuerpo
     *
     * @param string $cuerpo
     * @return Noticias
     */
    public function setCuerpo($cuerpo)
    {
        $this->cuerpo = $cuerpo;

        return $this;
    }

    /**
     * Get cuerpo
     *
     * @return string 
     */
    public function getCuerpo()
    {
        return $this->cuerpo;
    }

    /**
     * Set createddate
     *
     * @param \DateTime $createddate
     * @return Noticias
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
     * @return Noticias
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

    /**
     * Set userid
     *
     * @param \Etk\Bundle\UsuariosBundle\Entity\Usuarios $userid
     * @return Noticias
     */
    public function setUserid(\Etk\Bundle\UsuariosBundle\Entity\Usuarios $userid = null)
    {
        $this->userid = $userid;

        return $this;
    }

    /**
     * Get userid
     *
     * @return \Etk\Bundle\UsuariosBundle\Entity\Usuarios 
     */
    public function getUserid()
    {
        return $this->userid;
    }
}
