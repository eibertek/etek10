<?php

namespace Etk\Bundle\SFPBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * registro
 */
class registro
{
    /**
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $sfpIdRegistro;

    /**
     * @var string
     */
    private $sfpNombre;

    /**
     * @var \Date
     */
    private $sfpFecha;

    /**
     * @var string
     */
    private $sfpCuenta;

    /**
     * @var string
     */
    private $sfpTipo;

    /**
     * @var float
     */
    private $sfpMonto;

    /**
     * @var string
     */
    private $sfpMoneda;

    /**
     * @var string
     */
    private $sfpDescripcion;

    /**
     * @var \DateTime
     */
    private $sfpFechaAlta;

    /**
     * @var \DateTime
     */
    private $sfpFechaEditado;

    /**
     * @var string
     */
    private $sfpIdUsuario;

    public function __construct()
    {
        $this->sfpFechaAlta = new \DateTime();
        $this->sfpFechaEditado = new \DateTime();
    }

    /**
     * Set sfpIdRegistro
     *
     * @param string $sfpIdRegistro
     * @return registro
     */
    private function setSfpIdRegistro($sfpIdRegistro)
    {
        $this->sfpIdRegistro = $sfpIdRegistro;

        return $this;
    }

    /**
     * Get sfpIdRegistro
     *
     * @return string 
     */
    public function getSfpIdRegistro()
    {
        return $this->sfpIdRegistro;
    }

    /**
     * Set sfpNombre
     *
     * @param string $sfpNombre
     * @return registro
     */
    public function setSfpNombre($sfpNombre)
    {
        $this->sfpNombre = $sfpNombre;

        return $this;
    }

    /**
     * Get sfpNombre
     *
     * @return string 
     */
    public function getSfpNombre()
    {
        return $this->sfpNombre;
    }

    /**
     * Set sfpFecha
     *
     * @param \Date $sfpFecha
     * @return registro
     */
    public function setSfpFecha($sfpFecha)
    {
        $this->sfpFecha = $sfpFecha;

        return $this;
    }

    /**
     * Get sfpFecha
     *
     * @return \Date 
     */
    public function getSfpFecha()
    {
        return $this->sfpFecha;
    }

    /**
     * Set sfpCuenta
     *
     * @param string $sfpCuenta
     * @return registro
     */
    public function setSfpCuenta($sfpCuenta)
    {
        $this->sfpCuenta = $sfpCuenta;

        return $this;
    }

    /**
     * Get sfpCuenta
     *
     * @return string 
     */
    public function getSfpCuenta()
    {
        return $this->sfpCuenta;
    }

    /**
     * Set sfpTipo
     *
     * @param string $sfpTipo
     * @return registro
     */
    public function setSfpTipo($sfpTipo)
    {
        $this->sfpTipo = $sfpTipo;

        return $this;
    }

    /**
     * Get sfpTipo
     *
     * @return string 
     */
    public function getSfpTipo()
    {
        return $this->sfpTipo;
    }

    /**
     * Set sfpMonto
     *
     * @param float $sfpMonto
     * @return registro
     */
    public function setSfpMonto($sfpMonto)
    {
        $this->sfpMonto = $sfpMonto;

        return $this;
    }

    /**
     * Get sfpMonto
     *
     * @return float 
     */
    public function getSfpMonto()
    {
        return $this->sfpMonto;
    }

    /**
     * Set sfpMoneda
     *
     * @param string $sfpMoneda
     * @return registro
     */
    public function setSfpMoneda($sfpMoneda)
    {
        $this->sfpMoneda = $sfpMoneda;

        return $this;
    }

    /**
     * Get sfpMoneda
     *
     * @return string 
     */
    public function getSfpMoneda()
    {
        return $this->sfpMoneda;
    }

    /**
     * Set sfpDescripcion
     *
     * @param string $sfpDescripcion
     * @return registro
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

    /**
     * Set sfpFechaAlta
     *
     * @param \DateTime $sfpFechaAlta
     * @return registro
     */
    public function setSfpFechaAlta($sfpFechaAlta)
    {
        $this->sfpFechaAlta = $sfpFechaAlta;

        return $this;
    }

    /**
     * Get sfpFechaAlta
     *
     * @return \DateTime 
     */
    public function getSfpFechaAlta()
    {
        return $this->sfpFechaAlta;
    }

    /**
     * Set sfpFechaEditado
     *
     * @param \DateTime $sfpFechaEditado
     * @return registro
     */
    public function setSfpFechaEditado($sfpFechaEditado)
    {
        $this->sfpFechaEditado = $sfpFechaEditado;

        return $this;
    }

    /**
     * Get sfpFechaEditado
     *
     * @return \DateTime 
     */
    public function getSfpFechaEditado()
    {
        return $this->sfpFechaEditado;
    }

    /**
     * Set sfpIdUsuario
     *
     * @param string $sfpIdUsuario
     * @return registro
     */
    public function setSfpIdUsuario($sfpIdUsuario)
    {
        $this->sfpIdUsuario = $sfpIdUsuario;

        return $this;
    }

    /**
     * Get sfpIdUsuario
     *
     * @return string 
     */
    public function getSfpIdUsuario()
    {
        return $this->sfpIdUsuario;
    }
}
