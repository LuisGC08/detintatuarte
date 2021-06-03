<?php
include_once "Clases/Albaran.php";
include_once "Lineas_facturas_Model.php";

class Albaranes_Model extends Base_Model
{
    public function read($id): Albaran
    {
        $sql = "SELECT *  FROM albaranes " .
            "WHERE cod_albaran = :cod_albaran";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(array(":cod_albaran" => $id));
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'albaran');
        $albaran = $stmt->fetch();

        if ($albaran === false) {
            return null;
        }
        return $albaran;
    }

    public function readAll(): array
    {
        $sql = "SELECT *  FROM albaranes ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(array());
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Albaran');
        //OBJETOS DE TIPO albaranes
        $albaranes = $stmt->fetchAll();
        foreach ($albaranes as $albaran) {
            $albaran->setesBorrable($this->EsBorrable($albaran->getCod_albaran()));
            $albaran->setesEditable($this->EsEditable($albaran->getCod_albaran()));
        }
        return $albaranes;
    }

    public function create(Albaran $albaran)
    {
        try {
            $sql = "INSERT INTO albaranes (cod_albaran, fecha, generado_de_pedido, concepto, cod_cliente)
               VALUES (:cod_albaran,:fecha,:generado_de_pedido, :concepto, :cod_cliente) ";
            $stmt = $this->conexion->prepare($sql);
            $parametros = [
                ":cod_albaran" => $albaran->getCod_albaran(),
                ":fecha" => $albaran->getFecha(),
                ":generado_de_pedido" => $albaran->getGenrado_de_pedido(),
                ":concepto" => $albaran->getConcepto(),
                ":cod_cliente" => $albaran->getCod_cliente()
            ];
            $stmt->execute($parametros);
            $albaran->setcod_albaran($this->conexion->lastInsertId());
            return true;
        } catch (PDOException $e) {
            echo "Error " . $e->getMessage() . "<br />";
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

        $sql = "SELECT * FROM albaranes " .
            "WHERE $campo LIKE :texto";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute($parametros);
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Albaran');
        $albaranes = $stmt->fetchAll();
        foreach ($albaranes as $albaran) {
            $albaran->setesBorrable($this->EsBorrable($albaran->getCod_albaran()));
            $albaran->setesEditable($this->EsEditable($albaran->getCod_albaran()));
        }
        return $albaranes;
    }

    public function delete($id)
    {
        try {
            $sql = "DELETE FROM albaranes WHERE cod_albaran =:cod_albaran";
            $stmt = $this->conexion->prepare($sql);
            $parametros = [":cod_albaran" => $id];
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
        $lineas_facturas_model = new Lineas_facturas_Model();
        $arrayPs = $lineas_facturas_model->filterBy("cod_albaran", "igual", $id);
        if (count($arrayPs) > 0) {
            return false;
        } else {
            return true;
        }
    }
    //EVIDENTEMENTE DEBERÁS RELLENAR ESTO
    public function update($albaran)
    {
        try {
            $sql = "UPDATE albaranes 
            SET cod_albaran = :cod_albaran, fecha = :fecha, generado_de_pedido = :generado_de_pedido, concepto = :concepto, cod_cliente = :cod_cliente
               WHERE cod_albaran = :cod_albaran ";
            $stmt = $this->conexion->prepare($sql);
            $parametros = [
                ":cod_albaran" => $albaran->getCod_albaran(),
                ":fecha" => $albaran->getFecha(),
                ":generado_de_pedido" => $albaran->getGenrado_de_pedido(),
                ":concepto" => $albaran->getConcepto(),
                ":cod_cliente" => $albaran->getCod_cliente()
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

    public function EsEditable($id)
    {
        $lineas_facturas_model = new Lineas_facturas_Model();
        $arrayPs = $lineas_facturas_model->filterBy("cod_albaran", "igual", $id);
        if (count($arrayPs) > 0) {
            return false;
        } else {
            return true;
        }
    }
}
