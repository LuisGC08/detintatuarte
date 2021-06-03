<?php
include_once "Clases/Linea_pedido.php";
include_once "Lineas_albaran_Model.php";

class Lineas_pedidos_Model extends Base_Model
{
    public function read($num, $id)
    {
        $sql = "SELECT *  FROM lineas_pedidos " .
            "WHERE cod_pedido = :cod_pedido and num_linea_pedido= :num_linea_pedido";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(array(":cod_pedido" => $id, ":num_linea_pedido" => $num));
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Linea_pedido');
        $linea_pedido = $stmt->fetch();
        $linea_pedido->setEsBorrable($this->EsBorrable($linea_pedido->getCod_pedido(), $linea_pedido->getNum_linea_pedido()));
        $linea_pedido->setEsEditable($this->EsEditable($linea_pedido));
        if ($linea_pedido === false) {
            return null;
        }
        return $linea_pedido;
    }

    public function readAll(): array
    {
        $sql = "SELECT *  FROM lineas_pedidos ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Linea_pedido');
        //OBJETOS DE TIPO pedidos
        $lineas_pedidos = $stmt->fetchAll();
        foreach ($lineas_pedidos as $linea_pedido) {
            $linea_pedido->setEsBorrable($this->EsBorrable($linea_pedido->getCod_pedido(), $linea_pedido->getNum_linea_pedido()));
            $linea_pedido->setEsEditable($this->EsEditable($linea_pedido));
        }
        return $lineas_pedidos;
    }

    public function create(Linea_pedido $linea_pedido)
    {
        try {
                $sql = "INSERT INTO lineas_pedidos (cod_pedido, num_linea_pedido, precio, cantidad, cantidadenAlbaran, cod_articulo, cod_usu_gestion)
               VALUES (:cod_pedido, :num_linea_pedido, :precio, :cantidad, :cantidadenAlbaran, :cod_articulo, :cod_usu_gestion) ";
                $stmt = $this->conexion->prepare($sql);
                $parametros = [
                    ":cod_pedido" => $linea_pedido->getCod_pedido(),
                    ":num_linea_pedido" => $linea_pedido->getNum_linea_pedido(),
                    ":precio" => $linea_pedido->getPrecio(),
                    ":cantidad" => $linea_pedido->getCantidad(),
                    "cantidadenAlbaran" => $linea_pedido->getCantidadenAlbaran(),
                    ":cod_articulo" => $linea_pedido->getCod_articulo(),
                    ":cod_usu_gestion" => $linea_pedido->getCod_usu_gestion()
                ];
                $stmt->execute($parametros);
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

        $sql = "SELECT * FROM lineas_pedidos " .
            "WHERE $campo LIKE :texto";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute($parametros);
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Linea_pedido');
        $lineas_pedidos = $stmt->fetchAll();
        foreach ($lineas_pedidos as $linea_pedido) {
            $linea_pedido->setEsBorrable($this->EsBorrable($linea_pedido->getCod_pedido(), $linea_pedido->getNum_linea_pedido()));
            $linea_pedido->setEsEditable($this->EsEditable($linea_pedido));
        }
        return $lineas_pedidos;
    }

    public function delete($num, $id)
    {
        try {
            $sql = "DELETE FROM lineas_pedidos WHERE cod_pedido =:cod_pedido and num_linea_pedido= :num_linea_pedido";
            $stmt = $this->conexion->prepare($sql);
            $parametros = [":cod_pedido" => $id,
                ":num_linea_pedido"=>$num];
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
        $sql = "SELECT *  FROM lineas_albaran WHERE cod_pedido = :cod_pedido and num_linea_pedido= :num_linea_pedido";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(array(":cod_pedido" => $id, ":num_linea_pedido" => $num));
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        if ($stmt->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }
    //EVIDENTEMENTE DEBERÁS RELLENAR ESTO
    public function update($linea_pedido, $numAntiguo)
    {
        try {
            $sql = "UPDATE lineas_pedidos 
            SET cod_pedido=:cod_pedido, num_linea_pedido=:num_linea_pedido, precio=:precio, cantidad=:cantidad, 
				cantidadenAlbaran=:cantidadenAlbaran, cod_articulo=:cod_articulo, cod_usu_gestion=:cod_usu_gestion
               WHERE cod_pedido = :cod_pedido and num_linea_pedido= :num_ant";
            $stmt = $this->conexion->prepare($sql);
            $parametros = [
                ":cod_pedido" => $linea_pedido->getCod_pedido(),
                ":num_ant" => $numAntiguo,
                ":num_linea_pedido" => $linea_pedido->getNum_linea_pedido(),
                ":precio" => $linea_pedido->getPrecio(),
                ":cantidad" => $linea_pedido->getCantidad(),
                ":cantidadenAlbaran" => $linea_pedido->getCantidadenAlbaran(),
                ":cod_articulo" => $linea_pedido->getCod_articulo(),
                ":cod_usu_gestion" => $linea_pedido->getCod_usu_gestion()
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

    public function EsEditable($lin_ped)
    {
        if($lin_ped->getCantidad() == $lin_ped->getCantidadenAlbaran()){
            return false;
        } else if($lin_ped->getCantidadenAlbaran() == 0){
            return true;
        } else {
            return $lin_ped->getCantidad() - $lin_ped->getCantidadenAlbaran();
        }
    }
}
