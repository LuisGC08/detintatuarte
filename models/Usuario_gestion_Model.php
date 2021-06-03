<?php
include_once "Clases/Usuario_gestion.php";

class Usuario_gestion_Model extends Base_Model
{
    public function read($id)
    {
        $sql = "SELECT * FROM usuarios_gestion " .
         "WHERE nick = :nick";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(array(":nick"=>$id));
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Usuario_gestion');
        $usu_gestion = $stmt->fetch();
      
        if ($usu_gestion === false) {
            return null;
        }
        return $usu_gestion;
    }

    public function readAll():array
    {
        $sql = "SELECT * FROM usuarios_gestion ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(array());
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Usuario_gestion');
        //OBJETOS DE TIPO PIEZAS
        $usuarios = $stmt->fetchAll();
        return $usuarios;
    }
  
    
    public function filterBy($campo="cod_usuario_gestion", $filtro="contiene", $texto="%")
    {
        //DESDE LUEGO HAY SOLUCIONES MÁS ELEGANTES PERO ESTA SE ENTIENDE BIEN
        if ($filtro=="contiene") {
            $parametros= [":texto"=> "%".$texto."%" ];
        }
        if ($filtro=="empieza") {
            $parametros= [":texto"=> $texto."%" ];
        }
        if ($filtro=="acaba") {
            $parametros= [":texto"=> "%".$texto ];
        }
        if ($filtro=="igual") {
            $parametros= [":texto"=> $texto ];
        }

        $sql = "SELECT * FROM usuarios_gestion " .
         "WHERE $campo LIKE :texto";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute($parametros);
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Usuario_gestion');
        $piezas = $stmt->fetchAll();
        return $piezas;
    }
}
