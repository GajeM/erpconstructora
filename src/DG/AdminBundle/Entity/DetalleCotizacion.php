<?php

namespace DG\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetalleCotizacion
 *
 * @ORM\Table(name="detalle_cotizacion", indexes={@ORM\Index(name="fk_detalle_cotizacion_cootizacion1_idx", columns={"cootizacion_id"}), @ORM\Index(name="fk_detalle_cotizacion_ma_maquina1_idx", columns={"ma_maquina_id"})})
 * @ORM\Entity
 */
class DetalleCotizacion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="integer", nullable=false)
     */
    private $cantidad;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_equipo", type="string", length=150, nullable=false)
     */
    private $descripcionEquipo;

    /**
     * @var string
     *
     * @ORM\Column(name="tiempo", type="string", length=45, nullable=true)
     */
    private $tiempo;

    /**
     * @var \Cootizacion
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Cootizacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cootizacion_id", referencedColumnName="id")
     * })
     */
    private $cootizacion;

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
     * Set id
     *
     * @param integer $id
     * @return DetalleCotizacion
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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
     * @return DetalleCotizacion
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
     * Set descripcionEquipo
     *
     * @param string $descripcionEquipo
     * @return DetalleCotizacion
     */
    public function setDescripcionEquipo($descripcionEquipo)
    {
        $this->descripcionEquipo = $descripcionEquipo;

        return $this;
    }

    /**
     * Get descripcionEquipo
     *
     * @return string 
     */
    public function getDescripcionEquipo()
    {
        return $this->descripcionEquipo;
    }

    /**
     * Set tiempo
     *
     * @param string $tiempo
     * @return DetalleCotizacion
     */
    public function setTiempo($tiempo)
    {
        $this->tiempo = $tiempo;

        return $this;
    }

    /**
     * Get tiempo
     *
     * @return string 
     */
    public function getTiempo()
    {
        return $this->tiempo;
    }

    /**
     * Set cootizacion
     *
     * @param \DG\AdminBundle\Entity\Cootizacion $cootizacion
     * @return DetalleCotizacion
     */
    public function setCootizacion(\DG\AdminBundle\Entity\Cootizacion $cootizacion)
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
     * Set maMaquina
     *
     * @param \DG\AdminBundle\Entity\MaMaquina $maMaquina
     * @return DetalleCotizacion
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
}
