<?php

namespace DG\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetalleFactura
 *
 * @ORM\Table(name="detalle_factura", indexes={@ORM\Index(name="fk_detalle_factura_facturacion1_idx", columns={"facturacion_id"})})
 * @ORM\Entity
 */
class DetalleFactura
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
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="integer", nullable=true)
     */
    private $cantidad;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", length=65535, nullable=true)
     */
    private $descripcion;

    /**
     * @var float
     *
     * @ORM\Column(name="precio_unitario", type="float", precision=10, scale=0, nullable=true)
     */
    private $precioUnitario;

    /**
     * @var float
     *
     * @ORM\Column(name="ventas_no_sujetas", type="float", precision=10, scale=0, nullable=true)
     */
    private $ventasNoSujetas;

    /**
     * @var float
     *
     * @ORM\Column(name="ventas_exentas", type="float", precision=10, scale=0, nullable=true)
     */
    private $ventasExentas;

    /**
     * @var float
     *
     * @ORM\Column(name="ventas_afectas", type="float", precision=10, scale=0, nullable=true)
     */
    private $ventasAfectas;

    /**
     * @var \Facturacion
     *
     * @ORM\ManyToOne(targetEntity="Facturacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="facturacion_id", referencedColumnName="id")
     * })
     */
    private $facturacion;



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
     * Set cantidad
     *
     * @param integer $cantidad
     * @return DetalleFactura
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return DetalleFactura
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
     * Set precioUnitario
     *
     * @param float $precioUnitario
     * @return DetalleFactura
     */
    public function setPrecioUnitario($precioUnitario)
    {
        $this->precioUnitario = $precioUnitario;

        return $this;
    }

    /**
     * Get precioUnitario
     *
     * @return float 
     */
    public function getPrecioUnitario()
    {
        return $this->precioUnitario;
    }

    /**
     * Set ventasNoSujetas
     *
     * @param float $ventasNoSujetas
     * @return DetalleFactura
     */
    public function setVentasNoSujetas($ventasNoSujetas)
    {
        $this->ventasNoSujetas = $ventasNoSujetas;

        return $this;
    }

    /**
     * Get ventasNoSujetas
     *
     * @return float 
     */
    public function getVentasNoSujetas()
    {
        return $this->ventasNoSujetas;
    }

    /**
     * Set ventasExentas
     *
     * @param float $ventasExentas
     * @return DetalleFactura
     */
    public function setVentasExentas($ventasExentas)
    {
        $this->ventasExentas = $ventasExentas;

        return $this;
    }

    /**
     * Get ventasExentas
     *
     * @return float 
     */
    public function getVentasExentas()
    {
        return $this->ventasExentas;
    }

    /**
     * Set ventasAfectas
     *
     * @param float $ventasAfectas
     * @return DetalleFactura
     */
    public function setVentasAfectas($ventasAfectas)
    {
        $this->ventasAfectas = $ventasAfectas;

        return $this;
    }

    /**
     * Get ventasAfectas
     *
     * @return float 
     */
    public function getVentasAfectas()
    {
        return $this->ventasAfectas;
    }

    /**
     * Set facturacion
     *
     * @param \DG\AdminBundle\Entity\Facturacion $facturacion
     * @return DetalleFactura
     */
    public function setFacturacion(\DG\AdminBundle\Entity\Facturacion $facturacion = null)
    {
        $this->facturacion = $facturacion;

        return $this;
    }

    /**
     * Get facturacion
     *
     * @return \DG\AdminBundle\Entity\Facturacion 
     */
    public function getFacturacion()
    {
        return $this->facturacion;
    }
}
