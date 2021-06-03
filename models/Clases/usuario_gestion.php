<?php

class Usuario_gestion
{
    private $cod_usuario_gestion;
    private $nombre;
    private $nick;
    private $contrasenya;

    /**
     * Get the value of cod_usuario_gestion
     */
    public function getCod_usuario_gestion()
    {
        return $this->cod_usuario_gestion;
    }

    /**
     * Set the value of cod_usuario_gestion
     *
     * @return  self
     */
    public function setCod_usuario_gestion($cod_usuario_gestion)
    {
        $this->cod_usuario_gestion = $cod_usuario_gestion;

        return $this;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

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
     * Get the value of contrasenya
     */
    public function getcontrasenya()
    {
        return $this->contrasenya;
    }

    /**
     * Set the value of contrasenya
     *
     * @return  self
     */
    public function setcontrasenya($contrasenya)
    {
        $this->contrasenya = $contrasenya;

        return $this;
    }

    public function __toString()
    {
        $cadena= "Nombre: ". $this->nombre. " Nick: ".$this->nick;
        return $cadena;
    }
}
