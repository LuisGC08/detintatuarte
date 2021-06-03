<?php
include_once "Clases/Linea_factura.php";

class Lineas_facturas_Model extends Base_Model
{
    public function read($num, $id)
    {
        $sql = "SELECT *  FROM lineas_facturas " .
            "WHERE cod_factura = :cod_factura and num_linea_factura= :num_linea_factura";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(array(":cod_factura" => $id, ":num_linea_factura" => $num));
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Linea_factura');
        $linea_factura = $stmt->fetch();
        if ($linea_factura === false) {
            return null;
        }
        return $linea_factura;
    }

    public function readAll(): array
    {
        $sql = "SELECT *  FROM lineas_facturas ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Linea_factura');
        //OBJETOS DE TIPO pedidos
        $lineas_facturas = $stmt->fetchAll();
        return $lineas_facturas;
    }

    public function create(Linea_factura $linea_factura)
    {
        try {
                $sql = "INSERT INTO lineas_facturas (cod_factura, num_linea_factura, precio, cantidad, descuento, IVA, cod_articulo, cod_usuario_gestion, num_linea_albaran, cod_albaran)
               VALUES (:cod_factura, :num_linea_factura, :precio, :cantidad, :descuento,:IVA, :cod_articulo, :cod_usuario_gestion, :num_linea_albaran, :cod_albaran) ";
                $stmt = $this->conexion->prepare($sql);
                $parametros = [
                    ":cod_factura" => $linea_factura->getcod_factura(),
                    ":num_linea_factura" => $linea_factura->getnum_linea_factura(),
                    ":precio" => $linea_factura->getPrecio(),
                    ":cantidad" => $linea_factura->getCantidad(),
                    ":descuento" => $linea_factura->getDescuento(),
                    ":cod_articulo" => $linea_factura->getCod_articulo(),
                    ":cod_usuario_gestion" => $linea_factura->getcod_usuario_gestion(),
                    ":num_linea_albaran" => $linea_factura->getNum_linea_albaran(),
                    ":cod_albaran" => $linea_factura->getCod_albaran(),
                    ":IVA" => $linea_factura->getIVA()
                ];
                $stmt->execute($parametros);
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

        $sql = "SELECT * FROM lineas_facturas " .
            "WHERE $campo LIKE :texto";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute($parametros);
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Linea_factura');
        $lineas_facturas = $stmt->fetchAll();

        return $lineas_facturas;
    }

    public function delete($num, $id)
    {
        try {
            $sql = "DELETE FROM lineas_facturas WHERE cod_factura =:cod_factura and num_linea_factura= :num_linea_factura";
            $stmt = $this->conexion->prepare($sql);
            $parametros = [":cod_factura" => $id,
                ":num_linea_factura"=>$num];
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
    //EVIDENTEMENTE DEBERÁS RELLENAR ESTO
    public function update($linea_factura, $numAntiguo)
    {
        try {
            $sql = "UPDATE lineas_facturas 
            SET cod_factura=:cod_factura, num_linea_factura=:num_linea_factura, precio=:precio, cantidad=:cantidad, descuento=:descuento, cod_articulo=:cod_articulo, cod_usuario_gestion=:cod_usuario_gestion, num_linea_albaran = :num_linea_albaran, cod_albaran = :cod_albaran
               WHERE cod_factura = :cod_factura and num_linea_factura= :num_ant";
            $stmt = $this->conexion->prepare($sql);
            $parametros = [
                ":cod_factura" => $linea_factura->getcod_factura(),
                ":num_ant" => $numAntiguo,
                ":num_linea_factura" => $linea_factura->getnum_linea_factura(),
                ":precio" => $linea_factura->getPrecio(),
                ":cantidad" => $linea_factura->getCantidad(),
                "descuento" => $linea_factura->getDescuento(),
                ":cod_articulo" => $linea_factura->getCod_articulo(),
                ":cod_usuario_gestion" => $linea_factura->getcod_usuario_gestion(),
                ":num_linea_albaran" => $linea_factura->getNum_linea_albaran(),
                ":cod_albaran" => $linea_factura->getCod_albaran()
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
