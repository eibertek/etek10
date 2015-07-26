<?php

namespace Etk\Bundle\SFPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * moneda
 */
class moneda
{
    /**
     * @var guid
     */
    private $sfpIdMoneda;

    /**
     * @var boolean
     */
    private $sfpPrincipal;

    /**
     * @var \DateTime
     */
    private $sfpFecha;

    /**
     * @var string
     */
    private $sfpCaracter;

    /**
     * @var float
     */
    private $sfpRelacionDolar;

    /**
     * @var string
     */
    private $sfpDescripcion;


    /**
     * Set sfpIdMoneda
     *
     * @param guid $sfpIdMoneda
     * @return moneda
     */
    private function setSfpIdMoneda($sfpIdMoneda)
    {
        $this->sfpIdMoneda = $sfpIdMoneda;

        return $this;
    }

    /**
     * Get sfpIdMoneda
     *
     * @return guid 
     */
    public function getSfpIdMoneda()
    {
        return $this->sfpIdMoneda;
    }

    /**
     * Set sfpPrincipal
     *
     * @param boolean $sfpPrincipal
     * @return moneda
     */
    public function setSfpPrincipal($sfpPrincipal)
    {
        $this->sfpPrincipal = $sfpPrincipal;

        return $this;
    }

    /**
     * Get sfpPrincipal
     *
     * @return boolean 
     */
    public function getSfpPrincipal()
    {
        return $this->sfpPrincipal;
    }

    /**
     * Set sfpFecha
     *
     * @param \DateTime $sfpFecha
     * @return moneda
     */
    public function setSfpFecha($sfpFecha)
    {
        $this->sfpFecha = $sfpFecha;

        return $this;
    }

    /**
     * Get sfpFecha
     *
     * @return \DateTime 
     */
    public function getSfpFecha()
    {
        return $this->sfpFecha;
    }

    /**
     * Set sfpCaracter
     *
     * @param string $sfpCaracter
     * @return moneda
     */
    public function setSfpCaracter($sfpCaracter)
    {
        $this->sfpCaracter = $sfpCaracter;

        return $this;
    }

    /**
     * Get sfpCaracter
     *
     * @return string 
     */
    public function getSfpCaracter()
    {
        return $this->sfpCaracter;
    }

    /**
     * Set sfpRelacionDolar
     *
     * @param float $sfpRelacionDolar
     * @return moneda
     */
    public function setSfpRelacionDolar($sfpRelacionDolar)
    {
        $this->sfpRelacionDolar = $sfpRelacionDolar;

        return $this;
    }

    /**
     * Get sfpRelacionDolar
     *
     * @return float 
     */
    public function getSfpRelacionDolar()
    {
        return $this->sfpRelacionDolar;
    }

    /**
     * Set sfpDescripcion
     *
     * @param string $sfpDescripcion
     * @return moneda
     */
    public function setSfpDescripcion($sfpDescripcion)
    {
        $this->sfpDescripcion = $sfpDescripcion;

        return $this;
    }

    /**
     * Get sfpDescripcion
     *
     * @return string 
     */
    public function getSfpDescripcion()
    {
        return $this->sfpDescripcion;
    }
}
