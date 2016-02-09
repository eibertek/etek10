<?php

namespace Etk\Bundle\UsuariosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProyectosComentario
 */
class ProyectosComentario
{
    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var \DateTime
     */
    private $createddate;

    /**
     * @var integer
     */
    private $likes;

    /**
     * @var integer
     */
    private $notlikes;

    /**
     * @var integer
     */
    private $replyto;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Etk\Bundle\UsuariosBundle\Entity\Proyectos
     */
    private $proyectoid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return ProyectosComentario
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
     * Set createddate
     *
     * @param \DateTime $createddate
     * @return ProyectosComentario
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
     * Set likes
     *
     * @param integer $likes
     * @return ProyectosComentario
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;

        return $this;
    }

    /**
     * Get likes
     *
     * @return integer 
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * Set notlikes
     *
     * @param integer $notlikes
     * @return ProyectosComentario
     */
    public function setNotlikes($notlikes)
    {
        $this->notlikes = $notlikes;

        return $this;
    }

    /**
     * Get notlikes
     *
     * @return integer 
     */
    public function getNotlikes()
    {
        return $this->notlikes;
    }

    /**
     * Set replyto
     *
     * @param integer $replyto
     * @return ProyectosComentario
     */
    public function setReplyto($replyto)
    {
        $this->replyto = $replyto;

        return $this;
    }

    /**
     * Get replyto
     *
     * @return integer 
     */
    public function getReplyto()
    {
        return $this->replyto;
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
     * Set proyectoid
     *
     * @param \Etk\Bundle\UsuariosBundle\Entity\Proyectos $proyectoid
     * @return ProyectosComentario
     */
    public function setProyectoid(\Etk\Bundle\UsuariosBundle\Entity\Proyectos $proyectoid = null)
    {
        $this->proyectoid = $proyectoid;

        return $this;
    }

    /**
     * Get proyectoid
     *
     * @return \Etk\Bundle\UsuariosBundle\Entity\Proyectos 
     */
    public function getProyectoid()
    {
        return $this->proyectoid;
    }
}
