<?php
include_once "Clases/Linea_albaran.php";
include_once "lineas_facturas_Model.php";

class Lineas_albaran_Model extends Base_Model
{
    public function read($num, $id)
    {
        $sql = "SELECT *  FROM lineas_albaran " .
            "WHERE cod_albaran = :cod_albaran and num_linea_albaran= :num_linea_albaran";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(array(":cod_albaran" => $id, ":num_linea_albaran" => $num));
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Linea_albaran');
        $linea_albaran = $stmt->fetch();
        $linea_albaran->setEsBorrable($this->EsBorrable($linea_albaran->getCod_albaran(), $linea_albaran->getNum_linea_albaran()));
        $linea_albaran->setEsEditable($this->EsEditable($linea_albaran->getCod_albaran(), $linea_albaran->getNum_linea_albaran()));
        if ($linea_albaran === false) {
            return null;
        }
        return $linea_albaran;
    }

    public function readAll(): array
    {
        $sql = "SELECT *  FROM lineas_albaran ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Linea_albaran');
        //OBJETOS DE TIPO pedidos
        $lines_albaranes = $stmt->fetchAll();
        foreach ($lines_albaranes as $linea_albaran) {
            $linea_albaran->setesBorrable($this->EsBorrable($linea_albaran->getCod_albaran(), $linea_albaran->getNum_linea_albaran()));
            $linea_albaran->setesEditable($this->EsEditable($linea_albaran->getCod_albaran(), $linea_albaran->getNum_linea_albaran()));
        }
        return $lines_albaranes;
    }

    public function create(linea_albaran $linea_albaran)
    {
        try {

            $sql = "INSERT INTO lineas_albaran (cod_albaran, num_linea_albaran, precio, cantidad, descuento, IVA, cod_articulo, cod_usu_gestion, num_linea_pedido, cod_pedido)
               VALUES (:cod_albaran, :num_linea_albaran, :precio, :cantidad, :descuento, :IVA,:cod_articulo, :cod_usu_gestion, :num_linea_pedido, :cod_pedido) ";
            $stmt = $this->conexion->prepare($sql);
            $parametros = [
                ":cod_albaran" => $linea_albaran->getCod_albaran(),
                ":num_linea_albaran" => $linea_albaran->getNum_linea_albaran(),
                ":precio" => $linea_albaran->getPrecio(),
                ":cantidad" => $linea_albaran->getCantidad(),
                ":descuento" => $linea_albaran->getDescuento(),
                ":IVA" => $linea_albaran->getIVA(),
                ":cod_articulo" => $linea_albaran->getCod_articulo(),
                ":cod_usu_gestion" => $linea_albaran->getCod_usu_gestion(),
                ":cod_pedido" => $linea_albaran->getCod_pedido(),
                ":num_linea_pedido" => $linea_albaran->getNum_linea_pedido(),
            ];
            $stmt->execute($parametros);
            return true;
        } catch (PDOException $e) {
            error_log("Error " . $e->getMessage() . "<br />");
            return false;
        }
    }


    public function filterBy($campo = "cod_albaran", $filtro = "contiene", $texto = "%")
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

        $sql = "SELECT * FROM lineas_albaran " .
            "WHERE $campo LIKE :texto";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute($parametros);
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Linea_albaran');
        $lineas_albaranes = $stmt->fetchAll();
        foreach ($lineas_albaranes as $linea_albaran) {
            $linea_albaran->setEsBorrable($this->EsBorrable($linea_albaran->getCod_albaran(), $linea_albaran->getNum_linea_albaran()));
            $linea_albaran->setEsEditable($this->EsEditable($linea_albaran->getCod_albaran(), $linea_albaran->getNum_linea_albaran()));
        }
        return $lineas_albaranes;
    }

    public function delete($num, $id)
    {
        try {
            $sql = "DELETE FROM lineas_albaran WHERE cod_albaran =:cod_albaran and num_linea_albaran= :num_linea_albaran";
            $stmt = $this->conexion->prepare($sql);
            $parametros = [
                ":cod_albaran" => $id,
                ":num_linea_albaran" => $num
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
    public function EsBorrable($id, $num)
    {
        $sql = "SELECT *  FROM lineas_facturas WHERE cod_albaran = :cod_albaran and num_linea_albaran= :num_linea_albaran";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(array(":cod_albaran" => $id, ":num_linea_albaran" => $num));
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        if ($stmt->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }
    //EVIDENTEMENTE DEBERÁS RELLENAR ESTO
    public function update($linea_albaran, $numAnt)
    {
        try {
            $sql = "UPDATE lineas_albaran 
            SET cod_albaran=:cod_albaran, num_linea_albaran=:num_linea_albaran, precio=:precio, 
            cantidad=:cantidad, descuento =:descuento, IVA=:IVA, cod_articulo=:cod_articulo, 
            cod_usu_gestion=:cod_usu_gestion, cod_pedido=:cod_pedido, num_linea_pedido=:num_linea_pedido
               WHERE cod_albaran = :cod_albaran and num_linea_albaran= :num_ant";
            $stmt = $this->conexion->prepare($sql);
            $parametros = [
                ":cod_albaran" => $linea_albaran->getCod_albaran(),
                ":num_linea_albaran" => $linea_albaran->getNum_linea_albaran(),
                ":precio" => $linea_albaran->getPrecio(),
                ":cantidad" => $linea_albaran->getCantidad(),
                ":descuento" => $linea_albaran->getDescuento(),
                ":IVA" => $linea_albaran->getIVA(),
                ":cod_articulo" => $linea_albaran->getCod_articulo(),
                ":cod_usu_gestion" => $linea_albaran->getCod_usu_gestion(),
                ":cod_pedido" => $linea_albaran->getCod_pedido(),
                ":num_linea_pedido" => $linea_albaran->getNum_linea_pedido(),
                ":num_ant" => $numAnt
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

    public function EsEditable($id, $num)
    {
        $sql = "SELECT *  FROM lineas_facturas WHERE cod_albaran = :cod_albaran and num_linea_albaran= :num_linea_albaran";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(array(":cod_albaran" => $id, ":num_linea_albaran" => $num));
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        if ($stmt->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }
}
