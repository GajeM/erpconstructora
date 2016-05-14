<?php

namespace DG\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetalleFecha
 *
 * @ORM\Table(name="detalle_fecha", indexes={@ORM\Index(name="fk_detalle_fecha_detalle_cotizacion1_idx", columns={"detalle_cotizacion_id"})})
 * @ORM\Entity
 */
class DetalleFecha
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha_inicio", type="string", length=45, nullable=true)
     */
    private $fechaInicio;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha_final", type="string", length=45, nullable=false)
     */
    private $fechaFinal;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero_dias_trabajo", type="integer", nullable=true)
     */
    private $numeroDiasTrabajo;

    /**
     * @var \DetalleCotizacion
     *
     * @ORM\ManyToOne(targetEntity="DetalleCotizacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="detalle_cotizacion_id", referencedColumnName="id")
     * })
     */
    private $detalleCotizacion;



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
     * Set fechaInicio
     *
     * @param string $fechaInicio
     * @return DetalleFecha
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return string 
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * Set fechaFinal
     *
     * @param string $fechaFinal
     * @return DetalleFecha
     */
    public function setFechaFinal($fechaFinal)
    {
        $this->fechaFinal = $fechaFinal;

        return $this;
    }

    /**
     * Get fechaFinal
     *
     * @return string 
     */
    public function getFechaFinal()
    {
        return $this->fechaFinal;
    }

    /**
     * Set numeroDiasTrabajo
     *
     * @param integer $numeroDiasTrabajo
     * @return DetalleFecha
     */
    public function setNumeroDiasTrabajo($numeroDiasTrabajo)
    {
        $this->numeroDiasTrabajo = $numeroDiasTrabajo;

        return $this;
    }

    /**
     * Get numeroDiasTrabajo
     *
     * @return integer 
     */
    public function getNumeroDiasTrabajo()
    {
        return $this->numeroDiasTrabajo;
    }

    /**
     * Set detalleCotizacion
     *
     * @param \DG\AdminBundle\Entity\DetalleCotizacion $detalleCotizacion
     * @return DetalleFecha
     */
    public function setDetalleCotizacion(\DG\AdminBundle\Entity\DetalleCotizacion $detalleCotizacion = null)
    {
        $this->detalleCotizacion = $detalleCotizacion;

        return $this;
    }

    /**
     * Get detalleCotizacion
     *
     * @return \DG\AdminBundle\Entity\DetalleCotizacion 
     */
    public function getDetalleCotizacion()
    {
        return $this->detalleCotizacion;
    }
}
