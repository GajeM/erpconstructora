<?php

namespace DG\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MaExpedienteMantenimiento
 *
 * @ORM\Table(name="ma_expediente_mantenimiento", indexes={@ORM\Index(name="fk_ma_expediente_mantenimiento_ma_mantenimiento1_idx", columns={"ma_mantenimiento_id"}), @ORM\Index(name="fk_ma_expediente_mantenimiento_ma_maquina1_idx", columns={"ma_maquina_id"}), @ORM\Index(name="fk_ma_expediente_mantenimiento_proyecto1_idx", columns={"proyecto_id"}), @ORM\Index(name="fk_ma_expediente_mantenimiento_proveedor1_idx", columns={"proveedor_id"})})
 * @ORM\Entity
 */
class MaExpedienteMantenimiento
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
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="serie", type="string", length=45, nullable=true)
     */
    private $serie;

    /**
     * @var float
     *
     * @ORM\Column(name="costo", type="float", precision=10, scale=0, nullable=true)
     */
    private $costo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", length=65535, nullable=true)
     */
    private $descripcion;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero_factura", type="integer", nullable=true)
     */
    private $numeroFactura;

    /**
     * @var string
     *
     * @ORM\Column(name="placa_numero_equipo", type="string", length=20, nullable=true)
     */
    private $placaNumeroEquipo;

    /**
     * @var string
     *
     * @ORM\Column(name="motorista", type="string", length=30, nullable=true)
     */
    private $motorista;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="integer", nullable=true)
     */
    private $cantidad;

    /**
     * @var integer
     *
     * @ORM\Column(name="orden_suminstro", type="integer", nullable=true)
     */
    private $ordenSuminstro;

    /**
     * @var \MaTipoMantenimiento
     *
     * @ORM\ManyToOne(targetEntity="MaTipoMantenimiento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ma_mantenimiento_id", referencedColumnName="id")
     * })
     */
    private $maMantenimiento;

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
     * @var \Proyecto
     *
     * @ORM\ManyToOne(targetEntity="Proyecto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="proyecto_id", referencedColumnName="id")
     * })
     */
    private $proyecto;

    /**
     * @var \Proveedor
     *
     * @ORM\ManyToOne(targetEntity="Proveedor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="proveedor_id", referencedColumnName="id")
     * })
     */
    private $proveedor;

     /**
     * @var integer
     * @ORM\Column(name="estado", type="integer", nullable=false) 
     */
    private $estado;
    

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
     * @return MaExpedienteMantenimiento
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
     * Set serie
     *
     * @param string $serie
     * @return MaExpedienteMantenimiento
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;

        return $this;
    }

    /**
     * Get serie
     *
     * @return string 
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Set costo
     *
     * @param float $costo
     * @return MaExpedienteMantenimiento
     */
    public function setCosto($costo)
    {
        $this->costo = $costo;

        return $this;
    }

    /**
     * Get costo
     *
     * @return float 
     */
    public function getCosto()
    {
        return $this->costo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return MaExpedienteMantenimiento
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set numeroFactura
     *
     * @param integer $numeroFactura
     * @return MaExpedienteMantenimiento
     */
    public function setNumeroFactura($numeroFactura)
    {
        $this->numeroFactura = $numeroFactura;

        return $this;
    }

    /**
     * Get numeroFactura
     *
     * @return integer 
     */
    public function getNumeroFactura()
    {
        return $this->numeroFactura;
    }

    /**
     * Set placaNumeroEquipo
     *
     * @param string $placaNumeroEquipo
     * @return MaExpedienteMantenimiento
     */
    public function setPlacaNumeroEquipo($placaNumeroEquipo)
    {
        $this->placaNumeroEquipo = $placaNumeroEquipo;

        return $this;
    }

    /**
     * Get placaNumeroEquipo
     *
     * @return string 
     */
    public function getPlacaNumeroEquipo()
    {
        return $this->placaNumeroEquipo;
    }

    /**
     * Set motorista
     *
     * @param string $motorista
     * @return MaExpedienteMantenimiento
     */
    public function setMotorista($motorista)
    {
        $this->motorista = $motorista;

        return $this;
    }

    /**
     * Get motorista
     *
     * @return string 
     */
    public function getMotorista()
    {
        return $this->motorista;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     * @return MaExpedienteMantenimiento
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set ordenSuminstro
     *
     * @param integer $ordenSuminstro
     * @return MaExpedienteMantenimiento
     */
    public function setOrdenSuminstro($ordenSuminstro)
    {
        $this->ordenSuminstro = $ordenSuminstro;

        return $this;
    }

    /**
     * Get ordenSuminstro
     *
     * @return integer 
     */
    public function getOrdenSuminstro()
    {
        return $this->ordenSuminstro;
    }

    /**
     * Set maMantenimiento
     *
     * @param \DG\AdminBundle\Entity\MaTipoMantenimiento $maMantenimiento
     * @return MaExpedienteMantenimiento
     */
    public function setMaMantenimiento(\DG\AdminBundle\Entity\MaTipoMantenimiento $maMantenimiento = null)
    {
        $this->maMantenimiento = $maMantenimiento;

        return $this;
    }

    /**
     * Get maMantenimiento
     *
     * @return \DG\AdminBundle\Entity\MaTipoMantenimiento 
     */
    public function getMaMantenimiento()
    {
        return $this->maMantenimiento;
    }

    /**
     * Set maMaquina
     *
     * @param \DG\AdminBundle\Entity\MaMaquina $maMaquina
     * @return MaExpedienteMantenimiento
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
     * Set proyecto
     *
     * @param \DG\AdminBundle\Entity\Proyecto $proyecto
     * @return MaExpedienteMantenimiento
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
     * Set proveedor
     *
     * @param \DG\AdminBundle\Entity\Proveedor $proveedor
     * @return MaExpedienteMantenimiento
     */
    public function setProveedor(\DG\AdminBundle\Entity\Proveedor $proveedor = null)
    {
        $this->proveedor = $proveedor;

        return $this;
    }

    /**
     * Get proveedor
     *
     * @return \DG\AdminBundle\Entity\Proveedor 
     */
    public function getProveedor()
    {
        return $this->proveedor;
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
    
    
    
    
    
    
    
    
}
