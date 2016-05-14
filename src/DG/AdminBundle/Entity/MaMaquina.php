<?php

namespace DG\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MaMaquina
 *
 * @ORM\Table(name="ma_maquina", indexes={@ORM\Index(name="fk_ma_maquina_tipo_equipo_idx", columns={"tipo_equipo_id"})})
 * @ORM\Entity
 */
class MaMaquina
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
     * @ORM\Column(name="nombre", type="string", length=250, nullable=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="alias", type="string", length=250, nullable=true)
     */
    private $alias;

    /**
     * @var string
     *
     * @ORM\Column(name="marca", type="string", length=45, nullable=true)
     */
    private $marca;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_serie", type="string", length=45, nullable=true)
     */
    private $numeroSerie;

    /**
     * @var string
     *
     * @ORM\Column(name="modelo", type="string", length=45, nullable=true)
     */
    private $modelo;

    /**
     * @var string
     *
     * @ORM\Column(name="vin", type="string", length=45, nullable=true)
     */
    private $vin;

    /**
     * @var string
     *
     * @ORM\Column(name="decripcion", type="text", length=65535, nullable=true)
     */
    private $decripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=50, nullable=true)
     */
    private $color;

    /**
     * @var string
     *
     * @ORM\Column(name="placa", type="string", length=45, nullable=true)
     */
    private $placa;

    /**
     * @var string
     *
     * @ORM\Column(name="tamaño", type="string", length=25, nullable=true)
     */
    private $tamaño;

    /**
     * @var string
     *
     * @ORM\Column(name="capacidad", type="string", length=20, nullable=true)
     */
    private $capacidad;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="anho", type="date", nullable=true)
     */
    private $anho;

    /**
     * @var integer
     *
     * @ORM\Column(name="disponibilidad", type="integer", nullable=true)
     */
    private $disponibilidad;

    /**
     * @var integer
     *
     * @ORM\Column(name="horometro", type="integer", nullable=true)
     */
    private $horometro;

    /**
     * @var \MaTipoEquipo
     *
     * @ORM\ManyToOne(targetEntity="MaTipoEquipo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_equipo_id", referencedColumnName="id")
     * })
     */
    private $tipoEquipo;



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
     * @return MaMaquina
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
     * Set alias
     *
     * @param string $alias
     * @return MaMaquina
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string 
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set marca
     *
     * @param string $marca
     * @return MaMaquina
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get marca
     *
     * @return string 
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set numeroSerie
     *
     * @param string $numeroSerie
     * @return MaMaquina
     */
    public function setNumeroSerie($numeroSerie)
    {
        $this->numeroSerie = $numeroSerie;

        return $this;
    }

    /**
     * Get numeroSerie
     *
     * @return string 
     */
    public function getNumeroSerie()
    {
        return $this->numeroSerie;
    }

    /**
     * Set modelo
     *
     * @param string $modelo
     * @return MaMaquina
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get modelo
     *
     * @return string 
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * Set vin
     *
     * @param string $vin
     * @return MaMaquina
     */
    public function setVin($vin)
    {
        $this->vin = $vin;

        return $this;
    }

    /**
     * Get vin
     *
     * @return string 
     */
    public function getVin()
    {
        return $this->vin;
    }

    /**
     * Set decripcion
     *
     * @param string $decripcion
     * @return MaMaquina
     */
    public function setDecripcion($decripcion)
    {
        $this->decripcion = $decripcion;

        return $this;
    }

    /**
     * Get decripcion
     *
     * @return string 
     */
    public function getDecripcion()
    {
        return $this->decripcion;
    }

    /**
     * Set color
     *
     * @param string $color
     * @return MaMaquina
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set placa
     *
     * @param string $placa
     * @return MaMaquina
     */
    public function setPlaca($placa)
    {
        $this->placa = $placa;

        return $this;
    }

    /**
     * Get placa
     *
     * @return string 
     */
    public function getPlaca()
    {
        return $this->placa;
    }

    /**
     * Set tamaño
     *
     * @param string $tamaño
     * @return MaMaquina
     */
    public function setTamaño($tamaño)
    {
        $this->tamaño = $tamaño;

        return $this;
    }

    /**
     * Get tamaño
     *
     * @return string 
     */
    public function getTamaño()
    {
        return $this->tamaño;
    }

    /**
     * Set capacidad
     *
     * @param string $capacidad
     * @return MaMaquina
     */
    public function setCapacidad($capacidad)
    {
        $this->capacidad = $capacidad;

        return $this;
    }

    /**
     * Get capacidad
     *
     * @return string 
     */
    public function getCapacidad()
    {
        return $this->capacidad;
    }

    /**
     * Set anho
     *
     * @param \DateTime $anho
     * @return MaMaquina
     */
    public function setAnho($anho)
    {
        $this->anho = $anho;

        return $this;
    }

    /**
     * Get anho
     *
     * @return \DateTime 
     */
    public function getAnho()
    {
        return $this->anho;
    }

    /**
     * Set disponibilidad
     *
     * @param integer $disponibilidad
     * @return MaMaquina
     */
    public function setDisponibilidad($disponibilidad)
    {
        $this->disponibilidad = $disponibilidad;

        return $this;
    }

    /**
     * Get disponibilidad
     *
     * @return integer 
     */
    public function getDisponibilidad()
    {
        return $this->disponibilidad;
    }

    /**
     * Set horometro
     *
     * @param integer $horometro
     * @return MaMaquina
     */
    public function setHorometro($horometro)
    {
        $this->horometro = $horometro;

        return $this;
    }

    /**
     * Get horometro
     *
     * @return integer 
     */
    public function getHorometro()
    {
        return $this->horometro;
    }

    /**
     * Set tipoEquipo
     *
     * @param \DG\AdminBundle\Entity\MaTipoEquipo $tipoEquipo
     * @return MaMaquina
     */
    public function setTipoEquipo(\DG\AdminBundle\Entity\MaTipoEquipo $tipoEquipo = null)
    {
        $this->tipoEquipo = $tipoEquipo;

        return $this;
    }

    /**
     * Get tipoEquipo
     *
     * @return \DG\AdminBundle\Entity\MaTipoEquipo 
     */
    public function getTipoEquipo()
    {
        return $this->tipoEquipo;
    }
}
