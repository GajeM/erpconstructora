<?php

namespace DG\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CajaChica
 *
 * @ORM\Table(name="detalle_arrendamiento_maquina", indexes={@ORM\Index(name="fk_detalle_arrendamiento_maquina_proveedor1", columns={"id_proveedor"}), @ORM\Index(name="fk_detalle_arrendamiento_maquina_maquina1", columns={"id_maquina"})})
 * @ORM\Entity
 */
class DetalleArrendamientoMaquina
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
     * @ORM\Column(name="fecha_inicio", type="date", nullable=false)
     */
    private $fechaInicio;

     /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_final", type="date", nullable=false)
     */
    private $fechaFinal;
    
    /**
     * @var float
     *
     * @ORM\Column(name="costo", type="float", precision=10, scale=0, nullable=true)
     */
    private $costo;

    /**
     * @var \Proveedor
     *
     * @ORM\ManyToOne(targetEntity="Proveedor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_proveedor", referencedColumnName="id")
     * })
     */
    private $proveedor;

        /**
     * @var \MaMaquina
     *
     * @ORM\ManyToOne(targetEntity="MaMaquina")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_maquina", referencedColumnName="id")
     * })
     */
    
    private $maquina;
    
    
     /**
     * @var integer
     * @ORM\Column(name="tiempo", type="integer", nullable=false) 
     */
    private $tiempo;

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
     * @param \DateTime $fechaInicio
     * @return CajaChica
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }
    
    
    
     /**
     * Set fechaFinal
     *
     * @param \DateTime $fechaFinal
     * @return CajaChica
     */
    public function setFechaFinal($fechaFinal)
    {
        $this->fechaFinal = $fechaFinal;

        return $this;
    }

    /**
     * Get fechaFinal
     *
     * @return \DateTime 
     */
    public function getFechaFinal()
    {
        return $this->fechaFinal;
    }
    
   
    /**
     * Set estadoRegistro
     *
     * @param \DG\AdminBundle\Entity\Proveedor $proveedor
     * @return Proveedor
     */
    public function setProveedor(\DG\AdminBundle\Entity\Proveedor $proveedor = null)
    {
        $this->proveedor = $proveedor;

        return $this;
    }

    /**
     * Get estadoRegistro
     *
     * @return \DG\AdminBundle\Entity\Proveedor 
     */
    public function getProveedor()
    {
        return $this->proveedor;
    }

    
     /**
     * Set empleadoId
     *
     * @param \DG\AdminBundle\Entity\Empleado $empleadoId
     * @return CajaChica
     */
    public function setMaquina(\DG\AdminBundle\Entity\MaMaquina $maquina = null)
    {
        $this->maquina = $maquina;

        return $this;
    }

    /**
     * Get empleadoId
     *
     * @return \DG\AdminBundle\Entity\Maquina 
     */
    public function getMaquina()
    {
        return $this->maquina;
        
    }

     /**
     * Set cantidadPor
     *
     * @param float $cantidadPor
     * @return CajaChica
     */
    public function setCosto($costo)
    {
        $this->costo = $costo;

        return $this;
    }

    /**
     * Get cantidadPor
     *
     * @return float 
     */
    public function getCosto()
    {
        return $this->costo;
    }
    
     /**
     * Set estado
     *
     * @param string $estado
     * @return Cliente
     */
    public function setTiempo($tiempo)
    {
        $this->tiempo = $tiempo;

        return $this;
    }

    /**
     * Get estado
     *
     * @return integer 
     */
    public function getTiempo()
    {
        return $this->tiempo;
    }

    
}
