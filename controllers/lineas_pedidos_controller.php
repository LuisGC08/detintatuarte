<?php
//Incluye el modelo que corresponde
define("RUTA_VISTAS", "contenido/Pedidos/");
require_once 'models/Pedidos_Model.php';
require_once 'models/Lineas_pedidos_Model.php';
require_once 'models/Articulos_Model.php';
require_once 'models/Clientes_Model.php';

class Lineas_pedidos_Controller extends Base_Controller
{
    public function listar()
    {
        //Creamos una instancia de nuestro "modelo"
        $lin_pedidos_model = new Lineas_pedidos_Model();
        session_start();
        //Le pedimos al modelo todos los Piezas
        $lin_pedidos = $lin_pedidos_model->readAll();

        //Pasamos a la vista toda la información que se desea representar
        if (isset($_SESSION['cliente'])) {
            $usuario["cliente"] = $_SESSION['cliente'];
        }
        $variables = array();
        $usuario["usuario"] = $_SESSION["usuario"];
        $variables['articulos'] = $lin_pedidos;

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
        $lin_ped_model = new Lineas_pedidos_Model();
        session_start();

        $campo = (isset($_REQUEST['campo'])) ? $_REQUEST['campo'] : "cod_articulo";
        $filtro = (isset($_REQUEST['filtro'])) ? $_REQUEST['filtro'] : "contiene";
        $texto = (isset($_REQUEST['texto'])) ? $_REQUEST['texto'] : "%";

        //Le pedimos al modelo todos los Piezas
        $lin_pedidos = $lin_ped_model->filterBy($campo, $filtro, $texto);

        //Pasamos a la vista toda la información que se desea representar
        if (isset($_SESSION['cliente'])) {
            $usuario["cliente"] = $_SESSION['cliente'];
        }
        $varVistaFormFiltrar = ["campo" => $campo, "filtro" => $filtro, "texto" => $texto];
        $varVistaListar['articulos'] = $lin_pedidos;
        $usuario["usuario"] = $_SESSION["usuario"];
        //Finalmente presentamos nuestra plantilla
        $this->view->show("cabecera.php");
        $this->view->show("plantilla_header.php", $usuario);
        $this->view->show(RUTA_VISTAS . "listar_header.php");
        $this->view->show(RUTA_VISTAS . "listar_pedido.php", $varVistaFormFiltrar);
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
        $num = $_GET['num'];

        //Creamos una instancia de nuestro "modelo"
        $lin_ped_model = new Lineas_pedidos_Model();

        //Le pide al modelo LA articulo con id = $id
        $lin_ped = $lin_ped_model->read($num, $id);

        if ($lin_ped === null) {
            die("Identificador de articulo incorrecto");
        }

        //Pasamos a la vista toda la información que se desea representar
        $variables = array();
        $variables['lin'] = $lin_ped;

        //Pasamos a la vista toda la información que se desea representar
        $this->view->show(RUTA_VISTAS . 'ver.php', $variables);
    }

