<?php

namespace Web\MaestrasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SistemaEmpresa
 *
 * @ORM\Table(name="sistema_empresa")
 * @ORM\Entity
 */
class SistemaEmpresa
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
     * @ORM\Column(name="nombre", type="string", length=100, nullable=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="nit", type="string", length=50, nullable=true)
     */
    private $nit;

    /**
     * @var string
     *
     * @ORM\Column(name="contacto", type="string", length=50, nullable=true)
     */
    private $contacto;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=50, nullable=true)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=80, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=50, nullable=true)
     */
    private $tel;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaupdate", type="date", nullable=true)
     */
    private $fechaupdate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean", nullable=true)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=45, nullable=true)
     */
    private $codigo;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_ciudad", type="integer", nullable=false)
     */
    private $idCiudad;

    /**
     * @var string
     *
     * @ORM\Column(name="lema", type="string", length=100, nullable=true)
     */
    private $lema;

    /**
     * @var string
     *
     * @ORM\Column(name="mision", type="string", length=300, nullable=true)
     */
    private $mision;

    /**
     * @var string
     *
     * @ORM\Column(name="vision", type="string", length=300, nullable=true)
     */
    private $vision;

    /**
     * @var string
     *
     * @ORM\Column(name="logo_dos", type="string", length=100, nullable=true)
     */
    private $logoDos;

    /**
     * @var string
     *
     * @ORM\Column(name="logo_uno", type="string", length=100, nullable=true)
     */
    private $logoUno;



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
     *
     * @return SistemaEmpresa
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
     * Set nit
     *
     * @param string $nit
     *
     * @return SistemaEmpresa
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
     * Set contacto
     *
     * @param string $contacto
     *
     * @return SistemaEmpresa
     */
    public function setContacto($contacto)
    {
        $this->contacto = $contacto;

        return $this;
    }

    /**
     * Get contacto
     *
     * @return string
     */
    public function getContacto()
    {
        return $this->contacto;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return SistemaEmpresa
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
     * Set email
     *
     * @param string $email
     *
     * @return SistemaEmpresa
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set tel
     *
     * @param string $tel
     *
     * @return SistemaEmpresa
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set fechaupdate
     *
     * @param \DateTime $fechaupdate
     *
     * @return SistemaEmpresa
     */
    public function setFechaupdate($fechaupdate)
    {
        $this->fechaupdate = $fechaupdate;

        return $this;
    }

    /**
     * Get fechaupdate
     *
     * @return \DateTime
     */
    public function getFechaupdate()
    {
        return $this->fechaupdate;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return SistemaEmpresa
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     *
     * @return SistemaEmpresa
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set idCiudad
     *
     * @param integer $idCiudad
     *
     * @return SistemaEmpresa
     */
    public function setIdCiudad($idCiudad)
    {
        $this->idCiudad = $idCiudad;

        return $this;
    }

    /**
     * Get idCiudad
     *
     * @return integer
     */
    public function getIdCiudad()
    {
        return $this->idCiudad;
    }

    /**
     * Set lema
     *
     * @param string $lema
     *
     * @return SistemaEmpresa
     */
    public function setLema($lema)
    {
        $this->lema = $lema;

        return $this;
    }

    /**
     * Get lema
     *
     * @return string
     */
    public function getLema()
    {
        return $this->lema;
    }

    /**
     * Set mision
     *
     * @param string $mision
     *
     * @return SistemaEmpresa
     */
    public function setMision($mision)
    {
        $this->mision = $mision;

        return $this;
    }

    /**
     * Get mision
     *
     * @return string
     */
    public function getMision()
    {
        return $this->mision;
    }

    /**
     * Set vision
     *
     * @param string $vision
     *
     * @return SistemaEmpresa
     */
    public function setVision($vision)
    {
        $this->vision = $vision;

        return $this;
    }

    /**
     * Get vision
     *
     * @return string
     */
    public function getVision()
    {
        return $this->vision;
    }

    /**
     * Set logoDos
     *
     * @param string $logoDos
     *
     * @return SistemaEmpresa
     */
    public function setLogoDos($logoDos)
    {
        $this->logoDos = $logoDos;

        return $this;
    }

    /**
     * Get logoDos
     *
     * @return string
     */
    public function getLogoDos()
    {
        return $this->logoDos;
    }

    /**
     * Set logoUno
     *
     * @param string $logoUno
     *
     * @return SistemaEmpresa
     */
    public function setLogoUno($logoUno)
    {
        $this->logoUno = $logoUno;

        return $this;
    }

    /**
     * Get logoUno
     *
     * @return string
     */
    public function getLogoUno()
    {
        return $this->logoUno;
    }
}
