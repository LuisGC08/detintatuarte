<?php
//Incluye el modelo que corresponde
define("RUTA_VISTAS", "contenido/Articulos/");
require_once 'models/Articulos_Model.php';

class Articulos_Controller extends Base_Controller
{
    public function listar()
    {
        //Creamos una instancia de nuestro "modelo"
        $Articulos_model = new Articulos_Model();
        session_start();
        //Le pedimos al modelo todos los Piezas
        $articulos = $Articulos_model->readAll();

        //Pasamos a la vista toda la información que se desea representar
        $variables = array();
        $usuario["usuario"] = $_SESSION["usuario"];
        $variables['articulos'] = $articulos;
        if (isset($_SESSION['cliente'])) {
            $usuario["cliente"] = $_SESSION['cliente'];
        }
        //Finalmente presentamos nuestra plantilla
        $this->view->show("cabecera.php");
        $this->view->show("plantilla_header.php", $usuario);
        $this->view->show(RUTA_VISTAS . "listar_header.php");
        $this->view->show(RUTA_VISTAS . "listar.php", $variables);
        $this->view->show("plantilla_pie.php");
        $this->view->show("pie.php", $usuario);
    }


    public function filtrar()
    {
        //Creamos una instancia de nuestro "modelo"
        $Articulos_model = new Articulos_Model();
        session_start();

        $campo = (isset($_REQUEST['campo'])) ? $_REQUEST['campo'] : "cod_articulo";
        $filtro = (isset($_REQUEST['filtro'])) ? $_REQUEST['filtro'] : "contiene";
        $texto = (isset($_REQUEST['texto'])) ? $_REQUEST['texto'] : "%";

        //Le pedimos al modelo todos los Piezas
        $articulos = $Articulos_model->filterBy($campo, $filtro, $texto);

        if (isset($_SESSION['cliente'])) {
            $usuario["cliente"] = $_SESSION['cliente'];
        }
        //Pasamos a la vista toda la información que se desea representar
        $varVistaFormFiltrar = ["campo" => $campo, "filtro" => $filtro, "texto" => $texto];
        $varVistaListar['articulos'] = $articulos;
        $usuario["usuario"] = $_SESSION["usuario"];
        //Finalmente presentamos nuestra plantilla
        $this->view->show("cabecera.php");
        $this->view->show("plantilla_header.php", $usuario);
        $this->view->show(RUTA_VISTAS . "listar_header.php");
        $this->view->show(RUTA_VISTAS . "form_filtrar.php", $varVistaFormFiltrar);
        $this->view->show(RUTA_VISTAS . "listar.php", $varVistaListar);
        $this->view->show("plantilla_pie.php");
        $this->view->show("pie.php", $usuario);
    }

    public function ver()
    {
        if (!isset($_GET['id'])) {
            die("No has especificado un identificador de articulo.");
        }

        $id = $_GET['id'];

        //Creamos una instancia de nuestro "modelo"
        $Articulos_model = new Articulos_Model();

        //Le pide al modelo LA articulo con id = $id
        $articulo = $Articulos_model->read($id);

        if ($articulo === null) {
            die("Identificador de articulo incorrecto");
        }

        //Pasamos a la vista toda la información que se desea representar
        $variables = array();
        $variables['articulo'] = $articulo;

        //Pasamos a la vista toda la información que se desea representar
        $this->view->show(RUTA_VISTAS . 'ver.php', $variables);
    }

