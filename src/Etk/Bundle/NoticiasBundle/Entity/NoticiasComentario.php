<?php

namespace Etk\Bundle\NoticiasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NoticiasComentario
 */
class NoticiasComentario
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
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var \Etk\Bundle\NoticiasBundle\Entity\Noticias
     */
    private $noticiasid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return NoticiasComentario
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
     * @return NoticiasComentario
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
     * @return NoticiasComentario
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
     * @return NoticiasComentario
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
     * @return NoticiasComentario
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
     * Set noticiasid
     *
     * @param \Etk\Bundle\UsuariosBundle\Entity\Noticias $noticiasid
     * @return NoticiasComentario
     */
    public function setNoticiasid(\Etk\Bundle\NoticiasBundle\Entity\Noticias $noticiasid = null)
    {
        $this->noticiasid = $noticiasid;

        return $this;
    }

    /**
     * Get noticiasid
     *
     * @return \Etk\Bundle\UsuariosBundle\Entity\Noticias 
     */
    public function getNoticiasid()
    {
        return $this->noticiasid;
    }
}
