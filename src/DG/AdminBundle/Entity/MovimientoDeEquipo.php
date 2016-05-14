<?php

namespace DG\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MovimientoDeEquipo
 *
 * @ORM\Table(name="movimiento_de_equipo", indexes={@ORM\Index(name="fk_movimiento_de_equipo_tipo_movimiento_maquinaria1_idx", columns={"tipo_movimiento_maquinaria_id"}), @ORM\Index(name="fk_movimiento_de_equipo_contacto1_idx", columns={"contacto_id"}), @ORM\Index(name="fk_movimiento_de_equipo_cliente1_idx", columns={"cliente_id"})})
 * @ORM\Entity
 */
class MovimientoDeEquipo
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
     * @ORM\Column(name="fecha_registro", type="date", nullable=false)
     */
    private $fechaRegistro;

    /**
     * @var string
     *
     * @ORM\Column(name="hora_salida", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $horaSalida;

    /**
     * @var string
     *
     * @ORM\Column(name="hora_llegada", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $horaLlegada;

    /**
     * @var string
     *
     * @ORM\Column(name="movimiento_de_equipocol", type="string", length=45, nullable=true)
     */
    private $movimientoDeEquipocol;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_proyecto", type="string", length=60, nullable=true)
     */
    private $nombreProyecto;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=80, nullable=true)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="operador", type="string", length=45, nullable=true)
     */
    private $operador;

    /**
     * @var \TipoMovimientoMaquinaria
     *
     * @ORM\ManyToOne(targetEntity="TipoMovimientoMaquinaria")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_movimiento_maquinaria_id", referencedColumnName="id")
     * })
     */
    private $tipoMovimientoMaquinaria;

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
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     * @return MovimientoDeEquipo
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
     * Set horaSalida
     *
     * @param string $horaSalida
     * @return MovimientoDeEquipo
     */
    public function setHoraSalida($horaSalida)
    {
        $this->horaSalida = $horaSalida;

        return $this;
    }

    /**
     * Get horaSalida
     *
     * @return string 
     */
    public function getHoraSalida()
    {
        return $this->horaSalida;
    }

    /**
     * Set horaLlegada
     *
     * @param string $horaLlegada
     * @return MovimientoDeEquipo
     */
    public function setHoraLlegada($horaLlegada)
    {
        $this->horaLlegada = $horaLlegada;

        return $this;
    }

    /**
     * Get horaLlegada
     *
     * @return string 
     */
    public function getHoraLlegada()
    {
        return $this->horaLlegada;
    }

    /**
     * Set movimientoDeEquipocol
     *
     * @param string $movimientoDeEquipocol
     * @return MovimientoDeEquipo
     */
    public function setMovimientoDeEquipocol($movimientoDeEquipocol)
    {
        $this->movimientoDeEquipocol = $movimientoDeEquipocol;

        return $this;
    }

    /**
     * Get movimientoDeEquipocol
     *
     * @return string 
     */
    public function getMovimientoDeEquipocol()
    {
        return $this->movimientoDeEquipocol;
    }

    /**
     * Set nombreProyecto
     *
     * @param string $nombreProyecto
     * @return MovimientoDeEquipo
     */
    public function setNombreProyecto($nombreProyecto)
    {
        $this->nombreProyecto = $nombreProyecto;

        return $this;
    }

    /**
     * Get nombreProyecto
     *
     * @return string 
     */
    public function getNombreProyecto()
    {
        return $this->nombreProyecto;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return MovimientoDeEquipo
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
     * Set operador
     *
     * @param string $operador
     * @return MovimientoDeEquipo
     */
    public function setOperador($operador)
    {
        $this->operador = $operador;

        return $this;
    }

    /**
     * Get operador
     *
     * @return string 
     */
    public function getOperador()
    {
        return $this->operador;
    }

    /**
     * Set tipoMovimientoMaquinaria
     *
     * @param \DG\AdminBundle\Entity\TipoMovimientoMaquinaria $tipoMovimientoMaquinaria
     * @return MovimientoDeEquipo
     */
    public function setTipoMovimientoMaquinaria(\DG\AdminBundle\Entity\TipoMovimientoMaquinaria $tipoMovimientoMaquinaria = null)
    {
        $this->tipoMovimientoMaquinaria = $tipoMovimientoMaquinaria;

        return $this;
    }

    /**
     * Get tipoMovimientoMaquinaria
     *
     * @return \DG\AdminBundle\Entity\TipoMovimientoMaquinaria 
     */
    public function getTipoMovimientoMaquinaria()
    {
        return $this->tipoMovimientoMaquinaria;
    }

    /**
     * Set contacto
     *
     * @param \DG\AdminBundle\Entity\Contacto $contacto
     * @return MovimientoDeEquipo
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
     * Set cliente
     *
     * @param \DG\AdminBundle\Entity\Cliente $cliente
     * @return MovimientoDeEquipo
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
