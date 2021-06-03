<?php
include_once "Usuario_gestion_Model.php";

class Login_Model extends Base_Model
{
    public function signIn($nick, $password){
        $Usuario_Model = new Usuario_gestion_Model();
        $usuario = $Usuario_Model->read($nick);
        if(is_null($usuario)){
            return null;
        }
        if($usuario->getcontrasenya() != $password){
            return null;
        }
        return $usuario;
    }
}