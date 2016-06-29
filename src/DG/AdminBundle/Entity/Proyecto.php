<?php

namespace DG\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proyecto
 *
 * @ORM\Table(name="proyecto", indexes={@ORM\Index(name="fk_proyecto_cliente1_idx", columns={"cliente_id"}), @ORM\Index(name="fk_proyecto_contacto1_idx", columns={"contacto_id"}), @ORM\Index(name="fk_proyecto_estado_proyecto1_idx", columns={"estado_proyecto_id"}), @ORM\Index(name="fk_proyecto_tipo_proyecto1_idx", columns={"tipo_proyecto_id"}), @ORM\Index(name="fk_proyecto_cootizacion1_idx", columns={"cootizacion_id"}), @ORM\Index(name="fk_proyecto_encargado_proyecto1_idx", columns={"encargado_proyecto_id"})})
 * @ORM\Entity
 */
class Proyecto
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
     * @ORM\Column(name="nombre", type="string", length=60, nullable=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="text", length=65535, nullable=true)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", length=45, nullable=true)
     */
    private $observaciones;

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
     * @var \Cliente
     *
     * @ORM\ManyToOne(targetEntity="Cliente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cliente_id", referencedColumnName="id")
     * })
     */
    private $cliente;

    /**
     * @var \Contacto
     *
     * @ORM\ManyToOne(targetEntity="Contacto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contacto_id", referencedColumnName="id")
     * })
     */
    private $contacto;

    /**
     * @var \EstadoProyecto
     *
     * @ORM\ManyToOne(targetEntity="EstadoProyecto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="estado_proyecto_id", referencedColumnName="id")
     * })
     */
    private $estadoProyecto;

    /**
     * @var \TipoProyecto
     *
     * @ORM\ManyToOne(targetEntity="TipoProyecto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_proyecto_id", referencedColumnName="id")
     * })
     */
    private $tipoProyecto;

    /**
     * @var \Cootizacion
     *
     * @ORM\ManyToOne(targetEntity="Cootizacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cootizacion_id", referencedColumnName="id")
     * })
     */
    private $cootizacion;

    /**
     * @var \EncargadoProyecto
     *
     * @ORM\ManyToOne(targetEntity="EncargadoProyecto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="encargado_proyecto_id", referencedColumnName="id")
     * })
     */
    private $encargadoProyecto;

      /**
     * @var integer
     * @ORM\Column(name="estado", type="integer", nullable=false) 
     */
    private $estado;
    
     /**
     * @var string
     * @ORM\Column(name="codigo", type="string", length=20,  nullable=false) 
     */
    private $codigo;
    
    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", nullable=false)
     */
    private $longitude;
    
     /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", nullable=false)
     */
    private $latitude;
    
    
     /**
     * @var integer
     * @ORM\Column(name="tipo_contrato", type="integer", nullable=false) 
     */
    private $tipoContrato;
    
    

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
     * Set nombre
     *
     * @param string $nombre
     * @return Proyecto
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
     * Set direccion
     *
     * @param string $direccion
     * @return Proyecto
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return Proyecto
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string 
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     * @return Proyecto
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
     * @return Proyecto
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
     * Set cliente
     *
     * @param \DG\AdminBundle\Entity\Cliente $cliente
     * @return Proyecto
     */
    public function setCliente(\DG\AdminBundle\Entity\Cliente $cliente = null)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \DG\AdminBundle\Entity\Cliente 
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set contacto
     *
     * @param \DG\AdminBundle\Entity\Contacto $contacto
     * @return Proyecto
     */
    public function setContacto(\DG\AdminBundle\Entity\Contacto $contacto = null)
    {
        $this->contacto = $contacto;

        return $this;
    }

    /**
     * Get contacto
     *
     * @return \DG\AdminBundle\Entity\Contacto 
     */
    public function getContacto()
    {
        return $this->contacto;
    }

    /**
     * Set estadoProyecto
     *
     * @param \DG\AdminBundle\Entity\EstadoProyecto $estadoProyecto
     * @return Proyecto
     */
    public function setEstadoProyecto(\DG\AdminBundle\Entity\EstadoProyecto $estadoProyecto = null)
    {
        $this->estadoProyecto = $estadoProyecto;

        return $this;
    }

    /**
     * Get estadoProyecto
     *
     * @return \DG\AdminBundle\Entity\EstadoProyecto 
     */
    public function getEstadoProyecto()
    {
        return $this->estadoProyecto;
    }

    /**
     * Set tipoProyecto
     *
     * @param \DG\AdminBundle\Entity\TipoProyecto $tipoProyecto
     * @return Proyecto
     */
    public function setTipoProyecto(\DG\AdminBundle\Entity\TipoProyecto $tipoProyecto = null)
    {
        $this->tipoProyecto = $tipoProyecto;

        return $this;
    }

    /**
     * Get tipoProyecto
     *
     * @return \DG\AdminBundle\Entity\TipoProyecto 
     */
    public function getTipoProyecto()
    {
        return $this->tipoProyecto;
    }

    /**
     * Set cootizacion
     *
     * @param \DG\AdminBundle\Entity\Cootizacion $cootizacion
     * @return Proyecto
     */
    public function setCootizacion(\DG\AdminBundle\Entity\Cootizacion $cootizacion = null)
    {
        $this->cootizacion = $cootizacion;

        return $this;
    }

    /**
     * Get cootizacion
     *
     * @return \DG\AdminBundle\Entity\Cootizacion 
     */
    public function getCootizacion()
    {
        return $this->cootizacion;
    }

    /**
     * Set encargadoProyecto
     *
     * @param \DG\AdminBundle\Entity\EncargadoProyecto $encargadoProyecto
     * @return Proyecto
     */
    public function setEncargadoProyecto(\DG\AdminBundle\Entity\EncargadoProyecto $encargadoProyecto = null)
    {
        $this->encargadoProyecto = $encargadoProyecto;

        return $this;
    }

    /**
     * Get encargadoProyecto
     *
     * @return \DG\AdminBundle\Entity\EncargadoProyecto 
     */
    public function getEncargadoProyecto()
    {
        return $this->encargadoProyecto;
    }
    
     public function __toString() {
  return $this->nombre;
}


     /**
     * Set estado
     *
     * @param string $estado
     * @return Cliente
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
     * Set codigo
     *
     * @param integer $codigo
     * @return Cliente
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get estado
     *
     * @return integer 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }
    
    
     /**
     * Set latitude
     *
     * @param float $latitude
     * @return CtlEmpresa
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }
    
    
      /**
     * Set longitude
     *
     * @param float $longitude
     * @return CtlEmpresa
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
    
    
     /**
     * Set estado
     *
     * @param string $tipoContrato
     * @return Cliente
     */
    public function setTipoContrato($tipoContrato)
    {
        $this->tipoContrato = $tipoContrato;

        return $this;
    }

    /**
     * Get tipoContrato
     *
     * @return integer 
     */
    public function getTipoContrato()
    {
        return $this->tipoContrato;
    }
    
}