    public function alta()
    {
        //Creamos una instancia de nuestro "modelo"
        $Articulos_model = new Articulos_Model();
        $articulo = new Articulo();
        session_start();
        $errores = [];
        $success = "";
        //Recojo datos si hay
        if (isset($_POST['nombre'])) {
            $articulo->setNombre($_POST['nombre']);
            $articulo->setDescripcion($_POST['descripcion']);
            $articulo->setPrecio($_POST['precio']);
            $articulo->setIVA($_POST['IVA']);
            $correcto = true;
            if ($_FILES['imagen']['name'] != "") {
                list($base, $extension) = explode(".", $_FILES['imagen']['name']);
                $resultado = $this->comprobarImagen($_FILES["imagen"], $_POST['nombre']);
                if ($resultado['success'] == true) {
                    $articulo->setImagen($articulo->getNombre() . "." . $extension);
                } else {
                    $errores[] = $resultado["mensaje"];
                    $correcto = false;
                }
            }
            if ($correcto) {
                if ($Articulos_model->create($articulo)) {
                    $success = "Agregado correctamente";
                } else {
                    $errores[] = "Ha ocurrido un problema";
                }
            }
        }
        if (isset($_SESSION['cliente'])) {
            $usuario["cliente"] = $_SESSION['cliente'];
        }
        //Pasamos a la vista toda la información que se desea representar
        $variables['articulo'] = $articulo;
        $variables['errores'] = $errores;
        $variables['success'] = $success;
        $usuario["usuario"] = $_SESSION["usuario"];
        //Pasamos a la vista toda la información que se desea representar
        $this->view->show("cabecera.php");
        $this->view->show("plantilla_header.php", $usuario);
        $this->view->show(RUTA_VISTAS . "listar_header.php");
        $this->view->show(RUTA_VISTAS . "alta.php", $variables);
        $this->view->show("plantilla_pie.php");
        $this->view->show("pie.php", $usuario);
    }
    public function eliminar()
    {
        //recoger datos
        // y controlar datos
        $Articulos_model = new Articulos_Model();
        session_start();
        $mensaje = "";
        $error = "";
        if (!isset($_REQUEST["id"])) {
            die("Error, falta el id de la articulo a borrar");
        }
        $id = $_REQUEST["id"];
        //accedo al modelo y opero
        $articulo = $Articulos_model->read($id);
        if ($articulo == null) {
            die("No existe la articulo");
        }
        if ($articulo->getBaja() == true) {
            if ($Articulos_model->darBajaAlta($id, false)) {
                $mensaje = "El articulo " . $articulo->getNombre() . " se ha dado de alta correctamente";
            } else {
                $error = "Ha ocurrido un problema al dar de alta el articulo";
            }
        } else {
            if ($Articulos_model->darBajaAlta($id, true)) {
                $mensaje = "El articulo " . $articulo->getNombre() . " se ha dado de baja correctamente";
            } else {
                $error = "Ha ocurrido un problema al dar de baja el articulo";
            }
        }
        if (isset($_SESSION['cliente'])) {
            $usuario["cliente"] = $_SESSION['cliente'];
        }
        //Paso a la vista el resultado
        $variables["success"] = $mensaje;
        $variables["error"] = $error;
        $variables["articulos"] = $Articulos_model->readAll();
        $usuario["usuario"] = $_SESSION["usuario"];
        $this->view->show("cabecera.php");
        $this->view->show("plantilla_header.php", $usuario);
        $this->view->show(RUTA_VISTAS . "listar_header.php");
        $this->view->show(RUTA_VISTAS . "listar.php", $variables);
        $this->view->show("plantilla_pie.php");
        $this->view->show("pie.php", $usuario);
    }
    public function editar()
    {

        $errores = [];
        $success = "";
        session_start();
        //recoger datos
        // y controlar datos
        $Articulos_model = new Articulos_Model();
        if (isset($_REQUEST["id"])) {
            $id = $_REQUEST["id"];
            $articulo = $Articulos_model->read($id);
        } elseif (isset($_POST['cod_articulo'])) {

            $articulo = $Articulos_model->read($_POST['cod_articulo']);
            $articulo->setNombre($_POST['nombre']);
            $articulo->setDescripcion($_POST['descripcion']);
            $articulo->setPrecio($_POST['precio']);
            $articulo->setIVA($_POST['IVA']);
            $correcto = true;
            if ($_FILES['imagen']['name'] != "") {
                list($base, $extension) = explode(".", $_FILES['imagen']['name']);
                $resultado = $this->comprobarImagen($_FILES["imagen"], $_POST['nombre']);
                if ($resultado['success'] == true) {
                    $articulo->setImagen($articulo->getNombre() . "." . $extension);
                } else {
                    $errores[] = $resultado["mensaje"];
                    $correcto = false;
                }
            }
            if ($correcto) {
                $Articulos_model->update($articulo);
                $success = "El articulo ha sido modificada correctamente";
            }
        } else {
            die("Error, falta el id de la articulo a editar");
        }

        //accedo al modelo y opero
        if ($articulo == null) {
            die("No existe la articulo");
        }
        if (isset($_SESSION['cliente'])) {
            $usuario["cliente"] = $_SESSION['cliente'];
        }
        $variables['articulo'] = $articulo;
        $variables['errores'] = $errores;
        $variables['success'] = $success;
        $usuario["usuario"] = $_SESSION["usuario"];
        //Pasamos a la vista toda la información que se desea representar
        $this->view->show("cabecera.php");
        $this->view->show("plantilla_header.php", $usuario);
        $this->view->show(RUTA_VISTAS . "listar_header.php");
        $this->view->show(RUTA_VISTAS . "editar.php", $variables);
        $this->view->show("plantilla_pie.php");
        $this->view->show("pie.php", $usuario);
    }
    public function comprobarImagen($foto, $nuevonombre)
    {
        $allowedExts = array("jpg", "jpeg", "gif", "png", "JPG", "GIF", "PNG");
        $tipo = $foto["type"];
        $temp = $foto["tmp_name"];
        $tamano = $foto['size'];
        list($base, $extension) = explode(".", $foto["name"]);
        $resultado = [];
        if ((($tipo == "image/gif")
                || ($tipo == "image/jpeg")
                || ($tipo == "image/png")
                || ($tipo == "image/jpeg"))
            && in_array($extension, $allowedExts)
        ) {
            // el archivo es un JPG/GIF/PNG, entonces...
            if (($tamano <= 2000000)) {
                $directorio = "./views/img/";
                $directorio .= trim($nuevonombre) . "." . $extension;

                if (move_uploaded_file($temp, $directorio)) {
                    $resultado["success"] = true;
                } else {
                    $resultado["mensaje"] = "Ha ocurrido un error al guardar la imagen";
                    $resultado["success"] = false;
                }
            } else {
                $resultado["mensaje"] = "La imagen no puede superar los 200KB";
                $resultado["success"] = false;
            }
        } else { // El archivo no es JPG/GIF/PNG
            $resultado["mensaje"] = $extension . " no es un formato permitido";
            $resultado["success"] = false;
        }
        return $resultado;
    }
}
