<?php

class Cliente
{
    private $cod_cliente;
    private $CIF_DNI;
    private $razon_social;
    private $domicilio_social;
    private $ciudad;
    private $email;
    private $telefono;
    private $nick;
    private $contraseña;
    private $baja;
    /**
     * Get the value of cod_cliente
     */
    public function getCod_cliente()
    {
        return $this->cod_cliente;
    }

    /**
     * Set the value of cod_cliente
     *
     * @return  self
     */
    public function setCod_cliente($cod_cliente)
    {
        $this->cod_cliente = $cod_cliente;

        return $this;
    }

    /**
     * Get the value of CIF_DNI
     */
    public function getCIF_DNI()
    {
        return $this->CIF_DNI;
    }

    /**
     * Set the value of CIF_DNI
     *
     * @return  self
     */
    public function setCIF_DNI($CIF_DNI)
    {
        $this->CIF_DNI = $CIF_DNI;

        return $this;
    }

    /**
     * Get the value of razon_social
     */
    public function getRazon_social()
    {
        return $this->razon_social;
    }

    /**
     * Set the value of razon_social
     *
     * @return  self
     */
    public function setRazon_social($razon_social)
    {
        $this->razon_social = $razon_social;

        return $this;
    }

    /**
     * Get the value of domicilio_social
     */
    public function getDomicilio_social()
    {
        return $this->domicilio_social;
    }

    /**
     * Set the value of domicilio_social
     *
     * @return  self
     */
    public function setDomicilio_social($domicilio_social)
    {
        $this->domicilio_social = $domicilio_social;

        return $this;
    }

    /**
     * Get the value of ciudad
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * Set the value of ciudad
     *
     * @return  self
     */
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of telefono
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set the value of telefono
     *
     * @return  self
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get the value of nick
     */
    public function getNick()
    {
        return $this->nick;
    }

    /**
     * Set the value of nick
     *
     * @return  self
     */
    public function setNick($nick)
    {
        $this->nick = $nick;

        return $this;
    }

    /**
     * Get the value of contraseña
     */
    public function getContraseña()
    {
        return $this->contraseña;
    }

    /**
     * Set the value of contraseña
     *
     * @return  self
     */
    public function setContraseña($contraseña)
    {
        $this->contraseña = $contraseña;

        return $this;
    }
    public function __toString(){
        $cadena= "Nick: ". $this->nick. " Email: ".$this->email. " Telefono: ". $this->telefono;
        return $cadena;
    }

    /**
     * Get the value of baja
     */ 
    public function getBaja()
    {
        return $this->baja;
    }

    /**
     * Set the value of baja
     *
     * @return  self
     */ 
    public function setBaja($baja)
    {
        $this->baja = $baja;

        return $this;
    }
}
