<?php

namespace DG\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CajaChica
 *
 * @ORM\Table(name="caja_chica", indexes={@ORM\Index(name="fk_caja_chica_estado_registro1_idx", columns={"estado_registro_id"}), @ORM\Index(name="fk_caja_chica_empleado1", columns={"empleado_id"})})
 * @ORM\Entity
 */
class CajaChica
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
     * @ORM\Column(name="fecha", type="date", nullable=false)
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="concepto", type="string", length=255, nullable=false)
     */
    private $concepto;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=60, nullable=true)
     */
    private $nombre;

    /**
     * @var float
     *
     * @ORM\Column(name="cantidad_por", type="float", precision=10, scale=0, nullable=true)
     */
    private $cantidadPor;

    /**
     * @var string
     *
     * @ORM\Column(name="valor", type="string", length=45, nullable=true)
     */
    private $valor;

    /**
     * @var \EstadoRegistro
     *
     * @ORM\ManyToOne(targetEntity="EstadoRegistro")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="estado_registro_id", referencedColumnName="id")
     * })
     */
    private $estadoRegistro;


    
        /**
     * @var \Empleado
     *
     * @ORM\ManyToOne(targetEntity="Empleado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="empleado_id", referencedColumnName="id")
     * })
     */
    private $empleadoId;
    
    

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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return CajaChica
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set concepto
     *
     * @param string $concepto
     * @return CajaChica
     */
    public function setConcepto($concepto)
    {
        $this->concepto = $concepto;

        return $this;
    }

    /**
     * Get concepto
     *
     * @return string 
     */
    public function getConcepto()
    {
        return $this->concepto;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return CajaChica
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set cantidadPor
     *
     * @param float $cantidadPor
     * @return CajaChica
     */
    public function setCantidadPor($cantidadPor)
    {
        $this->cantidadPor = $cantidadPor;

        return $this;
    }

    /**
     * Get cantidadPor
     *
     * @return float 
     */
    public function getCantidadPor()
    {
        return $this->cantidadPor;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return CajaChica
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return string 
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set estadoRegistro
     *
     * @param \DG\AdminBundle\Entity\EstadoRegistro $estadoRegistro
     * @return CajaChica
     */
    public function setEstadoRegistro(\DG\AdminBundle\Entity\EstadoRegistro $estadoRegistro = null)
    {
        $this->estadoRegistro = $estadoRegistro;

        return $this;
    }

    /**
     * Get estadoRegistro
     *
     * @return \DG\AdminBundle\Entity\EstadoRegistro 
     */
    public function getEstadoRegistro()
    {
        return $this->estadoRegistro;
    }

    /**
     * Set empleadoId
     *
     * @param \DG\AdminBundle\Entity\Empleado $empleadoId
     * @return CajaChica
     */
    public function setEmpleadoId(\DG\AdminBundle\Entity\Empleado $empleadoId = null)
    {
        $this->empleadoId = $empleadoId;

        return $this;
    }

    /**
     * Get empleadoId
     *
     * @return \DG\AdminBundle\Entity\Empleado 
     */
    public function getEmpleadoId()
    {
        return $this->empleadoId;
    }
    
    
    
}
