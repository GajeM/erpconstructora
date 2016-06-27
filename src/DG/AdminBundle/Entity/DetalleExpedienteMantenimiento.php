<?php

namespace DG\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MaExpedienteMantenimiento
 *
 * @ORM\Table(name="detalle_ma_expediente_mantenimiento", indexes={@ORM\Index(name="fk_detalle_ma_expediente_proveedor", columns={"proveedor"}), @ORM\Index(name="fk_detalle_ma_expediente_ma_expdiente_mantenimiento1", columns={"id_expediente_mantenimiento"})})
 * @ORM\Entity
 */
class DetalleExpedienteMantenimiento
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
     * @ORM\Column(name="nombre", type="string", length=45, nullable=true)
     */
    private $nombre;

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
     *   @ORM\JoinColumn(name="proveedor", referencedColumnName="id")
     * })
     */
    
    private $proveedor;

     /**
     * @var integer
     * @ORM\Column(name="estado", type="integer", nullable=false) 
     */
    private $estado;
    
    
     /**
     * @var \MaExpedienteMantenimiento
     *
     * @ORM\ManyToOne(targetEntity="MaExpedienteMantenimiento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_expediente_mantenimiento", referencedColumnName="id")
     * })
     */
    
    private $idExpedienteMantenimiento;
    

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
     * Set serie
     *
     * @param string $nombre
     * @return MaExpedienteMantenimiento
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
     * Set costo
     *
     * @param float $costo
     * @return MaExpedienteMantenimiento
     */
    public function setCosto($costo)
    {
        $this->costo = $costo;

        return $this;
    }

    /**
     * Get costo
     *
     * @return float 
     */
    public function getCosto()
    {
        return $this->costo;
    }


    /**
     * Set proveedor
     *
     * @param \DG\AdminBundle\Entity\Proveedor $proveedor
     * @return MaExpedienteMantenimiento
     */
    public function setProveedor(\DG\AdminBundle\Entity\Proveedor $proveedor = null)
    {
        $this->proveedor = $proveedor;

        return $this;
    }

    /**
     * Get proveedor
     *
     * @return \DG\AdminBundle\Entity\Proveedor 
     */
    public function getProveedor()
    {
        return $this->proveedor;
    }
    
    
        /**
     * Set estado
     *
     * @param string $estado
     * @return Cliente
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
     * Set idExpedienteMantenimiento
     *
     * @param \DG\AdminBundle\Entity\MaExpedienteMantenimiento $idExpedienteMantenimiento
     * @return MaExpedienteMantenimiento
     */
    public function setIdExpedienteMantenimiento(\DG\AdminBundle\Entity\MaExpedienteMantenimiento $idExpedienteMantenimiento = null)
    {
        $this->idExpedienteMantenimiento = $idExpedienteMantenimiento;

        return $this;
    }

    /**
     * Get proveedor
     *
     * @return \DG\AdminBundle\Entity\MaExpedienteMantenimiento 
     */
    public function getIdExpedienteMantenimiento()
    {
        return $this->idExpedienteMantenimiento;
    }
    
    
    
    
    
    
}
