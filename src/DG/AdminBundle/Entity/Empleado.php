<?php

namespace DG\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Empleado
 *
 * @ORM\Table(name="empleado", indexes={@ORM\Index(name="fk_empleado_estructura_salarial1_idx", columns={"estructura_salarial_id"}), @ORM\Index(name="fk_empleado_puesto1_idx", columns={"puesto_id"})})
 * @ORM\Entity
 */
class Empleado
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
     * @ORM\Column(name="nombres", type="string", length=45, nullable=true)
     */
    private $nombres;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=45, nullable=true)
     */
    private $apellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="edad", type="string", length=45, nullable=true)
     */
    private $edad;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=60, nullable=true)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=20, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="nit", type="string", length=25, nullable=true)
     */
    private $nit;

    /**
     * @var \EstructuraSalarial
     *
     * @ORM\ManyToOne(targetEntity="EstructuraSalarial")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="estructura_salarial_id", referencedColumnName="id")
     * })
     */
    private $estructuraSalarial;

    /**
     * @var \Puesto
     *
     * @ORM\ManyToOne(targetEntity="Puesto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="puesto_id", referencedColumnName="id")
     * })
     */
    private $puesto;



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
     * Set nombres
     *
     * @param string $nombres
     * @return Empleado
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;

        return $this;
    }

    /**
     * Get nombres
     *
     * @return string 
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     * @return Empleado
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string 
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set edad
     *
     * @param string $edad
     * @return Empleado
     */
    public function setEdad($edad)
    {
        $this->edad = $edad;

        return $this;
    }

    /**
     * Get edad
     *
     * @return string 
     */
    public function getEdad()
    {
        return $this->edad;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return Empleado
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
     * Set telefono
     *
     * @param string $telefono
     * @return Empleado
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set nit
     *
     * @param string $nit
     * @return Empleado
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
     * Set estructuraSalarial
     *
     * @param \DG\AdminBundle\Entity\EstructuraSalarial $estructuraSalarial
     * @return Empleado
     */
    public function setEstructuraSalarial(\DG\AdminBundle\Entity\EstructuraSalarial $estructuraSalarial = null)
    {
        $this->estructuraSalarial = $estructuraSalarial;

        return $this;
    }

    /**
     * Get estructuraSalarial
     *
     * @return \DG\AdminBundle\Entity\EstructuraSalarial 
     */
    public function getEstructuraSalarial()
    {
        return $this->estructuraSalarial;
    }

    /**
     * Set puesto
     *
     * @param \DG\AdminBundle\Entity\Puesto $puesto
     * @return Empleado
     */
    public function setPuesto(\DG\AdminBundle\Entity\Puesto $puesto = null)
    {
        $this->puesto = $puesto;

        return $this;
    }

    /**
     * Get puesto
     *
     * @return \DG\AdminBundle\Entity\Puesto 
     */
    public function getPuesto()
    {
        return $this->puesto;
    }
}
