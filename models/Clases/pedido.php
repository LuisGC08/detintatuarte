<?php

class Pedido
{
    private $cod_pedido ;
    private $fecha ;
    private $cod_cliente;
    private $esBorrable=false;
    private $esEditable=false;
    public function __toString()
    {
        $cadena= "Codigo: ". $this->cod_pedido. " Fecha: ".$this->fecha;
        return $cadena;
    }

    /**
     * Get the value of cod_pedido
     */ 
    public function getCod_pedido()
    {
        return $this->cod_pedido;
    }

    /**
     * Set the value of cod_pedido
     *
     * @return  self
     */ 
    public function setCod_pedido($cod_pedido)
    {
        $this->cod_pedido = $cod_pedido;

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
     * Get the value of esBorrable
     */ 
    public function getEsBorrable()
    {
        return $this->esBorrable;
    }

    /**
     * Set the value of esBorrable
     *
     * @return  self
     */ 
    public function setEsBorrable($esBorrable)
    {
        $this->esBorrable = $esBorrable;

        return $this;
    }

    /**
     * Get the value of esEditable
     */ 
    public function getEsEditable()
    {
        return $this->esEditable;
    }

    /**
     * Set the value of esEditable
     *
     * @return  self
     */ 
    public function setEsEditable($esEditable)
    {
        $this->esEditable = $esEditable;

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
}
