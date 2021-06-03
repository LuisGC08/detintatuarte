<?php

class Articulo
{
    private $cod_articulo ;
    private $nombre ;
    private $descripcion ;
    private $precio ;
    private $IVA ;
    private $baja;
    private $imagen;

    public function __toString()
    {
        $cadena= "Nombre: ". $this->nombre. " Descripción: ".$this->descripcion;
        return $cadena;
    }

    /**
     * Get the value of cod_articulo
     */ 
    public function getCod_articulo()
    {
        return $this->cod_articulo;
    }

    /**
     * Set the value of cod_articulo
     *
     * @return  self
     */ 
    public function setCod_articulo($cod_articulo)
    {
        $this->cod_articulo = $cod_articulo;

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
     * Get the value of descripcion
     */ 
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     *
     * @return  self
     */ 
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get the value of precio
     */ 
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set the value of precio
     *
     * @return  self
     */ 
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get the value of IVA
     */ 
    public function getIVA()
    {
        return $this->IVA;
    }

    /**
     * Set the value of IVA
     *
     * @return  self
     */ 
    public function setIVA($IVA)
    {
        $this->IVA = $IVA;

        return $this;
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

    /**
     * Get the value of imagen
     */ 
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Set the value of imagen
     *
     * @return  self
     */ 
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }
}
