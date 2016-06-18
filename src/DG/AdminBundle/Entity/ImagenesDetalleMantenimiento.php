<?php

namespace DG\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImagenesDetalleMantenimiento
 *
 * @ORM\Table(name="imagenes_detalle_mantenimiento", indexes={@ORM\Index(name="fk_imagenes_detalle_mantenimiento_ma_expediente_mantenimien_idx", columns={"ma_expediente_mantenimiento_id"}), @ORM\Index(name="fk_imagenes_detalle_mantenimiento_ma_maquina", columns={"id_maquina"})})
 * @ORM\Entity
 */
class ImagenesDetalleMantenimiento
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
     * @ORM\Column(name="src", type="string", length=100, nullable=true)
     */
    private $src;

    /**
     * @var integer
     *
     * @ORM\Column(name="tipo", type="integer", nullable=true)
     */
    private $tipo;

    /**
     * @var \MaExpedienteMantenimiento
     *
     * @ORM\ManyToOne(targetEntity="MaExpedienteMantenimiento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ma_expediente_mantenimiento_id", referencedColumnName="id")
     * })
     */
    private $maExpedienteMantenimiento;


     /**
     * @var \MaMaquina
     *
     * @ORM\ManyToOne(targetEntity="MaMaquina")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_maquina", referencedColumnName="id")
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
     * Set src
     *
     * @param string $src
     * @return ImagenesDetalleMantenimiento
     */
    public function setSrc($src)
    {
        $this->src = $src;

        return $this;
    }

    /**
     * Get src
     *
     * @return string 
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * Set tipo
     *
     * @param integer $tipo
     * @return ImagenesDetalleMantenimiento
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return integer 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set maExpedienteMantenimiento
     *
     * @param \DG\AdminBundle\Entity\MaExpedienteMantenimiento $maExpedienteMantenimiento
     * @return ImagenesDetalleMantenimiento
     */
    public function setMaExpedienteMantenimiento(\DG\AdminBundle\Entity\MaExpedienteMantenimiento $maExpedienteMantenimiento = null)
    {
        $this->maExpedienteMantenimiento = $maExpedienteMantenimiento;

        return $this;
    }

    /**
     * Get maExpedienteMantenimiento
     *
     * @return \DG\AdminBundle\Entity\MaExpedienteMantenimiento 
     */
    public function getMaExpedienteMantenimiento()
    {
        return $this->maExpedienteMantenimiento;
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
    
    
    
    
    
}
