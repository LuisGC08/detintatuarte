<?php
//Incluye el modelo que corresponde
define("RUTA_VISTAS", "contenido/Carrito/");
require_once 'models/Pedidos_Model.php';
require_once 'models/Lineas_pedidos_Model.php';
require_once 'models/Clientes_Model.php';
require_once 'models/Articulos_Model.php';
require_once 'models/Clases/pedido.php';
require_once 'models/Clases/linea_pedido.php';

class Carrito_Controller extends Base_Controller
{
    public function alta()
    {
        //Creamos una instancia de nuestro "modelo"
        session_start();
        $errores = [];
        $success = "";
        //Recojo datos si hay
        if (isset($_POST['cod_cliente'])) {
            //Pasamos a la vista toda la información que se desea representar
            $articulos_model = new Articulos_Model();
            $clientes_model = new Clientes_Model();
            $articulos = $articulos_model->readAll();
            foreach ($articulos as $key => $art) {
                if($art->getBaja() != false){
                    $articulos = array_diff($articulos, array($art));
                }
            }
            $_SESSION["cliente"] = $clientes_model->read($_POST['cod_cliente']);
            $usuario['cliente'] = $_SESSION['cliente'];
            $variables['articulos'] = $articulos;
            
            $variables['errores'] = $errores;
            $variables['success'] = $success;
            $usuario["usuario"] = $_SESSION["usuario"];
            //Pasamos a la vista toda la información que se desea representar
            $this->view->show("cabecera.php");
            $this->view->show("plantilla_header.php", $usuario);
            $this->view->show(RUTA_VISTAS . "listar_header.php");
            $this->view->show(RUTA_VISTAS . "listarItems.php", $variables);
            $this->view->show("plantilla_pie.php");
            $this->view->show("pie.php", $usuario);
        } else if(isset($_SESSION["cliente"])){
            $articulos_model = new Articulos_Model();
            $clientes_model = new Clientes_Model();
            $articulos = $articulos_model->readAll();
            foreach ($articulos as $key => $art) {
                if($art->getBaja() != false){
                    $articulos = array_diff($articulos, array($art));
                }
            }
            $variables['articulos'] = $articulos;
            $usuario['cliente'] = $_SESSION['cliente'];
            $variables['errores'] = $errores;
            $variables['success'] = $success;
            $usuario["usuario"] = $_SESSION["usuario"];
            //Pasamos a la vista toda la información que se desea representar
            $this->view->show("cabecera.php");
            $this->view->show("plantilla_header.php", $usuario);
            $this->view->show(RUTA_VISTAS . "listar_header.php");
            $this->view->show(RUTA_VISTAS . "listarItems.php", $variables);
            $this->view->show("plantilla_pie.php");
            $this->view->show("pie.php", $usuario);
        }else {
            $clientes_model = new Clientes_Model();

            //Pasamos a la vista toda la información que se desea representar
            $clientes = $clientes_model->readAll();
            foreach ($clientes as $key => $cliente) {
                if($cliente->getBaja() != false){
                    $clientes = array_diff($clientes, array($cliente));
                }
            }
            $variables['clientes'] = $clientes;
            $usuario["usuario"] = $_SESSION["usuario"];
            //Pasamos a la vista toda la información que se desea representar
            $this->view->show("cabecera.php");
            $this->view->show("plantilla_header.php", $usuario);
            $this->view->show(RUTA_VISTAS . "listar_header.php");
            $this->view->show(RUTA_VISTAS . "alta.php", $variables);
            $this->view->show("plantilla_pie.php");
            $this->view->show("pie.php", $usuario);
        }
    }
    public function procesar()
    {
        if (isset($_REQUEST['compra'])) {
            $pedidos_model = new Pedidos_Model();
            $lin_ped_model = new Lineas_pedidos_Model();
            $articulos_model = new Articulos_Model();
            $pedido = new Pedido();
            
            $compra = $_POST['compra'];

            session_start();
            $usuario['cliente'] = $_SESSION['cliente'];
            $cliente = $_SESSION['cliente'];
            $usuario["usuario"] = $_SESSION["usuario"];
            $usu_gestion = $usuario["usuario"];
            $fecha = getdate();
            $pedido->setFecha($fecha["year"]."-".$fecha["mon"]."-".$fecha["mday"]);
            $pedido->setCod_cliente($cliente->getCod_Cliente());
            $pedidos_model->create($pedido);
            foreach ($compra as $indice => $art) {
                $articulo = $articulos_model->read($art["id"]);
                $lin_ped = new Linea_pedido();
                $lin_ped->setNum_linea_pedido($indice+1);
                $lin_ped->setCod_pedido($pedido->getCod_pedido());
                $lin_ped->setCantidad($art["cantidad"]);
                $lin_ped->setPrecio($articulo->getPrecio());
                $lin_ped->setCantidadenAlbaran(0);
                $lin_ped->setCod_articulo($art["id"]);
                $lin_ped->setCod_usu_gestion($usu_gestion->getCod_usuario_gestion());
                $lin_ped_model->create($lin_ped);
            }
            if(!is_null($pedido)){
                $dataResult["success"] = true;
            } else {
                $dataResult["success"] = false;
                $dataResult["data"] = [
                    'mensaje' => "No se ha podido realizar el pedido",
                ];
            }
            echo json_encode($dataResult);
            
        }
    }
    public function cerrar(){
        session_start();
        unset($_SESSION["cliente"]);
        $clientes_model = new Clientes_Model();

        //Pasamos a la vista toda la información que se desea representar
        $variables['clientes'] = $clientes_model->readAll();
        $usuario["usuario"] = $_SESSION["usuario"];
        //Pasamos a la vista toda la información que se desea representar
        $this->view->show("cabecera.php");
        $this->view->show("plantilla_header.php", $usuario);
        $this->view->show(RUTA_VISTAS . "listar_header.php");
        $this->view->show(RUTA_VISTAS . "alta.php", $variables);
        $this->view->show("plantilla_pie.php");
        $this->view->show("pie.php", $usuario);
    }
}
