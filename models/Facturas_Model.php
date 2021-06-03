<?php
include_once "Clases/Factura.php";
include_once "Lineas_albaran_Model.php";
include_once "Lineas_facturas_Model.php";

class Facturas_Model extends Base_Model
{
    public function read($id)
    {
        $sql = "SELECT *  FROM  facturas " .
            "WHERE cod_factura = :cod_factura";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(array(":cod_factura" => $id));
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'factura');
        $factura = $stmt->fetch();

        if ($factura === false) {
            return null;
        }
        return $factura;
    }

    public function readAll(): array
    {
        $sql = "SELECT *  FROM facturas ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(array());
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'factura');
        //OBJETOS DE TIPO facturas
        $facturas = $stmt->fetchAll();

        return $facturas;
    }

    public function create(factura $factura)
    {
        try {
            $sql = "INSERT INTO facturas (cod_factura, fecha, cod_cliente, descuento_factura, concepto)
               VALUES (:cod_factura,:fecha,:cod_cliente, :descuento_factura, :concepto) ";
            $stmt = $this->conexion->prepare($sql);
            $parametros = [
                ":cod_factura" => $factura->getCod_factura(),
                ":fecha" => $factura->getFecha(),
                ":cod_cliente" => $factura->getCod_cliente(),
                ":descuento_factura" =>$factura->getDescuento_factura(),
                ":concepto" => $factura->getConcepto()
            ];
            $stmt->execute($parametros);
            $factura->setcod_factura($this->conexion->lastInsertId());
            return true;
        } catch (PDOException $e) {
            echo "Error " . $e->getMessage() . "<br />";
            return false;
        }
    }
    public function filterBy($campo = "cod_factura", $filtro = "contiene", $texto = "%")
    {
        //DESDE LUEGO HAY SOLUCIONES MÁS ELEGANTES PERO ESTA SE ENTIENDE BIEN
        if ($filtro == "contiene") {
            $parametros = [":texto" => "%" . $texto . "%"];
        }
        if ($filtro == "empieza") {
            $parametros = [":texto" => $texto . "%"];
        }
        if ($filtro == "acaba") {
            $parametros = [":texto" => "%" . $texto];
        }
        if ($filtro == "igual") {
            $parametros = [":texto" => $texto];
        }

        $sql = "SELECT * FROM facturas " .
            "WHERE $campo LIKE :texto";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute($parametros);
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Factura');
        $facturas = $stmt->fetchAll();
        return $facturas;
    }

    public function delete($id)
    {
        try {
            $sql = "DELETE FROM facturas WHERE cod_factura =:cod_factura";
            $stmt = $this->conexion->prepare($sql);
            $parametros = [":cod_factura" => $id];
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
    public function EsBorrable($id)
    {
        $lineas_albaran_model = new Lineas_albaran_Model();
        $arrayPs = $lineas_albaran_model->filterBy("cod_factura", "igual", $id);
        if (count($arrayPs) > 0) {
            return false;
        } else {
            return true;
        }
    }
    //EVIDENTEMENTE DEBERÁS RELLENAR ESTO
    public function update($factura)
    {
        try {
            $sql = "UPDATE facturas 
            SET cod_factura = :cod_factura, fecha = :fecha, cod_cliente = :cod_cliente, descuento_factura = :descuento_factura, concepto = :concepto
               WHERE cod_factura = :cod_factura ";
            $stmt = $this->conexion->prepare($sql);
            $parametros = [
                ":cod_factura" => $factura->getCod_factura(),
                ":fecha" => $factura->getFecha(),
                ":cod_cliente" => $factura->getCod_cliente(),
                ":descuento_factura" =>$factura->getDescuento_factura(),
                ":concepto" => $factura->getConcepto()
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
