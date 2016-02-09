<?php

namespace Etk\Bundle\UsuariosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Activationlink
 *
 * @ORM\Table(name="activationlink")
 * @ORM\Entity(repositoryClass="Etk\Bundle\UsuariosBundle\Repository\ActivationlinkRepository")
 */
class Activationlink
{
    /**
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;


    /**
     * @var string
     *
     * @ORM\Column(name="userId", type="string", length=255)
     */
    private $userId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expireDate", type="datetimetz")
     */
    private $expireDate;


    /**
     * Get id
     *
     * @return String 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userId
     *
     * @param string $userId
     * @return Activationlink
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return string 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set expireDate
     *
     * @param \DateTime $expireDate
     * @return Activationlink
     */
    public function setExpireDate($expireDate)
    {
        $this->expireDate = $expireDate;

        return $this;
    }

    /**
     * Get expireDate
     *
     * @return \DateTime 
     */
    public function getExpireDate()
    {
        return $this->expireDate;
    }
}
