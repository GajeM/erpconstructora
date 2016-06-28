<?php

namespace DG\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MaDatosMantenimiento
 *
 * @ORM\Table(name="ma_datos_mantenimiento", indexes={@ORM\Index(name="fk_ma_datos_mantenimiento_ma_maquina1_idx", columns={"ma_maquina_id"})})
 * @ORM\Entity
 */
class MaDatosMantenimiento
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
     * @ORM\Column(name="numero", type="string", length=45, nullable=true)
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", length=65535, nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=150, nullable=true)
     */
    private $nombre;
    
     /**
     * @var string
     * @ORM\Column(name="codigo", type="string", length=20,  nullable=false) 
     */
    private $codigo;
    
    
    
    /**
     * @var string
     * @ORM\Column(name="marca", type="string", length=30,  nullable=false) 
     */
    private $marca;
    
    
       /**
     * @var string
     * @ORM\Column(name="numero_original", type="string", length=30,  nullable=false) 
     */
    private $numeroOriginal;
    
         /**
     * @var string
     * @ORM\Column(name="numero_comercial", type="string", length=30,  nullable=false) 
     */
    private $numeroComercial;
    
    

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set numero
     *
     * @param string $numero
     * @return MaDatosMantenimiento
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string 
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return MaDatosMantenimiento
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
     * Set nombre
     *
     * @param string $nombre
     * @return MaDatosMantenimiento
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
     * Set maMaquina
     *
     * @param \DG\AdminBundle\Entity\MaMaquina $maMaquina
     * @return MaDatosMantenimiento
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
     * Set codigo
     *
     * @param integer $codigo
     * @return Cliente
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get estado
     *
     * @return integer 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }
    
    
     /**
     * Set marca
     *
     * @param integer $marca
     * @return Cliente
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get marca
     *
     * @return integer 
     */
    public function getMarca()
    {
        return $this->marca;
    }
    
    
      /**
     * Set numeroOriginal
     *
     * @param integer $marca
     * @return Cliente
     */
    public function setNumeroOriginal($numeroOriginal)
    {
        $this->numeroOriginal = $numeroOriginal;

        return $this;
    }

    /**
     * Get marca
     *
     * @return integer 
     */
    public function getNumeroOriginal()
    {
        return $this->numeroOriginal;
    }
    
    
    
      /**
     * Set numeroComercial
     *
     * @param integer $marca
     * @return Cliente
     */
    public function setNumeroComercial($numeroComercial)
    {
        $this->numeroComercial = $numeroComercial;

        return $this;
    }

    /**
     * Get marca
     *
     * @return integer 
     */
    public function getNumeroComercial()
    {
        return $this->numeroComercial;
    }
    
    
    
    
    
    
    
    
    
}
