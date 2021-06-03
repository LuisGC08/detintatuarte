<?php

class Factura
{
    private $cod_factura;
    private $cod_cliente;
    private $fecha;
    private $descuento_factura;
    private $concepto;
    public function __toString()
    {
        $cadena= "Codigo Factura: ". $this->cod_factura. " Fecha: ".$this->fecha;
        return $cadena;
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
     * Get the value of fecha
     */ 
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set the value of fecha
     *
     * @return  self
     */ 
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get the value of descuento_factura
     */ 
    public function getDescuento_factura()
    {
        return $this->descuento_factura;
    }

    /**
     * Set the value of descuento_factura
     *
     * @return  self
     */ 
    public function setDescuento_factura($descuento_factura)
    {
        $this->descuento_factura = $descuento_factura;

        return $this;
    }

    /**
     * Get the value of concepto
     */ 
    public function getConcepto()
    {
        return $this->concepto;
    }

    /**
     * Set the value of concepto
     *
     * @return  self
     */ 
    public function setConcepto($concepto)
    {
        $this->concepto = $concepto;

        return $this;
    }
}
