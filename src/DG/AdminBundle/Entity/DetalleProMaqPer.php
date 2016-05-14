<?php

namespace DG\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetalleProMaqPer
 *
 * @ORM\Table(name="detalle_pro_maq_per", indexes={@ORM\Index(name="fk_detalle_pro_maq_per_proyecto1_idx", columns={"proyecto_id"}), @ORM\Index(name="fk_detalle_pro_maq_per_ma_maquina1_idx", columns={"ma_maquina_id"}), @ORM\Index(name="fk_detalle_pro_maq_per_empleado1_idx", columns={"empleado_id"})})
 * @ORM\Entity
 */
class DetalleProMaqPer
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
     * @ORM\Column(name="precio_cobro", type="float", precision=10, scale=0, nullable=true)
     */
    private $precioCobro;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero_horas_minimas", type="integer", nullable=true)
     */
    private $numeroHorasMinimas;

    /**
     * @var float
     *
     * @ORM\Column(name="sueldo_dia_trabajador", type="float", precision=10, scale=0, nullable=true)
     */
    private $sueldoDiaTrabajador;

    /**
     * @var float
     *
     * @ORM\Column(name="biaticos", type="float", precision=10, scale=0, nullable=true)
     */
    private $biaticos;

    /**
     * @var integer
     *
     * @ORM\Column(name="ope_estado", type="integer", nullable=true)
     */
    private $opeEstado;

    /**
     * @var integer
     *
     * @ORM\Column(name="tipo_cobro", type="integer", nullable=true)
     */
    private $tipoCobro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_registro", type="date", nullable=true)
     */
    private $fechaRegistro;

    /**
     * @var integer
     *
     * @ORM\Column(name="estado", type="integer", nullable=true)
     */
    private $estado;

    /**
     * @var \Proyecto
     *
     * @ORM\ManyToOne(targetEntity="Proyecto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="proyecto_id", referencedColumnName="id")
     * })
     */
    private $proyecto;

    /**
     * @var \MaMaquina
     *
     * @ORM\ManyToOne(targetEntity="MaMaquina")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ma_maquina_id", referencedColumnName="id")
     * })
     */
    private $maMaquina;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set precioCobro
     *
     * @param float $precioCobro
     * @return DetalleProMaqPer
     */
    public function setPrecioCobro($precioCobro)
    {
        $this->precioCobro = $precioCobro;

        return $this;
    }

    /**
     * Get precioCobro
     *
     * @return float 
     */
    public function getPrecioCobro()
    {
        return $this->precioCobro;
    }

    /**
     * Set numeroHorasMinimas
     *
     * @param integer $numeroHorasMinimas
     * @return DetalleProMaqPer
     */
    public function setNumeroHorasMinimas($numeroHorasMinimas)
    {
        $this->numeroHorasMinimas = $numeroHorasMinimas;

        return $this;
    }

    /**
     * Get numeroHorasMinimas
     *
     * @return integer 
     */
    public function getNumeroHorasMinimas()
    {
        return $this->numeroHorasMinimas;
    }

    /**
     * Set sueldoDiaTrabajador
     *
     * @param float $sueldoDiaTrabajador
     * @return DetalleProMaqPer
     */
    public function setSueldoDiaTrabajador($sueldoDiaTrabajador)
    {
        $this->sueldoDiaTrabajador = $sueldoDiaTrabajador;

        return $this;
    }

    /**
     * Get sueldoDiaTrabajador
     *
     * @return float 
     */
    public function getSueldoDiaTrabajador()
    {
        return $this->sueldoDiaTrabajador;
    }

    /**
     * Set biaticos
     *
     * @param float $biaticos
     * @return DetalleProMaqPer
     */
    public function setBiaticos($biaticos)
    {
        $this->biaticos = $biaticos;

        return $this;
    }

    /**
     * Get biaticos
     *
     * @return float 
     */
    public function getBiaticos()
    {
        return $this->biaticos;
    }

    /**
     * Set opeEstado
     *
     * @param integer $opeEstado
     * @return DetalleProMaqPer
     */
    public function setOpeEstado($opeEstado)
    {
        $this->opeEstado = $opeEstado;

        return $this;
    }

    /**
     * Get opeEstado
     *
     * @return integer 
     */
    public function getOpeEstado()
    {
        return $this->opeEstado;
    }

    /**
     * Set tipoCobro
     *
     * @param integer $tipoCobro
     * @return DetalleProMaqPer
     */
    public function setTipoCobro($tipoCobro)
    {
        $this->tipoCobro = $tipoCobro;

        return $this;
    }

    /**
     * Get tipoCobro
     *
     * @return integer 
     */
    public function getTipoCobro()
    {
        return $this->tipoCobro;
    }

    /**
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     * @return DetalleProMaqPer
     */
    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;

        return $this;
    }

    /**
     * Get fechaRegistro
     *
     * @return \DateTime 
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    /**
     * Set estado
     *
     * @param integer $estado
     * @return DetalleProMaqPer
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return integer 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set proyecto
     *
     * @param \DG\AdminBundle\Entity\Proyecto $proyecto
     * @return DetalleProMaqPer
     */
    public function setProyecto(\DG\AdminBundle\Entity\Proyecto $proyecto = null)
    {
        $this->proyecto = $proyecto;

        return $this;
    }

    /**
     * Get proyecto
     *
     * @return \DG\AdminBundle\Entity\Proyecto 
     */
    public function getProyecto()
    {
        return $this->proyecto;
    }

    /**
     * Set maMaquina
     *
     * @param \DG\AdminBundle\Entity\MaMaquina $maMaquina
     * @return DetalleProMaqPer
     */
    public function setMaMaquina(\DG\AdminBundle\Entity\MaMaquina $maMaquina = null)
    {
        $this->maMaquina = $maMaquina;

        return $this;
    }

    /**
     * Get maMaquina
     *
     * @return \DG\AdminBundle\Entity\MaMaquina 
     */
    public function getMaMaquina()
    {
        return $this->maMaquina;
    }

    /**
     * Set empleado
     *
     * @param \DG\AdminBundle\Entity\Empleado $empleado
     * @return DetalleProMaqPer
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
}
