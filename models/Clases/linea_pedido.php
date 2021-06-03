<?php

class Linea_pedido
{
    private $num_linea_pedido;
    private $cod_pedido;
    private $precio;
    private $cantidad;
    private $cantidadenAlbaran;
    private $cod_articulo;
    private $cod_usu_gestion;
    private $esBorrable=false;
    private $esEditable=false;

    public function __toString()
    {
        $cadena = "Numero linea Pedido: " . $this->num_linea_pedido . " Codigo Pedido: " . $this->cod_pedido;
        return $cadena;
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
     * Get the value of cantidadenAlbaran
     */
    public function getCantidadenAlbaran()
    {
        return $this->cantidadenAlbaran;
    }

    /**
     * Set the value of cantidadenAlbaran
     *
     * @return  self
     */
    public function setCantidadenAlbaran($cantidadenAlbaran)
    {
        $this->cantidadenAlbaran = $cantidadenAlbaran;

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
