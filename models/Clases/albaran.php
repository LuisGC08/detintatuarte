<?php

class Albaran
{
    private $cod_albaran ;
    private $fecha ;
    private $genrado_de_pedido ;
    private $concepto ;
    private $cod_cliente ;
    private $esBorrable;
    private $esEditable;
    public function __toString()
    {
        $cadena= "Codigo: ". $this->cod_albaran. " Fecha: ".$this->fecha;
        return $cadena;
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
     * Get the value of genrado_de_pedido
     */ 
    public function getGenrado_de_pedido()
    {
        return $this->genrado_de_pedido;
    }

    /**
     * Set the value of genrado_de_pedido
     *
     * @return  self
     */ 
    public function setGenrado_de_pedido($genrado_de_pedido)
    {
        $this->genrado_de_pedido = $genrado_de_pedido;

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
}
