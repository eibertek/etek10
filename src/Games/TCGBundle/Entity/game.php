<?php

namespace Games\TCGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * game
 */
class game
{
    /**
     * @var guid
     */
    private $id;

    /**
     * @var string
     */
    private $P1UserId;

    /**
     * @var string
     */
    private $P2UserId;

    /**
     * @var boolean
     */
    private $AiPlayer;

    /**
     * @var float
     */
    private $P1Life;

    /**
     * @var float
     */
    private $P1Energy;

    /**
     * @var float
     */
    private $P2Life;

    /**
     * @var float
     */
    private $P2Energy;


    /**
     * Get id
     *
     * @return guid 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set P1UserId
     *
     * @param string $p1UserId
     * @return game
     */
    public function setP1UserId($p1UserId)
    {
        $this->P1UserId = $p1UserId;

        return $this;
    }

    /**
     * Get P1UserId
     *
     * @return string 
     */
    public function getP1UserId()
    {
        return $this->P1UserId;
    }

    /**
     * Set P2UserId
     *
     * @param string $p2UserId
     * @return game
     */
    public function setP2UserId($p2UserId)
    {
        $this->P2UserId = $p2UserId;

        return $this;
    }

    /**
     * Get P2UserId
     *
     * @return string 
     */
    public function getP2UserId()
    {
        return $this->P2UserId;
    }

    /**
     * Set AiPlayer
     *
     * @param boolean $aiPlayer
     * @return game
     */
    public function setAiPlayer($aiPlayer)
    {
        $this->AiPlayer = $aiPlayer;

        return $this;
    }

    /**
     * Get AiPlayer
     *
     * @return boolean 
     */
    public function getAiPlayer()
    {
        return $this->AiPlayer;
    }

    /**
     * Set P1Life
     *
     * @param float $p1Life
     * @return game
     */
    public function setP1Life($p1Life)
    {
        $this->P1Life = $p1Life;

        return $this;
    }

    /**
     * Get P1Life
     *
     * @return float 
     */
    public function getP1Life()
    {
        return $this->P1Life;
    }

    /**
     * Set P1Energy
     *
     * @param float $p1Energy
     * @return game
     */
    public function setP1Energy($p1Energy)
    {
        $this->P1Energy = $p1Energy;

        return $this;
    }

    /**
     * Get P1Energy
     *
     * @return float 
     */
    public function getP1Energy()
    {
        return $this->P1Energy;
    }

    /**
     * Set P2Life
     *
     * @param float $p2Life
     * @return game
     */
    public function setP2Life($p2Life)
    {
        $this->P2Life = $p2Life;

        return $this;
    }

    /**
     * Get P2Life
     *
     * @return float 
     */
    public function getP2Life()
    {
        return $this->P2Life;
    }

    /**
     * Set P2Energy
     *
     * @param float $p2Energy
     * @return game
     */
    public function setP2Energy($p2Energy)
    {
        $this->P2Energy = $p2Energy;

        return $this;
    }

    /**
     * Get P2Energy
     *
     * @return float 
     */
    public function getP2Energy()
    {
        return $this->P2Energy;
    }
    /**
     * @var \DateTime
     */
    private $P1LastMove;

    /**
     * @var \DateTime
     */
    private $P2LastMove;


    /**
     * Set P1LastMove
     *
     * @param \DateTime $p1LastMove
     * @return game
     */
    public function setP1LastMove($p1LastMove)
    {
        $this->P1LastMove = $p1LastMove;

        return $this;
    }

    /**
     * Get P1LastMove
     *
     * @return \DateTime 
     */
    public function getP1LastMove()
    {
        return $this->P1LastMove;
    }

    /**
     * Set P2LastMove
     *
     * @param \DateTime $p2LastMove
     * @return game
     */
    public function setP2LastMove($p2LastMove)
    {
        $this->P2LastMove = $p2LastMove;

        return $this;
    }

    /**
     * Get P2LastMove
     *
     * @return \DateTime 
     */
    public function getP2LastMove()
    {
        return $this->P2LastMove;
    }

    /**
     *  Generate Id
     * @global class $kernel
     * @return string
     */
    public function generateId(){
        global $kernel;

        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }

        $service = $kernel->getContainer()->get('etk_admin.usuarios');
        $uuid = $service->getUUID();
     
        return $uuid;
    }    
}
