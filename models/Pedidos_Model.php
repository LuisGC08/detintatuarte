<?php
include_once "Clases/Pedido.php";
include_once "Lineas_pedidos_Model.php";
include_once "Lineas_albaran_Model.php";

class Pedidos_Model extends Base_Model
{
    public function read($id)
    {
        $sql = "SELECT *  FROM pedidos " .
            "WHERE cod_pedido = :cod_pedido";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(array(":cod_pedido" => $id));
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pedido');
        $pedido = $stmt->fetch();

        if ($pedido === false) {
            return null;
        }
        return $pedido;
    }

    public function readAll(): array
    {
        $sql = "SELECT *  FROM pedidos ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(array());
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pedido');
        //OBJETOS DE TIPO pedidos
        $pedidos = $stmt->fetchAll();
        foreach ($pedidos as $pedido) {
            $pedido->setesBorrable($this->EsBorrable($pedido->getCod_pedido()));
            $pedido->setesEditable($this->EsEditable($pedido->getCod_pedido()));
        }
        return $pedidos;
    }

    public function create(Pedido $pedido)
    {
        try {
            $sql = "INSERT INTO pedidos (cod_pedido, fecha, cod_cliente)
               VALUES (:cod_pedido,:fecha,:cod_cliente) ";
            $stmt = $this->conexion->prepare($sql);
            $parametros = [
                ":cod_pedido" => $pedido->getCod_pedido(),
                ":fecha" => $pedido->getFecha(),
                ":cod_cliente" => $pedido->getCod_cliente()
            ];
            $stmt->execute($parametros);
            $pedido->setCod_pedido($this->conexion->lastInsertId());
            return true;
        } catch (PDOException $e) {
            echo "Error " . $e->getMessage() . "<br />";
            return false;
        }
    }
    public function filterBy($campo = "cod_pedido", $filtro = "contiene", $texto = "%")
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

        $sql = "SELECT * FROM pedidos " .
            "WHERE $campo LIKE :texto";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute($parametros);
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pedido');
        $pedidos = $stmt->fetchAll();
        foreach ($pedidos as $pedido) {
            $pedido->setesBorrable($this->EsBorrable($pedido->getCod_pedido()));
            $pedido->setesEditable($this->EsEditable($pedido->getCod_pedido()));
        }
        return $pedidos;
    }

    public function delete($id)
    {
        try {
            $sql = "DELETE FROM pedidos WHERE cod_pedido =:cod_pedido";
            $stmt = $this->conexion->prepare($sql);
            $parametros = [":cod_pedido" => $id];
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
        $arrayPs = $lineas_albaran_model->filterBy("cod_pedido", "igual", $id);
        if (count($arrayPs) > 0) {
            return false;
        } else {
            return true;
        }
    }
    //EVIDENTEMENTE DEBERÁS RELLENAR ESTO
    public function update($pedido)
    {
        try {
            $sql = "UPDATE pedidos 
            SET cod_pedido = :cod_pedido, fecha = :fecha, cod_cliente = :cod_cliente
               WHERE cod_pedido = :cod_pedido ";
            $stmt = $this->conexion->prepare($sql);
            $parametros = [
                ":cod_pedido" => $pedido->getCod_pedido(),
                ":fecha" => $pedido->getFecha(),
                ":cod_cliente" => $pedido->getCod_cliente()
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
        $lineas_pedido_model = new Lineas_pedidos_Model();
        $lineas_pedido = $lineas_pedido_model->filterBy("cod_pedido", "contiene", $id);
        foreach ($lineas_pedido as $key => $lin_ped) {
            if ($lin_ped->getEsEditable()) {
                return true;
            }
        }
        return false;
    }
}
