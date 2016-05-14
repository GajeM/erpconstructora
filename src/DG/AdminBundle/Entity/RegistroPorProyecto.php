<?php

namespace DG\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RegistroPorProyecto
 *
 * @ORM\Table(name="registro_por_proyecto", indexes={@ORM\Index(name="fk_registro_pos_proyecto_proyecto1_idx", columns={"proyecto_id"}), @ORM\Index(name="fk_registro_pos_proyecto_ma_maquina1_idx", columns={"ma_maquina_id"}), @ORM\Index(name="fk_registro_pos_proyecto_empleado1_idx", columns={"empleado_id"})})
 * @ORM\Entity
 */
class RegistroPorProyecto
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
     * @ORM\Column(name="hora_llegada", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $horaLlegada;

    /**
     * @var string
     *
     * @ORM\Column(name="hora_salida", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $horaSalida;

    /**
     * @var float
     *
     * @ORM\Column(name="recibi_cantidad_de", type="float", precision=10, scale=0, nullable=true)
     */
    private $recibiCantidadDe;

    /**
     * @var string
     *
     * @ORM\Column(name="horometro_inicial", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $horometroInicial;

    /**
     * @var string
     *
     * @ORM\Column(name="horometro_final", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $horometroFinal;

    /**
     * @var string
     *
     * @ORM\Column(name="horas_efectivas", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $horasEfectivas;

    /**
     * @var string
     *
     * @ORM\Column(name="horas_extras", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $horasExtras;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_registro", type="date", nullable=true)
     */
    private $fechaRegistro;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_reporte", type="string", length=20, nullable=false)
     */
    private $numeroReporte;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", length=255, nullable=true)
     */
    private $observaciones;

    /**
     * @var string
     *
     * @ORM\Column(name="mantenimiento", type="string", length=20, nullable=true)
     */
    private $mantenimiento;

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
     * @var \MaMaquina
     *
     * @ORM\ManyToOne(targetEntity="MaMaquina")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ma_maquina_id", referencedColumnName="id")
     * })
     */
    private $maMaquina;

    /**
     * @var \Empleado
     *
     * @ORM\ManyToOne(targetEntity="Empleado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="empleado_id", referencedColumnName="id")
     * })
     */
    private $empleado;



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
     * Set horaLlegada
     *
     * @param string $horaLlegada
     * @return RegistroPorProyecto
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
     * Set horaSalida
     *
     * @param string $horaSalida
     * @return RegistroPorProyecto
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
     * Set recibiCantidadDe
     *
     * @param float $recibiCantidadDe
     * @return RegistroPorProyecto
     */
    public function setRecibiCantidadDe($recibiCantidadDe)
    {
        $this->recibiCantidadDe = $recibiCantidadDe;

        return $this;
    }

    /**
     * Get recibiCantidadDe
     *
     * @return float 
     */
    public function getRecibiCantidadDe()
    {
        return $this->recibiCantidadDe;
    }

    /**
     * Set horometroInicial
     *
     * @param string $horometroInicial
     * @return RegistroPorProyecto
     */
    public function setHorometroInicial($horometroInicial)
    {
        $this->horometroInicial = $horometroInicial;

        return $this;
    }

    /**
     * Get horometroInicial
     *
     * @return string 
     */
    public function getHorometroInicial()
    {
        return $this->horometroInicial;
    }

    /**
     * Set horometroFinal
     *
     * @param string $horometroFinal
     * @return RegistroPorProyecto
     */
    public function setHorometroFinal($horometroFinal)
    {
        $this->horometroFinal = $horometroFinal;

        return $this;
    }

    /**
     * Get horometroFinal
     *
     * @return string 
     */
    public function getHorometroFinal()
    {
        return $this->horometroFinal;
    }

    /**
     * Set horasEfectivas
     *
     * @param string $horasEfectivas
     * @return RegistroPorProyecto
     */
    public function setHorasEfectivas($horasEfectivas)
    {
        $this->horasEfectivas = $horasEfectivas;

        return $this;
    }

    /**
     * Get horasEfectivas
     *
     * @return string 
     */
    public function getHorasEfectivas()
    {
        return $this->horasEfectivas;
    }

    /**
     * Set horasExtras
     *
     * @param string $horasExtras
     * @return RegistroPorProyecto
     */
    public function setHorasExtras($horasExtras)
    {
        $this->horasExtras = $horasExtras;

        return $this;
    }

    /**
     * Get horasExtras
     *
     * @return string 
     */
    public function getHorasExtras()
    {
        return $this->horasExtras;
    }

    /**
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     * @return RegistroPorProyecto
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
     * Set numeroReporte
     *
     * @param string $numeroReporte
     * @return RegistroPorProyecto
     */
    public function setNumeroReporte($numeroReporte)
    {
        $this->numeroReporte = $numeroReporte;

        return $this;
    }

    /**
     * Get numeroReporte
     *
     * @return string 
     */
    public function getNumeroReporte()
    {
        return $this->numeroReporte;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return RegistroPorProyecto
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
     * Set mantenimiento
     *
     * @param string $mantenimiento
     * @return RegistroPorProyecto
     */
    public function setMantenimiento($mantenimiento)
    {
        $this->mantenimiento = $mantenimiento;

        return $this;
    }

    /**
     * Get mantenimiento
     *
     * @return string 
     */
    public function getMantenimiento()
    {
        return $this->mantenimiento;
    }

    /**
     * Set proyecto
     *
     * @param \DG\AdminBundle\Entity\Proyecto $proyecto
     * @return RegistroPorProyecto
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
     * Set maMaquina
     *
     * @param \DG\AdminBundle\Entity\MaMaquina $maMaquina
     * @return RegistroPorProyecto
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
     * Set empleado
     *
     * @param \DG\AdminBundle\Entity\Empleado $empleado
     * @return RegistroPorProyecto
     */
    public function setEmpleado(\DG\AdminBundle\Entity\Empleado $empleado = null)
    {
        $this->empleado = $empleado;

        return $this;
    }

    /**
     * Get empleado
     *
     * @return \DG\AdminBundle\Entity\Empleado 
     */
    public function getEmpleado()
    {
        return $this->empleado;
    }
}
