<?php

namespace Games\TCGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * cardsdeck
 */
class cardsdeck
{
    /**
     * @var guid
     */
    private $cdId;

    /**
     * @var string
     */
    private $DeckId;

    /**
     * @var string
     */
    private $CardId;

    /**
     * @var boolean
     */
    private $Premium;

    /**
     * @var boolean
     */
    private $Active;


    /**
     * Get cdId
     *
     * @return guid 
     */
    public function getCdId()
    {
        return $this->cdId;
    }

    /**
     * Set DeckId
     *
     * @param string $deckId
     * @return cardsdeck
     */
    public function setDeckId($deckId)
    {
        $this->DeckId = $deckId;

        return $this;
    }

    /**
     * Get DeckId
     *
     * @return string 
     */
    public function getDeckId()
    {
        return $this->DeckId;
    }

    /**
     * Set CardId
     *
     * @param string $cardId
     * @return cardsdeck
     */
    public function setCardId($cardId)
    {
        $this->CardId = $cardId;

        return $this;
    }

    /**
     * Get CardId
     *
     * @return string 
     */
    public function getCardId()
    {
        return $this->CardId;
    }

    /**
     * Set Premium
     *
     * @param boolean $premium
     * @return cardsdeck
     */
    public function setPremium($premium)
    {
        $this->Premium = $premium;

        return $this;
    }

    /**
     * Get Premium
     *
     * @return boolean 
     */
    public function getPremium()
    {
        return $this->Premium;
    }

    /**
     * Set Active
     *
     * @param boolean $active
     * @return cardsdeck
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
