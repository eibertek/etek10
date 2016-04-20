<?php

namespace Games\TCGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * activedeck
 */
class activedeck
{
    /**
     * @var guid
     */
    private $ActiveDeckId;

    /**
     * @var string
     */
    private $UserId;

    /**
     * @var string
     */
    private $PlayerId;

    /**
     * @var string
     */
    private $cardId;

    /**
     * @var boolean
     */
    private $Active;

    /**
     * @var float
     */
    private $Life;

    /**
     * @var float
     */
    private $Energy;

    /**
     * @var float
     */
    private $Defense;

    /**
     * @var float
     */
    private $Attack;

    /**
     * @var boolean
     */
    private $Cementery;


    /**
     * Get ActiveDeckId
     *
     * @return guid 
     */
    public function getActiveDeckId()
    {
        return $this->ActiveDeckId;
    }

    /**
     * Set UserId
     *
     * @param string $userId
     * @return activedeck
     */
    public function setUserId($userId)
    {
        $this->UserId = $userId;

        return $this;
    }

    /**
     * Get UserId
     *
     * @return string 
     */
    public function getUserId()
    {
        return $this->UserId;
    }

    /**
     * Set PlayerId
     *
     * @param string $playerId
     * @return activedeck
     */
    public function setPlayerId($playerId)
    {
        $this->PlayerId = $playerId;

        return $this;
    }

    /**
     * Get PlayerId
     *
     * @return string 
     */
    public function getPlayerId()
    {
        return $this->PlayerId;
    }

    /**
     * Set cardId
     *
     * @param string $cardId
     * @return activedeck
     */
    public function setCardId($cardId)
    {
        $this->cardId = $cardId;

        return $this;
    }

    /**
     * Get cardId
     *
     * @return string 
     */
    public function getCardId()
    {
        return $this->cardId;
    }

    /**
     * Set Active
     *
     * @param boolean $active
     * @return activedeck
     */
    public function setActive($active)
    {
        $this->Active = $active;

        return $this;
    }

    /**
     * Get Active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->Active;
    }

    /**
     * Set Life
     *
     * @param float $life
     * @return activedeck
     */
    public function setLife($life)
    {
        $this->Life = $life;

        return $this;
    }

    /**
     * Get Life
     *
     * @return float 
     */
    public function getLife()
    {
        return $this->Life;
    }

    /**
     * Set Energy
     *
     * @param float $energy
     * @return activedeck
     */
    public function setEnergy($energy)
    {
        $this->Energy = $energy;

        return $this;
    }

    /**
     * Get Energy
     *
     * @return float 
     */
    public function getEnergy()
    {
        return $this->Energy;
    }

    /**
     * Set Defense
     *
     * @param float $defense
     * @return activedeck
     */
    public function setDefense($defense)
    {
        $this->Defense = $defense;

        return $this;
    }

    /**
     * Get Defense
     *
     * @return float 
     */
    public function getDefense()
    {
        return $this->Defense;
    }

    /**
     * Set Attack
     *
     * @param float $attack
     * @return activedeck
     */
    public function setAttack($attack)
    {
        $this->Attack = $attack;

        return $this;
    }

    /**
     * Get Attack
     *
     * @return float 
     */
    public function getAttack()
    {
        return $this->Attack;
    }

    /**
     * Set Cementery
     *
     * @param boolean $cementery
     * @return activedeck
     */
    public function setCementery($cementery)
    {
        $this->Cementery = $cementery;

        return $this;
    }

    /**
     * Get Cementery
     *
     * @return boolean 
     */
    public function getCementery()
    {
        return $this->Cementery;
    }
    /**
     * @var string
     */
    private $deckId;


    /**
     * Set deckId
     *
     * @param string $deckId
     * @return activedeck
     */
    public function setDeckId($deckId)
    {
        $this->deckId = $deckId;

        return $this;
    }

    /**
     * Get deckId
     *
     * @return string 
     */
    public function getDeckId()
    {
        return $this->deckId;
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
