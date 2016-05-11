<?php

namespace Games\TCGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * card
 */
class card
{
    /**
     * @var binary
     */
    private $CardId;
    /**
     * @var guid
     */
    private $StringId;
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
     * @var string
     */
    private $Title;

    /**
     * @var string
     */
    private $Image;

    /**
     * @var string
     */
    private $Subtitle;

    /**
     * @var string
     */
    private $Description;

    /**
     * @var string
     */
    private $Leyend;


    /**
     * Get CardId
     *
     * @return guid 
     */
    public function getCardId()
    {
        return $this->CardId;
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
     * Set Life
     *
     * @param float $life
     * @return card
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
     * @return card
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
     * @return card
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
     * @return card
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
     * Set Title
     *
     * @param string $title
     * @return card
     */
    public function setTitle($title)
    {
        $this->Title = $title;

        return $this;
    }

    /**
     * Get Title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->Title;
    }

    /**
     * Set Image
     *
     * @param string $image
     * @return card
     */
    public function setImage($image)
    {
        $this->Image = $image;

        return $this;
    }

    /**
     * Get Image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->Image;    
    }

    /**
     * Set Subtitle
     *
     * @param string $subtitle
     * @return card
     */
    public function setSubtitle($subtitle)
    {
        $this->Subtitle = $subtitle;

        return $this;
    }

    /**
     * Get Subtitle
     *
     * @return string 
     */
    public function getSubtitle()
    {
        return $this->Subtitle;
    }

    /**
     * Set Description
     *
     * @param string $description
     * @return card
     */
    public function setDescription($description)
    {
        $this->Description = $description;

        return $this;
    }

    /**
     * Get Description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->Description;
    }

    /**
     * Set Leyend
     *
     * @param string $leyend
     * @return card
     */
    public function setLeyend($leyend)
    {
        $this->Leyend = $leyend;

        return $this;
    }

    /**
     * Get Leyend
     *
     * @return string 
     */
    public function getLeyend()
    {
        return $this->Leyend;
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
                $this->CardId = $uuid[0]['uuid()'];
        }
        $this->upload($uuid);
        return true;
    }
    
    public function getImageFile(){
        return $this->getUploadDir().'/'.$this->Image;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return '/games/cards';
    }
    
    public function upload($uniqueId)
    {
        // the file property can be empty if the field is not required
        if (null === $this->getImage()) {
            return;
        }
        // use the original file name here but you should
        // sanitize it at least to avoid any security issues
        if( $this->getImage()->guessClientExtension() == "jpeg") {
            $fileName = uniqid('IMG_').'.jpg';
        }elseif($this->getImage()->guessClientExtension() == "png"){
            $fileName = uniqid('IMG_').'.png';
        }
        // move takes the target directory and then the
        // target filename to move to
        $this->getImage()->move(
            $this->getUploadRootDir(),
            $fileName
        );

        // set the path property to the filename where you've saved the file
        $this->Image = $fileName;

    }    
}
