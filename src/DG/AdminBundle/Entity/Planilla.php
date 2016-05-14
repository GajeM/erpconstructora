<?php

namespace DG\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Planilla
 *
 * @ORM\Table(name="planilla", indexes={@ORM\Index(name="fk_planilla_tipo_planilla1_idx", columns={"tipo_planilla_id"})})
 * @ORM\Entity
 */
class Planilla
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_inicio", type="date", nullable=true)
     */
    private $fechaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_final", type="date", nullable=true)
     */
    private $fechaFinal;

    /**
     * @var \TipoPlanilla
     *
     * @ORM\ManyToOne(targetEntity="TipoPlanilla")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_planilla_id", referencedColumnName="id")
     * })
     */
    private $tipoPlanilla;



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
     * @param \DateTime $fechaInicio
     * @return Planilla
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return \DateTime 
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * Set fechaFinal
     *
     * @param \DateTime $fechaFinal
     * @return Planilla
     */
    public function setFechaFinal($fechaFinal)
    {
        $this->fechaFinal = $fechaFinal;

        return $this;
    }

    /**
     * Get fechaFinal
     *
     * @return \DateTime 
     */
    public function getFechaFinal()
    {
        return $this->fechaFinal;
    }

    /**
     * Set tipoPlanilla
     *
     * @param \DG\AdminBundle\Entity\TipoPlanilla $tipoPlanilla
     * @return Planilla
     */
    public function setTipoPlanilla(\DG\AdminBundle\Entity\TipoPlanilla $tipoPlanilla = null)
    {
        $this->tipoPlanilla = $tipoPlanilla;

        return $this;
    }

    /**
     * Get tipoPlanilla
     *
     * @return \DG\AdminBundle\Entity\TipoPlanilla 
     */
    public function getTipoPlanilla()
    {
        return $this->tipoPlanilla;
    }
}
