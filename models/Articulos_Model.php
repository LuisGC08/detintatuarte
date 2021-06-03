<?php
include_once "Clases/Articulo.php";

class Articulos_Model extends Base_Model
{
    public function read($id): Articulo
    {
        $sql = "SELECT *  FROM articulos " .
            "WHERE cod_articulo = :cod_articulo";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(array(":cod_articulo" => $id));
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Articulo');
        $articulo = $stmt->fetch();

        if ($articulo === false) {
            return null;
        }
        return $articulo;
    }

    public function readAll(): array
    {
        $sql = "SELECT * FROM articulos ";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(array());
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Articulo');
        //OBJETOS DE TIPO PIEZAS
        $articulos = $stmt->fetchAll();

        return $articulos;
    }

    public function create(Articulo $articulo)
    {
        try {
            $this->conexion->beginTransaction();
                $sql = "INSERT INTO articulos ( nombre, descripcion, precio, IVA, imagen)
               VALUES ( :nombre, :descripcion, :precio, :IVA, :imagen) ";
                $stmt = $this->conexion->prepare($sql);
                $parametros = [
                    ":nombre" => $articulo->getNombre(),
                    ":descripcion" => $articulo->getDescripcion(),
                    ":precio" => $articulo->getPrecio(),
                    ":IVA" => $articulo->getIVA(),
                    ":imagen" => $articulo->getImagen()
                ];
                $stmt->execute($parametros);
                $articulo->setCod_articulo($this->conexion->lastInsertId());
                $this->conexion->commit();
                return true;

        } catch (PDOException $e) {
            echo "Error " . $e->getMessage() . "<br />";
            $this->conexion->rollback();
            return false;
        }
    }

    public function filterBy($campo = "cod_articulo", $filtro = "contiene", $texto = "%")
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

        $sql = "SELECT *  FROM articulos " .
            "WHERE $campo LIKE :texto";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute($parametros);
        //OJO CON CLASS EL MODO SE PONE CON EL FETCH MODE
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Articulo');
        $articulos = $stmt->fetchAll();
        return $articulos;
    }

    public function darBajaAlta($id, $respuesta)
    {
        try {
            $sql = "UPDATE articulos 
            SET baja = :baja
               WHERE cod_articulo = :cod_articulo ";
            $stmt = $this->conexion->prepare($sql);
            $parametros = [
                ":cod_articulo" => $id,
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
    //EVIDENTEMENTE DEBERÁS RELLENAR ESTO
    public function update($articulo)
    {
        try {
            $sql = "UPDATE articulos 
            SET cod_articulo = :cod_articulo, nombre = :nombre, descripcion = :descripcion, precio = :precio, IVA = :IVA, baja = :baja, imagen=:imagen
               WHERE cod_articulo = :cod_articulo ";
            $stmt = $this->conexion->prepare($sql);
            $parametros = [
                ":cod_articulo" => $articulo->getCod_articulo(),
                ":nombre" => $articulo->getNombre(),
                ":descripcion" => $articulo->getDescripcion(),
                ":precio" => $articulo->getPrecio(),
                ":IVA" => $articulo->getIVA(),
                ":baja" => $articulo->getBaja(),
                ":imagen" =>$articulo->getImagen()
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
