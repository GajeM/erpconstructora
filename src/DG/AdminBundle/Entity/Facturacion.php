<?php

namespace DG\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facturacion
 *
 * @ORM\Table(name="facturacion", indexes={@ORM\Index(name="fk_facturacion_tipo_pago1_idx", columns={"tipo_pago_id"}), @ORM\Index(name="fk_facturacion_proyecto1_idx", columns={"proyecto_id"}), @ORM\Index(name="fk_facturacion_cliente1_idx", columns={"cliente_id"}), @ORM\Index(name="fk_facturacion_tipo_factura1_idx", columns={"tipo_factura_id"})})
 * @ORM\Entity
 */
class Facturacion
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
     * @var integer
     *
     * @ORM\Column(name="numero_registro", type="integer", nullable=true)
     */
    private $numeroRegistro;

    /**
     * @var string
     *
     * @ORM\Column(name="nit", type="string", length=25, nullable=true)
     */
    private $nit;

    /**
     * @var string
     *
     * @ORM\Column(name="giro", type="string", length=45, nullable=true)
     */
    private $giro;

    /**
     * @var string
     *
     * @ORM\Column(name="vta_a_cita", type="string", length=45, nullable=true)
     */
    private $vtaACita;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=80, nullable=true)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="departamento", type="string", length=50, nullable=false)
     */
    private $departamento;

    /**
     * @var string
     *
     * @ORM\Column(name="son", type="string", length=150, nullable=true)
     */
    private $son;

    /**
     * @var string
     *
     * @ORM\Column(name="entregado_por", type="string", length=50, nullable=true)
     */
    private $entregadoPor;

    /**
     * @var string
     *
     * @ORM\Column(name="dui_nit_entregado_por", type="string", length=20, nullable=true)
     */
    private $duiNitEntregadoPor;

    /**
     * @var string
     *
     * @ORM\Column(name="recibido_por", type="string", length=45, nullable=true)
     */
    private $recibidoPor;

    /**
     * @var string
     *
     * @ORM\Column(name="dui_nit_recibido_por", type="string", length=20, nullable=true)
     */
    private $duiNitRecibidoPor;

    /**
     * @var \CondicionesPago
     *
     * @ORM\ManyToOne(targetEntity="CondicionesPago")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_pago_id", referencedColumnName="id")
     * })
     */
    private $tipoPago;

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
     * @var \Cliente
     *
     * @ORM\ManyToOne(targetEntity="Cliente")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cliente_id", referencedColumnName="id")
     * })
     */
    private $cliente;

    /**
     * @var \TipoFactura
     *
     * @ORM\ManyToOne(targetEntity="TipoFactura")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_factura_id", referencedColumnName="id")
     * })
     */
    private $tipoFactura;



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
     * @return Facturacion
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
     * Set numeroRegistro
     *
     * @param integer $numeroRegistro
     * @return Facturacion
     */
    public function setNumeroRegistro($numeroRegistro)
    {
        $this->numeroRegistro = $numeroRegistro;

        return $this;
    }

    /**
     * Get numeroRegistro
     *
     * @return integer 
     */
    public function getNumeroRegistro()
    {
        return $this->numeroRegistro;
    }

    /**
     * Set nit
     *
     * @param string $nit
     * @return Facturacion
     */
    public function setNit($nit)
    {
        $this->nit = $nit;

        return $this;
    }

    /**
     * Get nit
     *
     * @return string 
     */
    public function getNit()
    {
        return $this->nit;
    }

    /**
     * Set giro
     *
     * @param string $giro
     * @return Facturacion
     */
    public function setGiro($giro)
    {
        $this->giro = $giro;

        return $this;
    }

    /**
     * Get giro
     *
     * @return string 
     */
    public function getGiro()
    {
        return $this->giro;
    }

    /**
     * Set vtaACita
     *
     * @param string $vtaACita
     * @return Facturacion
     */
    public function setVtaACita($vtaACita)
    {
        $this->vtaACita = $vtaACita;

        return $this;
    }

    /**
     * Get vtaACita
     *
     * @return string 
     */
    public function getVtaACita()
    {
        return $this->vtaACita;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return Facturacion
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
     * Set departamento
     *
     * @param string $departamento
     * @return Facturacion
     */
    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;

        return $this;
    }

    /**
     * Get departamento
     *
     * @return string 
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

    /**
     * Set son
     *
     * @param string $son
     * @return Facturacion
     */
    public function setSon($son)
    {
        $this->son = $son;

        return $this;
    }

    /**
     * Get son
     *
     * @return string 
     */
    public function getSon()
    {
        return $this->son;
    }

    /**
     * Set entregadoPor
     *
     * @param string $entregadoPor
     * @return Facturacion
     */
    public function setEntregadoPor($entregadoPor)
    {
        $this->entregadoPor = $entregadoPor;

        return $this;
    }

    /**
     * Get entregadoPor
     *
     * @return string 
     */
    public function getEntregadoPor()
    {
        return $this->entregadoPor;
    }

    /**
     * Set duiNitEntregadoPor
     *
     * @param string $duiNitEntregadoPor
     * @return Facturacion
     */
    public function setDuiNitEntregadoPor($duiNitEntregadoPor)
    {
        $this->duiNitEntregadoPor = $duiNitEntregadoPor;

        return $this;
    }

    /**
     * Get duiNitEntregadoPor
     *
     * @return string 
     */
    public function getDuiNitEntregadoPor()
    {
        return $this->duiNitEntregadoPor;
    }

    /**
     * Set recibidoPor
     *
     * @param string $recibidoPor
     * @return Facturacion
     */
    public function setRecibidoPor($recibidoPor)
    {
        $this->recibidoPor = $recibidoPor;

        return $this;
    }

    /**
     * Get recibidoPor
     *
     * @return string 
     */
    public function getRecibidoPor()
    {
        return $this->recibidoPor;
    }

    /**
     * Set duiNitRecibidoPor
     *
     * @param string $duiNitRecibidoPor
     * @return Facturacion
     */
    public function setDuiNitRecibidoPor($duiNitRecibidoPor)
    {
        $this->duiNitRecibidoPor = $duiNitRecibidoPor;

        return $this;
    }

    /**
     * Get duiNitRecibidoPor
     *
     * @return string 
     */
    public function getDuiNitRecibidoPor()
    {
        return $this->duiNitRecibidoPor;
    }

    /**
     * Set tipoPago
     *
     * @param \DG\AdminBundle\Entity\CondicionesPago $tipoPago
     * @return Facturacion
     */
    public function setTipoPago(\DG\AdminBundle\Entity\CondicionesPago $tipoPago = null)
    {
        $this->tipoPago = $tipoPago;

        return $this;
    }

    /**
     * Get tipoPago
     *
     * @return \DG\AdminBundle\Entity\CondicionesPago 
     */
    public function getTipoPago()
    {
        return $this->tipoPago;
    }

    /**
     * Set proyecto
     *
     * @param \DG\AdminBundle\Entity\Proyecto $proyecto
     * @return Facturacion
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
     * Set cliente
     *
     * @param \DG\AdminBundle\Entity\Cliente $cliente
     * @return Facturacion
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
     * Set tipoFactura
     *
     * @param \DG\AdminBundle\Entity\TipoFactura $tipoFactura
     * @return Facturacion
     */
    public function setTipoFactura(\DG\AdminBundle\Entity\TipoFactura $tipoFactura = null)
    {
        $this->tipoFactura = $tipoFactura;

        return $this;
    }

    /**
     * Get tipoFactura
     *
     * @return \DG\AdminBundle\Entity\TipoFactura 
     */
    public function getTipoFactura()
    {
        return $this->tipoFactura;
    }
}
