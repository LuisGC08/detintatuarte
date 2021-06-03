<?php
include_once "Clases/Pieza.php";
include_once "Preciosum_Model.php";

class Piezas_Model extends Base_Model
{
    public function read($id):Pieza
    {
        $sql = "SELECT NUMPIEZA, NOMPIEZA, PRECIOVENT  FROM PIEZA " .
         "WHERE NUMPIEZA = :numpieza";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(array(":numpieza"=>$id));
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pieza');
        $pieza = $stmt->fetch();
      
        if ($pieza === false) {
            return null;
        }
        return $pieza;
    }

    public function readAll():array
    {
        $sql = "SELECT NUMPIEZA, NOMPIEZA, PRECIOVENT  FROM PIEZA ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(array());
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pieza');
        //OBJETOS DE TIPO PIEZAS
        $piezas = $stmt->fetchAll();
        foreach ($piezas as $pieza) {
            $pieza->setesBorrable($this->EsBorrable($pieza->getNUMPIEZA()));
            $pieza->setesEditable($this->EsEditable($pieza->getNUMPIEZA()));
        }
        return $piezas;
    }
  
    public function create(Pieza $pieza)
    {
        try {
            if ($this->EsUnico($pieza->getNUMPIEZA())) {
                $sql = "INSERT INTO PIEZA (numpieza, nompieza, preciovent)
               VALUES (:numpieza,:nompieza,:preciovent) ";
                $stmt = $this->conexion->prepare($sql);
                $parametros=[":numpieza"=>$pieza->getNUMPIEZA(),
                     ":nompieza"=>$pieza->getNOMPIEZA(),
                     ":preciovent"=>$pieza->getPRECIOVENT()];
                $stmt->execute($parametros);
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error ".$e->getMessage()."<br />";
            return false;
        }
    }
    public function EsUnico($id)
    {
        $sql = "SELECT NUMPIEZA, NOMPIEZA, PRECIOVENT  FROM PIEZA WHERE NUMPIEZA = :numpieza";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(array(":numpieza"=>$id));
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        if ($stmt->rowCount()<=0) {
            return true;
        } else {
            return false;
        }
    }

    public function filterBy($campo="NUMPIEZA", $filtro="contiene", $texto="%")
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

        $sql = "SELECT NUMPIEZA, NOMPIEZA, PRECIOVENT  FROM PIEZA " .
         "WHERE $campo LIKE :texto";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute($parametros);
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pieza');
        $piezas = $stmt->fetchAll();
        return $piezas;
    }

    public function delete($id)
    {
        try {
            $sql = "DELETE FROM PIEZA WHERE numpieza=:numpieza";
            $stmt = $this->conexion->prepare($sql);
            $parametros=[":numpieza"=>$id];
            $stmt->execute($parametros);
            if ($stmt->rowCount()>0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error ".$e->getMessage()."<br />";
            return false;
        }
    }
    public function EsBorrable($id)
    {
        $ps_Model = new Preciosum_Model();
        $arrayPs= $ps_Model->filterBy("NUMPIEZA", "igual", $id);
        if (count($arrayPs)>0) {
            return false;
        } else {
            return true ;
        }
    }
    //EVIDENTEMENTE DEBERÁS RELLENAR ESTO
    public function update($pieza)
    {
        try {
            $sql = "UPDATE PIEZA 
            SET numpieza = :numpieza, nompieza = :nompieza, preciovent = :preciovent
               WHERE numpieza = :numpieza ";
            $stmt = $this->conexion->prepare($sql);
            $parametros=[":numpieza"=>$pieza->getNUMPIEZA(),
                     ":nompieza"=>$pieza->getNOMPIEZA(),
                     ":preciovent"=>$pieza->getPRECIOVENT()];
            $stmt->execute($parametros);
            if ($stmt->rowCount()>0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error ".$e->getMessage()."<br />";
            return false;
        }
    }
   
    public function EsEditable($id)
    {
        $ps_Model = new Preciosum_Model();
        $arrayPs= $ps_Model->filterBy("NUMPIEZA", "igual", $id);
        if (count($arrayPs)>0) {
            return false;
        } else {
            return true ;
        }
    }
}