    public function alta()
    {
        //Creamos una instancia de nuestro "modelo"
        $lin_ped_model = new Lineas_pedidos_Model();
        $lin_ped = new Linea_pedido();
        session_start();
        $errores = [];
        $success = "";
        //Recojo datos si hay
        if (isset($_POST['cod_pedido'])) {
            $lin_ped->setCod_pedido($_POST['cod_pedido']);
            $lin_ped->setPrecio($_POST['precio']);
            $lin_ped->setCantidad($_POST['cantidad']);
            $lin_ped->setCod_articulo($_POST['cod_articulo']);
            if ($lin_ped_model->create($lin_ped)) {
                $success = "Agregado correctamente";
            } else {
                $errores[] = "Campo duplicados";
            }
        }

        //Pasamos a la vista toda la información que se desea representar
        if (isset($_SESSION['cliente'])) {
            $usuario["cliente"] = $_SESSION['cliente'];
        }
        $variables['articulo'] = $lin_ped;
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
        $lin_ped_model = new Lineas_pedidos_Model();
        $pedidos_model = new Pedidos_Model();
        $articulo_model = new Articulos_Model();
        session_start();
        $mensaje = "";
        $error = "";
        if (!isset($_REQUEST["cod_pedido"]) && !isset($_REQUEST["num"])) {
            die("Error, falta el id de la linea a borrar");
        }
        $id = $_REQUEST["cod_pedido"];
        $num = $_REQUEST["num"];
        //accedo al modelo y opero
        $lin_ped = $lin_ped_model->read($num, $id);
        if ($lin_ped == null) {
            die("No existe la pieza");
        }
        if ($lin_ped_model->delete($num, $id)) {
            $mensaje = "La linea se ha eliminado correctamente";
        } else {
            $error = "Ha ocurrido un problema";
        }
        $pedido = $pedidos_model->read($id);
        $lineas_pedido = $lin_ped_model->filterBy("cod_pedido", "igual", $id);
        if (count($lineas_pedido) == 0) {
            $pedidos_model->delete($pedido->getCod_pedido());
            header("Location: index.php?controller=pedidos&action=listar");
        } else {
            $articulos_pedido = [];
            foreach ($lineas_pedido as $key => $lin_ped) {
                $articulo = $articulo_model->read($lin_ped->getCod_articulo());
                $articulos_pedido[] = $articulo;
                $numAntiguo = $lin_ped->getNum_linea_pedido();
                $lin_ped->setNum_linea_pedido($key + 1);
                $lin_ped_model->update($lin_ped, $numAntiguo);
            }
            //Paso a la vista el resultado
            if (isset($_SESSION['cliente'])) {
                $usuario["cliente"] = $_SESSION['cliente'];
            }
            $variables["success"] = $mensaje;
            $variables["error"] = $error;
            $variables["lineas_pedido"] = $lineas_pedido;
            $variables["articulos_pedido"] = $articulos_pedido;
            $variables['pedido'] = $pedido;
            $usuario["usuario"] = $_SESSION["usuario"];
            $this->view->show("cabecera.php");
            $this->view->show("plantilla_header.php", $usuario);
            $this->view->show(RUTA_VISTAS . "listar_header.php");
            $this->view->show(RUTA_VISTAS . "ver.php", $variables);
            $this->view->show("plantilla_pie.php");
            $this->view->show("pie.php", $usuario);
        }
    }
    public function editar()
    {
        $error = "";
        $success = "";
        session_start();
        //Creamos una instancia de nuestro "modelo"
        $pedidos_model = new Pedidos_Model();
        $lin_ped_model = new Lineas_pedidos_Model();
        $articulo_model = new Articulos_Model();
        $clientes_model = new Clientes_Model();
        $lineas_pedido = [];
        if (isset($_REQUEST["id"])) {
            $id = $_REQUEST["id"];
            $num = $_REQUEST["num"];
            $pedido = $pedidos_model->read($id);
            $linea_pedido = $lin_ped_model->read($num, $id);
            $lineas_pedido[] = $linea_pedido;
        } 

        //Le pide al modelo LA pedido con id = $id

        if ($pedido === null) {
            die("Identificador de pedido incorrecto");
        }
        $articulos_pedido = [];
        foreach ($lineas_pedido as $key => $lin_ped) {
            $articulo = $articulo_model->read($lin_ped->getCod_articulo());
            $articulos_pedido[] = $articulo;
        }

        if (isset($_SESSION['cliente'])) {
            $usuario["cliente"] = $_SESSION['cliente'];
        }
        $variables = array();
        $articulos = $articulo_model->readAll();
        $usuario["usuario"] = $_SESSION["usuario"];
        $variables["lineas_pedido"] = $lineas_pedido;
        $variables['articulos'] = $articulos;
        $variables["articulos_pedido"] = $articulos_pedido;
        $variables['pedido'] = $pedido;
        $variables["cliente"] = $clientes_model->read($pedido->getCod_cliente());
        $variables["error"] = $error;
        $variables["success"] = $success;
        //Finalmente presentamos nuestra plantilla
        $this->view->show("cabecera.php");
        $this->view->show("plantilla_header.php", $usuario);
        $this->view->show(RUTA_VISTAS . "listar_header.php");
        $this->view->show(RUTA_VISTAS . "editar.php", $variables);
        $this->view->show("plantilla_pie.php");
        $this->view->show("pie.php", $usuario);
    }
}
