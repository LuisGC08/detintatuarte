<?php

class Linea_factura {
    private $num_linea_factura;
    private $cod_factura;
    private $precio;
    private $cantidad;
    private $descuento;
    private $IVA;
    private $cod_articulo;
    private $cod_usuario_gestion;
    private $num_linea_albaran;
    private $cod_albaran;

    public function __toString()
    {
        $cadena = "Numero linea Factura: " . $this->num_linea_factura . " Codigo Factura: " . $this->cod_factura;
        return $cadena;
    }

    /**
     * Get the value of num_linea_factura
     */ 
    public function getNum_linea_factura()
    {
        return $this->num_linea_factura;
    }

    /**
     * Set the value of num_linea_factura
     *
     * @return  self
     */ 
    public function setNum_linea_factura($num_linea_factura)
    {
        $this->num_linea_factura = $num_linea_factura;

        return $this;
    }

    /**
     * Get the value of cod_factura
     */ 
    public function getCod_factura()
    {
        return $this->cod_factura;
    }

    /**
     * Set the value of cod_factura
     *
     * @return  self
     */ 
    public function setCod_factura($cod_factura)
    {
        $this->cod_factura = $cod_factura;

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
     * Get the value of cantidad
     */ 
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set the value of cantidad
     *
     * @return  self
     */ 
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get the value of descuento
     */ 
    public function getDescuento()
    {
        return $this->descuento;
    }

    /**
     * Set the value of descuento
     *
     * @return  self
     */ 
    public function setDescuento($descuento)
    {
        $this->descuento = $descuento;

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
     * Get the value of num_linea_albaran
     */ 
    public function getNum_linea_albaran()
    {
        return $this->num_linea_albaran;
    }

    /**
     * Set the value of num_linea_albaran
     *
     * @return  self
     */ 
    public function setNum_linea_albaran($num_linea_albaran)
    {
        $this->num_linea_albaran = $num_linea_albaran;

        return $this;
    }

    /**
     * Get the value of cod_albaran
     */ 
    public function getCod_albaran()
    {
        return $this->cod_albaran;
    }

    /**
     * Set the value of cod_albaran
     *
     * @return  self
     */ 
    public function setCod_albaran($cod_albaran)
    {
        $this->cod_albaran = $cod_albaran;

        return $this;
    }
}