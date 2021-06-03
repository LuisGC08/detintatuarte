<?php

class Linea_albaran {
    private $num_linea_albaran;
    private $cod_albaran;
    private $precio;
    private $cantidad;
    private $descuento;
    private $IVA = 21;
    private $cod_articulo;
    private $cod_usu_gestion;
    private $num_linea_pedido;
    private $cod_pedido;    
    private $esBorrable=false;
    private $esEditable=false;

    public function __toString()
    {
        $cadena = "Numero linea Albaran: " . $this->num_linea_albaran . " Codigo Albaran: " . $this->cod_albaran;
        return $cadena;
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
     * Get the value of cod_usu_gestion
     */ 
    public function getCod_usu_gestion()
    {
        return $this->cod_usu_gestion;
    }

    /**
     * Set the value of cod_usu_gestion
     *
     * @return  self
     */ 
    public function setCod_usu_gestion($cod_usu_gestion)
    {
        $this->cod_usu_gestion = $cod_usu_gestion;

        return $this;
    }

    /**
     * Get the value of num_linea_pedido
     */ 
    public function getNum_linea_pedido()
    {
        return $this->num_linea_pedido;
    }

    /**
     * Set the value of num_linea_pedido
     *
     * @return  self
     */ 
    public function setNum_linea_pedido($num_linea_pedido)
    {
        $this->num_linea_pedido = $num_linea_pedido;

        return $this;
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