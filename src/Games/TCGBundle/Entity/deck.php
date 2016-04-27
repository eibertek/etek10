<?php

namespace Games\TCGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * deck
 */
class deck
{
    /**
     * @var guid
     */
    private $deckId;

    /**
     * @var guid
     */
    private $StringId;
    /**
     * @var boolean
     */
    private $Premium;

    /**
     * @var boolean
     */
    private $Active;

    /**
     * @var string
     */
    private $Name;

    /**
     * Get deckId
     *
     * @return guid 
     */
    public function getDeckId()
    {
        return $this->deckId;
    }

    /**
     * Set Premium
     *
     * @param boolean $premium
     * @return deck
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
     * Set StringId
     *
     * @param string 
     * @return deck
     */
    public function setStringId($stringId)
    {
        $this->StringId = $stringId;

        return $this;
    }

    /**
     * Get StringId
     *
     * @return boolean 
     */
    public function getStringId()
    {
        return $this->StringId;
    }
    
    /**
     * Set Active
     *
     * @param boolean $active
     * @return deck
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
     * Set Name
     *
     * @param string $name
     * @return deck
     */
    public function setName($name)
    {
        $this->Name = $name;

        return $this;
    }

    /**
     * Get Name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->Name;
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
        if(isset($uuid[0]) && isset($uuid[0]['uuid()'])){
                $this->setStringId($uuid[0]['uuid()']);
                $this->deckId = $uuid[0]['uuid()'];
        }
        return true;
    }    
}
