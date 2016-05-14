<?php

namespace DG\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetallePlanilla
 *
 * @ORM\Table(name="detalle_planilla", indexes={@ORM\Index(name="fk_detalle_planilla_empleado1_idx", columns={"empleado_id"}), @ORM\Index(name="fk_detalle_planilla_planilla1_idx", columns={"planilla_id"})})
 * @ORM\Entity
 */
class DetallePlanilla
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
     * @var float
     *
     * @ORM\Column(name="sueldo_base", type="float", precision=10, scale=0, nullable=true)
     */
    private $sueldoBase;

    /**
     * @var float
     *
     * @ORM\Column(name="isss", type="float", precision=10, scale=0, nullable=true)
     */
    private $isss;

    /**
     * @var float
     *
     * @ORM\Column(name="afp", type="float", precision=10, scale=0, nullable=true)
     */
    private $afp;

    /**
     * @var float
     *
     * @ORM\Column(name="renta", type="float", precision=10, scale=0, nullable=true)
     */
    private $renta;

    /**
     * @var float
     *
     * @ORM\Column(name="total_deducible", type="float", precision=10, scale=0, nullable=true)
     */
    private $totalDeducible;

    /**
     * @var float
     *
     * @ORM\Column(name="total_descuentos", type="float", precision=10, scale=0, nullable=true)
     */
    private $totalDescuentos;

    /**
     * @var float
     *
     * @ORM\Column(name="total_pagar", type="float", precision=10, scale=0, nullable=true)
     */
    private $totalPagar;

    /**
     * @var \Empleado
     *
     * @ORM\ManyToOne(targetEntity="Empleado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="empleado_id", referencedColumnName="id")
     * })
     */
    private $empleado;

    /**
     * @var \Planilla
     *
     * @ORM\ManyToOne(targetEntity="Planilla")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="planilla_id", referencedColumnName="id")
     * })
     */
    private $planilla;



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
     * Set sueldoBase
     *
     * @param float $sueldoBase
     * @return DetallePlanilla
     */
    public function setSueldoBase($sueldoBase)
    {
        $this->sueldoBase = $sueldoBase;

        return $this;
    }

    /**
     * Get sueldoBase
     *
     * @return float 
     */
    public function getSueldoBase()
    {
        return $this->sueldoBase;
    }

    /**
     * Set isss
     *
     * @param float $isss
     * @return DetallePlanilla
     */
    public function setIsss($isss)
    {
        $this->isss = $isss;

        return $this;
    }

    /**
     * Get isss
     *
     * @return float 
     */
    public function getIsss()
    {
        return $this->isss;
    }

    /**
     * Set afp
     *
     * @param float $afp
     * @return DetallePlanilla
     */
    public function setAfp($afp)
    {
        $this->afp = $afp;

        return $this;
    }

    /**
     * Get afp
     *
     * @return float 
     */
    public function getAfp()
    {
        return $this->afp;
    }

    /**
     * Set renta
     *
     * @param float $renta
     * @return DetallePlanilla
     */
    public function setRenta($renta)
    {
        $this->renta = $renta;

        return $this;
    }

    /**
     * Get renta
     *
     * @return float 
     */
    public function getRenta()
    {
        return $this->renta;
    }

    /**
     * Set totalDeducible
     *
     * @param float $totalDeducible
     * @return DetallePlanilla
     */
    public function setTotalDeducible($totalDeducible)
    {
        $this->totalDeducible = $totalDeducible;

        return $this;
    }

    /**
     * Get totalDeducible
     *
     * @return float 
     */
    public function getTotalDeducible()
    {
        return $this->totalDeducible;
    }

    /**
     * Set totalDescuentos
     *
     * @param float $totalDescuentos
     * @return DetallePlanilla
     */
    public function setTotalDescuentos($totalDescuentos)
    {
        $this->totalDescuentos = $totalDescuentos;

        return $this;
    }

    /**
     * Get totalDescuentos
     *
     * @return float 
     */
    public function getTotalDescuentos()
    {
        return $this->totalDescuentos;
    }

    /**
     * Set totalPagar
     *
     * @param float $totalPagar
     * @return DetallePlanilla
     */
    public function setTotalPagar($totalPagar)
    {
        $this->totalPagar = $totalPagar;

        return $this;
    }

    /**
     * Get totalPagar
     *
     * @return float 
     */
    public function getTotalPagar()
    {
        return $this->totalPagar;
    }

    /**
     * Set empleado
     *
     * @param \DG\AdminBundle\Entity\Empleado $empleado
     * @return DetallePlanilla
     */
    public function setEmpleado(\DG\AdminBundle\Entity\Empleado $empleado = null)
    {
        $this->empleado = $empleado;

        return $this;
    }

    /**
     * Get empleado
     *
     * @return \DG\AdminBundle\Entity\Empleado 
     */
    public function getEmpleado()
    {
        return $this->empleado;
    }

    /**
     * Set planilla
     *
     * @param \DG\AdminBundle\Entity\Planilla $planilla
     * @return DetallePlanilla
     */
    public function setPlanilla(\DG\AdminBundle\Entity\Planilla $planilla = null)
    {
        $this->planilla = $planilla;

        return $this;
    }

    /**
     * Get planilla
     *
     * @return \DG\AdminBundle\Entity\Planilla 
     */
    public function getPlanilla()
    {
        return $this->planilla;
    }
}
