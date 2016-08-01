<?php
/**
 * Created by PhpStorm.
 * User: marti
 * Date: 6/7/2016
 * Time: 7:48 PM
 */
namespace GimnasioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="gimnastas", indexes={@ORM\Index(name="dni_idx", columns={"dni"}),@ORM\Index(name="email_idx", columns={"email"}) })
 */
class Gimnasta
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $dni;

    /**
     * @ORM\Column(type="string")
     */
    protected $fechaIngreso;

    /**
     * @ORM\Column(type="string")
     */
    protected $fechaPago;

    /**
     * @ORM\Column(type="integer")
     */
    protected $habilitado;

    /**
     * @ORM\Column(type="string")
     */
    protected $foto;

    /**
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * @param mixed $dni
     */
    public function setDni($dni)
    {
        $this->dni = $dni;
    }

    /**
     * @return mixed
     */
    public function getFechaIngreso()
    {
        return $this->fechaIngreso;
    }

    /**
     * @param mixed $fechaIngreso
     */
    public function setFechaIngreso($fechaIngreso)
    {
        $this->fechaIngreso = $fechaIngreso;
    }

    /**
     * @return mixed
     */
    public function getFechaPago()
    {
        return $this->fechaPago;
    }

    /**
     * @param mixed $fechaPago
     */
    public function setFechaPago($fechaPago)
    {
        $this->fechaPago = $fechaPago;
    }

    /**
     * @return mixed
     */
    public function getHabilitado()
    {
        return $this->habilitado;
    }

    /**
     * @param mixed $habilitado
     */
    public function setHabilitado($habilitado)
    {
        $this->habilitado = $habilitado;
    }

    /**
     * @return mixed
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * @param mixed $foto
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }


    
}