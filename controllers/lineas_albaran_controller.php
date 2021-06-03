<?php
//Incluye el modelo que corresponde
define("RUTA_VISTAS", "contenido/Lineas_Albaran/");
require_once 'models/Pedidos_Model.php';
require_once 'models/Lineas_pedidos_Model.php';
require_once 'models/Lineas_albaran_Model.php';
require_once 'models/Albaranes_Model.php';
require_once 'models/Articulos_Model.php';
require_once 'models/Clientes_Model.php';

class Lineas_albaran_Controller extends Base_Controller
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
        $pedidos_model = new Pedidos_Model();
        $cliente_model = new Clientes_Model();
        $alb_model = new Albaranes_Model();
        $lin_ped_model = new Lineas_pedidos_Model();
        $lin_alb_model = new Lineas_albaran_Model();
        $articulo_model = new Articulos_Model();

        session_start();

        $id = $_REQUEST['id'];
        $pedido = $pedidos_model->read($id);
        $cliente = $cliente_model->read($pedido->getCod_cliente());
        $usuario["usuario"] = $_SESSION["usuario"];
        $usu_gestion = $usuario["usuario"];

        $errores = "";
        $success = "";
        if (isset($_POST["check"])) {
            $albaran = new Albaran();
            $pedido = $pedidos_model->read($id);
            $fecha = getdate();
            $albaran->setFecha($fecha["year"] . "-" . $fecha["mon"] . "-" . $fecha["mday"]);
            $albaran->setCod_cliente($pedido->getCod_cliente());
            $alb_model->create($albaran);
            foreach ($_POST["check"] as $key => $num_lin_ped) {
                $cantidad = $_POST["cantidad" . ($num_lin_ped-1)];
                $lin_ped = $lin_ped_model->read($num_lin_ped, $pedido->getCod_pedido());
                $cant_antigua = $lin_ped->getCantidadEnAlbaran();
                if (($cant_antigua + $cantidad) > $lin_ped->getCantidad()) {
                    $errores = "No puede generar un albarán que contenga mas cantidad de articulo que en el pedido";
                } else if ($cantidad == 0) {
                } else {
                    $lin_alb = new Linea_Albaran();
                    $lin_alb->setNum_linea_albaran($key + 1);
                    $lin_alb->setCod_albaran($albaran->getCod_albaran());
                    $lin_alb->setPrecio($lin_ped->getPrecio());
                    $lin_alb->setCantidad($cantidad);
                    $lin_alb->setCod_articulo($lin_ped->getCod_articulo());
                    $lin_alb->setCod_usu_gestion($usu_gestion->getCod_usuario_gestion());
                    $lin_alb->setNum_linea_pedido($lin_ped->getNum_linea_pedido());
                    $lin_alb->setCod_pedido($lin_ped->getCod_pedido());
                    $lin_alb_model->create($lin_alb);

                    $lin_ped->setCantidadEnAlbaran($lin_alb->getCantidad() + $cant_antigua);
                    $lin_ped_model->update($lin_ped, $lin_ped->getNum_linea_pedido());
                    $success = "Albarán de pedido " . $pedido->getCod_pedido() . " generado correctamente";
                }
            }
        }

        $articulos_pedido = [];
        $lineas_pedido = $lin_ped_model->filterBy("cod_pedido", "contiene", $id);
        foreach ($lineas_pedido as $key => $lin_ped) {
            $articulo = $articulo_model->read($lin_ped->getCod_articulo());
            $articulos_pedido[] = $articulo;
        }

        //Pasamos a la vista toda la información que se desea representar
        if (isset($_SESSION['cliente'])) {
            $usuario["cliente"] = $_SESSION['cliente'];
        }
        $variables = array();
        $usuario["usuario"] = $_SESSION["usuario"];
        $variables["lineas_pedido"] = $lineas_pedido;
        $variables["articulos_pedido"] = $articulos_pedido;
        $variables['pedido'] = $pedido;
        $variables['articulo'] = $lin_ped;
        $variables['cliente'] = $cliente;
        $variables['errores'] = $errores;
        $variables['success'] = $success;
        $usuario["usuario"] = $_SESSION["usuario"];
        //Pasamos a la vista toda la información que se desea representar
        $this->view->show("cabecera.php");
        $this->view->show("plantilla_header.php", $usuario);
        $this->view->show("contenido/Albaranes/listar_header.php");
        $this->view->show(RUTA_VISTAS . "alta.php", $variables);
        $this->view->show("plantilla_pie.php");
        $this->view->show("pie.php", $usuario);
    }
    public function eliminar()
    {
        //recoger datos
        // y controlar datos
        $lin_ped_model = new Lineas_pedidos_Model();
        $lin_alb_model = new Lineas_albaran_Model();
        $albaranes_model = new Albaranes_Model();
        $pedidos_model = new Pedidos_Model();
        $articulo_model = new Articulos_Model();
        $clientes_model = new Clientes_Model();
        session_start();
        $mensaje = "";
        $error = "";
        if (!isset($_REQUEST["id"]) && !isset($_REQUEST["num"])) {
            die("Error, falta el id de la linea a borrar");
        }
        $id = $_REQUEST["id"];
        $num = $_REQUEST["num"];
        //accedo al modelo y opero
        $lin_alb = $lin_alb_model->read($num, $id);
        if ($lin_alb == null) {
            die("No existe la pieza");
        }
        $lin_ped = $lin_ped_model->read($lin_alb->getNum_linea_pedido(), $lin_alb->getCod_pedido());
        $lin_ped->setCantidadEnAlbaran(0);
        $lin_ped_model->update($lin_ped, $lin_ped->getNum_linea_pedido());

        if ($lin_alb_model->delete($num, $id)) {
            $mensaje = "La linea se ha eliminado correctamente";
        } else {
            $error = "Ha ocurrido un problema";
        }
        $albaran = $albaranes_model->read($id);
        $lineas_albaran = $lin_alb_model->filterBy("cod_albaran", "igual", $id);
        if (count($lineas_albaran) == 0) {
            $albaranes_model->delete($albaran->getCod_albaran());
            header("Location: index.php?controller=albaranes&action=listar");
        } else {
            $articulos_pedido = [];
            foreach ($lineas_albaran as $key => $linea_albaran) {
                $articulo = $articulo_model->read($linea_albaran->getCod_articulo());
                $articulos_pedido[] = $articulo;
                $numAntiguo = $linea_albaran->getNum_linea_albaran();
                $linea_albaran->setNum_linea_albaran($key + 1);
                $lin_alb_model->update($linea_albaran, $numAntiguo);
            }
            //Paso a la vista el resultado
            if (isset($_SESSION['cliente'])) {
                $usuario["cliente"] = $_SESSION['cliente'];
            }
            $variables["success"] = $mensaje;
            $variables["error"] = $error;
            $variables["lineas_albaran"] = $lineas_albaran;
            $variables["articulos_albaran"] = $articulos_pedido;
            $variables['albaran'] = $albaran;
            $variables['cliente'] = $clientes_model->read($albaran->getCod_cliente());
            $usuario["usuario"] = $_SESSION["usuario"];
            $this->view->show("cabecera.php");
            $this->view->show("plantilla_header.php", $usuario);
            $this->view->show("contenido/Albaranes/listar_header.php");
            $this->view->show("contenido/Albaranes/ver.php", $variables);
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
        $albaranes_model = new Albaranes_Model();
        $lin_alb_model = new Lineas_albaran_Model();
        $articulo_model = new Articulos_Model();
        $clientes_model = new Clientes_Model();

        if (isset($_REQUEST["id"])) {
            $id = $_REQUEST["id"];
            $albaran = $albaranes_model->read($id);
            $num = $_REQUEST["num"];
            $linea_albaran = $lin_alb_model->read($num, $id);
            $lineas_albaran[] = $linea_albaran;
        } 


        if ($albaran === null) {
            die("Identificador de albaran incorrecto");
        }
        $articulos_albaran = [];
        foreach ($lineas_albaran as $key => $lin_ped) {
            $articulo = $articulo_model->read($lin_ped->getCod_articulo());
            $articulos_albaran[] = $articulo;
        }

        if (isset($_SESSION['cliente'])) {
            $usuario["cliente"] = $_SESSION['cliente'];
        }
        $variables = array();
        $articulos = $articulo_model->readAll();
        $usuario["usuario"] = $_SESSION["usuario"];
        $variables["lineas_albaran"] = $lineas_albaran;
        $variables['articulos'] = $articulos;
        $variables["articulos_albaran"] = $articulos_albaran;
        $variables['albaran'] = $albaran;
        $variables["cliente"] = $clientes_model->read($albaran->getCod_cliente());
        $variables["error"] = $error;
        $variables["success"] = $success;
        //Finalmente presentamos nuestra plantilla
        $this->view->show("cabecera.php");
        $this->view->show("plantilla_header.php", $usuario);
        $this->view->show("contenido/Albaranes/listar_header.php");
        $this->view->show("contenido/Albaranes/editar.php", $variables);
        $this->view->show("plantilla_pie.php");
        $this->view->show("pie.php", $usuario);
    }
}
