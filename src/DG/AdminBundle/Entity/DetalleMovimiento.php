<?php

namespace DG\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetalleMovimiento
 *
 * @ORM\Table(name="detalle_movimiento", indexes={@ORM\Index(name="fk_detalle_movimiento_movimiento_de_equipo1_idx", columns={"movimiento_de_equipo_id"})})
 * @ORM\Entity
 */
class DetalleMovimiento
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
     * @ORM\Column(name="descripcion", type="string", length=250, nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=45, nullable=true)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="serie", type="string", length=45, nullable=true)
     */
    private $serie;

    /**
     * @var \MovimientoDeEquipo
     *
     * @ORM\ManyToOne(targetEntity="MovimientoDeEquipo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="movimiento_de_equipo_id", referencedColumnName="id")
     * })
     */
    private $movimientoDeEquipo;



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
     * @return DetalleMovimiento
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
     * @return DetalleMovimiento
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
     * Set codigo
     *
     * @param string $codigo
     * @return DetalleMovimiento
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set serie
     *
     * @param string $serie
     * @return DetalleMovimiento
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
     * Set movimientoDeEquipo
     *
     * @param \DG\AdminBundle\Entity\MovimientoDeEquipo $movimientoDeEquipo
     * @return DetalleMovimiento
     */
    public function setMovimientoDeEquipo(\DG\AdminBundle\Entity\MovimientoDeEquipo $movimientoDeEquipo = null)
    {
        $this->movimientoDeEquipo = $movimientoDeEquipo;

        return $this;
    }

    /**
     * Get movimientoDeEquipo
     *
     * @return \DG\AdminBundle\Entity\MovimientoDeEquipo 
     */
    public function getMovimientoDeEquipo()
    {
        return $this->movimientoDeEquipo;
    }
}
