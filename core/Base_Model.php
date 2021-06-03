<?php
abstract class Base_Model
{
   protected $conexion;

   public function __construct()
   {
      $this->conexion = DBManager::getInstance()->conectar();
   }
}
