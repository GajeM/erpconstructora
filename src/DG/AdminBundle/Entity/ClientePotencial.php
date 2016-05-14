<?php

namespace DG\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClientePotencial
 *
 * @ORM\Table(name="cliente_potencial", indexes={@ORM\Index(name="fk_cliente_potencial_contacto1_idx", columns={"contacto_id"}), @ORM\Index(name="fk_cliente_potencial_estado_cliente_potencial1_idx", columns={"estado_cliente_potencial_id"})})
 * @ORM\Entity
 */
class ClientePotencial
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
     * @ORM\Column(name="nombre", type="string", length=60, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=25, nullable=false)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="nrc", type="string", length=25, nullable=true)
     */
    private $nrc;

    /**
     * @var string
     *
     * @ORM\Column(name="nit", type="string", length=25, nullable=true)
     */
    private $nit;

    /**
     * @var string
     *
     * @ORM\Column(name="correoelectronico", type="string", length=60, nullable=true)
     */
    private $correoelectronico;

    /**
     * @var string
     *
     * @ORM\Column(name="movil", type="string", length=25, nullable=true)
     */
    private $movil;

    /**
     * @var string
     *
     * @ORM\Column(name="pagina_web", type="string", length=80, nullable=true)
     */
    private $paginaWeb;

    /**
     * @var string
     *
     * @ORM\Column(name="referido_por", type="string", length=60, nullable=true)
     */
    private $referidoPor;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=100, nullable=true)
     */
    private $direccion;

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
     * @var \EstadoClientePotencial
     *
     * @ORM\ManyToOne(targetEntity="EstadoClientePotencial")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="estado_cliente_potencial_id", referencedColumnName="id")
     * })
     */
    private $estadoClientePotencial;
    
      /**
     * @var integer
     * @ORM\Column(name="estado", type="integer", nullable=false) 
     */
    private $estado;


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
     * @return ClientePotencial
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
     * Set telefono
     *
     * @param string $telefono
     * @return ClientePotencial
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
     * Set nrc
     *
     * @param string $nrc
     * @return ClientePotencial
     */
    public function setNrc($nrc)
    {
        $this->nrc = $nrc;

        return $this;
    }

    /**
     * Get nrc
     *
     * @return string 
     */
    public function getNrc()
    {
        return $this->nrc;
    }

    /**
     * Set nit
     *
     * @param string $nit
     * @return ClientePotencial
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
     * Set correoelectronico
     *
     * @param string $correoelectronico
     * @return ClientePotencial
     */
    public function setCorreoelectronico($correoelectronico)
    {
        $this->correoelectronico = $correoelectronico;

        return $this;
    }

    /**
     * Get correoelectronico
     *
     * @return string 
     */
    public function getCorreoelectronico()
    {
        return $this->correoelectronico;
    }

    /**
     * Set movil
     *
     * @param string $movil
     * @return ClientePotencial
     */
    public function setMovil($movil)
    {
        $this->movil = $movil;

        return $this;
    }

    /**
     * Get movil
     *
     * @return string 
     */
    public function getMovil()
    {
        return $this->movil;
    }

    /**
     * Set paginaWeb
     *
     * @param string $paginaWeb
     * @return ClientePotencial
     */
    public function setPaginaWeb($paginaWeb)
    {
        $this->paginaWeb = $paginaWeb;

        return $this;
    }

    /**
     * Get paginaWeb
     *
     * @return string 
     */
    public function getPaginaWeb()
    {
        return $this->paginaWeb;
    }

    /**
     * Set referidoPor
     *
     * @param string $referidoPor
     * @return ClientePotencial
     */
    public function setReferidoPor($referidoPor)
    {
        $this->referidoPor = $referidoPor;

        return $this;
    }

    /**
     * Get referidoPor
     *
     * @return string 
     */
    public function getReferidoPor()
    {
        return $this->referidoPor;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return ClientePotencial
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
     * Set direccion
     *
     * @param string $direccion
     * @return ClientePotencial
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
     * Set contacto
     *
     * @param \DG\AdminBundle\Entity\Contacto $contacto
     * @return ClientePotencial
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
     * Set estadoClientePotencial
     *
     * @param \DG\AdminBundle\Entity\EstadoClientePotencial $estadoClientePotencial
     * @return ClientePotencial
     */
    public function setEstadoClientePotencial(\DG\AdminBundle\Entity\EstadoClientePotencial $estadoClientePotencial = null)
    {
        $this->estadoClientePotencial = $estadoClientePotencial;

        return $this;
    }

    /**
     * Get estadoClientePotencial
     *
     * @return \DG\AdminBundle\Entity\EstadoClientePotencial 
     */
    public function getEstadoClientePotencial()
    {
        return $this->estadoClientePotencial;
    }
    
    
    /**
     * Set estado
     *
     * @param string $estado
     * @return ClientePotencial
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
    
    
   
    public function __toString() {
        
         return $this->nombre;
    }  
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
