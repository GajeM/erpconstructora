<?php

namespace DG\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cootizacion
 *
 * @ORM\Table(name="cootizacion", indexes={@ORM\Index(name="fk_cootizacion_tipo_cootizacion1_idx", columns={"tipo_cootizacion_id"}), @ORM\Index(name="fk_cootizacion_tipo_tiempo_cootizacion1_idx", columns={"tipo_tiempo_cootizacion_id"}), @ORM\Index(name="fk_cootizacion_cliente1_idx", columns={"cliente_id"})})
 * @ORM\Entity
 */
class Cootizacion
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
     * @ORM\Column(name="condiciones_comerciales", type="string", length=700, nullable=true)
     */
    private $condicionesComerciales;

    /**
     * @var string
     *
     * @ORM\Column(name="condiciones_generales", type="text", length=65535, nullable=true)
     */
    private $condicionesGenerales;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="cootizacioncol", type="date", nullable=false)
     */
    private $cootizacioncol;

    /**
     * @var integer
     *
     * @ORM\Column(name="estado", type="integer", nullable=true)
     */
    private $estado;

    /**
     * @var \TipoCootizacion
     *
     * @ORM\ManyToOne(targetEntity="TipoCootizacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_cootizacion_id", referencedColumnName="id")
     * })
     */
    private $tipoCootizacion;

    /**
     * @var \TipoTiempoCootizacion
     *
     * @ORM\ManyToOne(targetEntity="TipoTiempoCootizacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_tiempo_cootizacion_id", referencedColumnName="id")
     * })
     */
    private $tipoTiempoCootizacion;

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
     * @return Cootizacion
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
     * Set condicionesComerciales
     *
     * @param string $condicionesComerciales
     * @return Cootizacion
     */
    public function setCondicionesComerciales($condicionesComerciales)
    {
        $this->condicionesComerciales = $condicionesComerciales;

        return $this;
    }

    /**
     * Get condicionesComerciales
     *
     * @return string 
     */
    public function getCondicionesComerciales()
    {
        return $this->condicionesComerciales;
    }

    /**
     * Set condicionesGenerales
     *
     * @param string $condicionesGenerales
     * @return Cootizacion
     */
    public function setCondicionesGenerales($condicionesGenerales)
    {
        $this->condicionesGenerales = $condicionesGenerales;

        return $this;
    }

    /**
     * Get condicionesGenerales
     *
     * @return string 
     */
    public function getCondicionesGenerales()
    {
        return $this->condicionesGenerales;
    }

    /**
     * Set cootizacioncol
     *
     * @param \DateTime $cootizacioncol
     * @return Cootizacion
     */
    public function setCootizacioncol($cootizacioncol)
    {
        $this->cootizacioncol = $cootizacioncol;

        return $this;
    }

    /**
     * Get cootizacioncol
     *
     * @return \DateTime 
     */
    public function getCootizacioncol()
    {
        return $this->cootizacioncol;
    }

    /**
     * Set estado
     *
     * @param integer $estado
     * @return Cootizacion
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
     * Set tipoCootizacion
     *
     * @param \DG\AdminBundle\Entity\TipoCootizacion $tipoCootizacion
     * @return Cootizacion
     */
    public function setTipoCootizacion(\DG\AdminBundle\Entity\TipoCootizacion $tipoCootizacion = null)
    {
        $this->tipoCootizacion = $tipoCootizacion;

        return $this;
    }

    /**
     * Get tipoCootizacion
     *
     * @return \DG\AdminBundle\Entity\TipoCootizacion 
     */
    public function getTipoCootizacion()
    {
        return $this->tipoCootizacion;
    }

    /**
     * Set tipoTiempoCootizacion
     *
     * @param \DG\AdminBundle\Entity\TipoTiempoCootizacion $tipoTiempoCootizacion
     * @return Cootizacion
     */
    public function setTipoTiempoCootizacion(\DG\AdminBundle\Entity\TipoTiempoCootizacion $tipoTiempoCootizacion = null)
    {
        $this->tipoTiempoCootizacion = $tipoTiempoCootizacion;

        return $this;
    }

    /**
     * Get tipoTiempoCootizacion
     *
     * @return \DG\AdminBundle\Entity\TipoTiempoCootizacion 
     */
    public function getTipoTiempoCootizacion()
    {
        return $this->tipoTiempoCootizacion;
    }

    /**
     * Set cliente
     *
     * @param \DG\AdminBundle\Entity\Cliente $cliente
     * @return Cootizacion
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
}
