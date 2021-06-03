<?php
include_once "Clases/Cliente.php";

class Clientes_Model extends Base_Model
{
    public function read($id):Cliente
    {
        $sql = "SELECT *  FROM clientes " .
         "WHERE cod_cliente = :cod_cliente";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(array(":cod_cliente"=>$id));
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
        $cliente = $stmt->fetch();
      
        if ($cliente === false) {
            return null;
        }
        return $cliente;
    }

    public function readAll():array
    {
        $sql = "SELECT * FROM clientes";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(array());
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
        //OBJETOS DE TIPO PIEZAS
        $clientes = $stmt->fetchAll();
        
        return $clientes;
    }

    public function filterBy($campo="cod_cliente", $filtro="contiene", $texto="%")
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

        $sql = "SELECT * FROM clientes " .
         "WHERE $campo LIKE :texto";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute($parametros);
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
        $clientes = $stmt->fetchAll();
        return $clientes;
    }
    public function darBajaAlta($id, $respuesta)
    {
        try {
            $sql = "UPDATE clientes 
            SET baja = :baja
               WHERE cod_cliente = :cod_cliente ";
            $stmt = $this->conexion->prepare($sql);
            $parametros = [
                ":cod_cliente" => $id,
                ":baja" => $respuesta
            ];
            $stmt->execute($parametros);
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error " . $e->getMessage() . "<br />";
            return false;
        }
    }
}
