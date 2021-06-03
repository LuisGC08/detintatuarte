<?php
//Incluye el modelo que corresponde
define("RUTA_VISTAS", "contenido/Lineas_facturas/");
require_once 'models/Facturas_Model.php';
require_once 'models/Lineas_facturas_Model.php';
require_once 'models/Lineas_albaran_Model.php';
require_once 'models/Albaranes_Model.php';
require_once 'models/Articulos_Model.php';
require_once 'models/Clientes_Model.php';

class Lineas_facturas_Controller extends Base_Controller
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
        $lineas_facturas_model = new Lineas_albaran_Model();
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
                    $lin_fac = new Linea_Albaran();
                    $lin_fac->setNum_linea_albaran($key + 1);
                    $lin_fac->setCod_albaran($albaran->getCod_albaran());
                    $lin_fac->setPrecio($lin_ped->getPrecio());
                    $lin_fac->setCantidad($cantidad);
                    $lin_fac->setCod_articulo($lin_ped->getCod_articulo());
                    $lin_fac->setCod_usu_gestion($usu_gestion->getCod_usuario_gestion());
                    $lin_fac->setNum_linea_pedido($lin_ped->getNum_linea_pedido());
                    $lin_fac->setCod_pedido($lin_ped->getCod_pedido());
                    $lineas_facturas_model->create($lin_fac);

                    $lin_ped->setCantidadEnAlbaran($lin_fac->getCantidad() + $cant_antigua);
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
        $lineas_facturas_model = new Lineas_facturas_Model();
        $cliente_model = new Clientes_Model();
        $facturas_model = new Facturas_Model();
        $albaranes_model = new Albaranes_Model();
        $clientes_model = new Clientes_Model();

        session_start();
        $mensaje = "";
        $error = "";
        
        if(isset($_REQUEST["id"])){
            $id = $_REQUEST["id"];
            //accedo al modelo y opero
            $factura = $facturas_model->read($id);
        } 
        if(isset($_REQUEST["cod_albaran"])){
            $lineas_factura = $lineas_facturas_model->filterBy("cod_albaran", "igual", $_REQUEST["cod_albaran"]);
            $factura = $facturas_model->read($lineas_factura[0]->getCod_factura());
            foreach ($lineas_factura as $key => $lin_fac) {
                $lineas_facturas_model->delete($lin_fac->getNum_linea_factura(), $lin_fac->getCod_factura());
            }
            $success="Albarán desfacturado correctamente";

        }


        //Paso a la vista el resultado
        if (isset($_SESSION['cliente'])) {
            $usuario["cliente"] = $_SESSION['cliente'];
        }
        $lineas_factura = $lineas_facturas_model->filterBy("cod_factura", "igual", $factura->getCod_factura());
        $albaranes = [];
        $alb_anterior = "";
        foreach ($lineas_factura as $key => $lin_fac) {
            $albaran = $albaranes_model->read($lin_fac->getCod_albaran());
            if($albaran->getCod_albaran() != $alb_anterior){
                $albaranes [] = $albaran;
            }
            $alb_anterior = $albaran->getCod_albaran();
        }

        $variables["success"] = $mensaje;
        $variables["error"] = $error;
        $variables["albaranes"] = $albaranes;
        $usuario["usuario"] = $_SESSION["usuario"];
        $variables['factura'] = $factura;
        $variables["cliente"] = $clientes_model->read($factura->getCod_cliente());
        $this->view->show("cabecera.php");
        $this->view->show("plantilla_header.php", $usuario);
        $this->view->show("contenido/Facturas/listar_header.php");
        $this->view->show("contenido/Facturas/desfacturar.php", $variables);
        $this->view->show("plantilla_pie.php");
        $this->view->show("pie.php", $usuario);
        
    }
    public function editar()
    {
        $error = "";
        $success = "";
        session_start();
        //Creamos una instancia de nuestro "modelo"
        $facturas_model = new Facturas_Model();
        $lineas_facturas_model = new Lineas_albaran_Model();
        $articulo_model = new Articulos_Model();
        $clientes_model = new Clientes_Model();

        if (isset($_REQUEST["id"])) {
            $id = $_REQUEST["id"];
            $factura = $facturas_model->read($id);
            $num = $_REQUEST["num"];
            $linea_factura = $lineas_facturas_model->read($num, $id);
            $lineas_factura[] = $linea_factura;
        } 


        if ($factura === null) {
            die("Identificador de albaran incorrecto");
        }
        $articulos_albaran = [];
        foreach ($lineas_factura as $key => $lin_ped) {
            $articulo = $articulo_model->read($lin_ped->getCod_articulo());
            $articulos_albaran[] = $articulo;
        }

        if (isset($_SESSION['cliente'])) {
            $usuario["cliente"] = $_SESSION['cliente'];
        }
        $variables = array();
        $articulos = $articulo_model->readAll();
        $usuario["usuario"] = $_SESSION["usuario"];
        $variables["lineas_albaran"] = $lineas_factura;
        $variables['articulos'] = $articulos;
        $variables["articulos_albaran"] = $articulos_albaran;
        $variables['factura'] = $factura;
        $variables["cliente"] = $clientes_model->read($factura->getCod_cliente());
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
