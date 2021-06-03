<?php

class Pieza {
   private $NUMPIEZA;
   private $NOMPIEZA;
   private $PRECIOVENT;
   private $esBorrable=false;
   private $esEditable=false;

//AL DEVOLVER POR CLASS NO LLEVA CONSTRUCTOR, PERO SERÍA ASÍ
 /*  public function __construct($numP, $nomP="",$precio="") {
      $this->NUMPIEZA = $numP;
      $this->NOMPIEZA= $nomP;
      $this->PRECIOVENT= $precio;
   }*/

   public function setesBorrable($bool){
      $this->esBorrable = $bool;
   }
   public function getesBorrable(){
      return $this->esBorrable;
   }
   public function setesEditable($bool){
      $this->esEditable = $bool;
   }
   public function getesEditable(){
      return $this->esEditable;
   }
   public function setNUMPIEZA($numP){
   	  $this->NUMPIEZA = $numP;
   }
   public function getNUMPIEZA(){
   	  return $this->NUMPIEZA;
   }
   public function setNOMPIEZA($nomP){
   	  $this->NOMPIEZA = $nomP;
   }
   public function getNOMPIEZA(){
   	  return $this->NOMPIEZA;
   }
   public function setPRECIOVENT($precio){
        $this->PRECIOVENT = $precio;
   }
   public function getPRECIOVENT(){
        return $this->PRECIOVENT;
   }
   public function __toString(){
      $cadena= $this->NUMPIEZA. " - ".$this->NOMPIEZA. " - ". $this->PRECIOVENT;
      return $cadena;
   }
  }
?>