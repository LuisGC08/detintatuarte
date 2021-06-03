<?php
//Incluye el modelo que corresponde
define("RUTA_VISTAS", "/contenido/Clientes/");
require_once 'models/Clientes_Model.php';
require_once 'models/Clases/Cliente.php';

class Clientes_Controller extends Base_Controller
{
    public function listar()
    {
        //Creamos una instancia de nuestro "modelo"
        $Clientes_Model = new Clientes_Model();
        session_start();
        //Le pedimos al modelo todos los Piezas
        $clientes = $Clientes_Model->readAll();

        //Pasamos a la vista toda la información que se desea representar
        $variables = array();
        /* $variables['clientes'] = $clientes; */
        if (isset($_SESSION['cliente'])) {
            $usuario["cliente"] = $_SESSION['cliente'];
        }
        $usuario["usuario"] = $_SESSION["usuario"];
        $variables["clientes"] = $clientes;
        //Finalmente presentamos nuestra plantilla
        $this->view->show("cabecera.php");
        $this->view->show("plantilla_header.php", $usuario);
        $this->view->show(RUTA_VISTAS."listar_header.php");
        $this->view->show(RUTA_VISTAS."listar.php", $variables);
        $this->view->show("plantilla_pie.php");
        $this->view->show("pie.php", $usuario);
    }


    public function filtrar()
    {
        //Creamos una instancia de nuestro "modelo"
        $Clientes_Model = new Clientes_Model();
        session_start();

        $campo=(isset($_REQUEST['campo']))?$_REQUEST['campo']:"cod_cliente";
        $filtro=(isset($_REQUEST['filtro']))?$_REQUEST['filtro']: "contiene";
        $texto=(isset($_REQUEST['texto']))?$_REQUEST['texto']:"%";

        //Le pedimos al modelo todos los Piezas
        $clientes = $Clientes_Model->filterBy($campo, $filtro, $texto);

        //Pasamos a la vista toda la información que se desea representar
        if (isset($_SESSION['cliente'])) {
            $usuario["cliente"] = $_SESSION['cliente'];
        }
        $varVistaFormFiltrar=["campo"=>$campo,"filtro"=>$filtro,"texto"=>$texto];
        $usuario["usuario"] = $_SESSION["usuario"];
        $varVistaListar = ['clientes'=> $clientes];
        //Finalmente presentamos nuestra plantilla
        $this->view->show("cabecera.php");
        $this->view->show("plantilla_header.php", $usuario);
        $this->view->show(RUTA_VISTAS."listar_header.php");
        $this->view->show(RUTA_VISTAS."form_filtrar.php", $varVistaFormFiltrar);
        $this->view->show(RUTA_VISTAS."listar.php", $varVistaListar);
        $this->view->show("plantilla_pie.php");
        $this->view->show("pie.php", $usuario);
    }

    public function ver()
    {
        if (!isset($_GET ['id'])) {
            die("No has especificado un identificador de pieza.");
        }

        $id = $_GET['id'];

        //Creamos una instancia de nuestro "modelo"
        $Clientes_Model = new Clientes_Model();

        //Le pide al modelo LA pieza con id = $id
        $cliente= $Clientes_Model->read($id);

        if ($cliente === null) {
            die("Identificador de cliente incorrecto");
        }

        //Pasamos a la vista toda la información que se desea representar
        $variables = array();
        $variables['cliente'] = $cliente;

        //Pasamos a la vista toda la información que se desea representar
        $this->view->show(RUTA_VISTAS.'ver.php', $variables);
    }
    public function eliminar()
    {
        //recoger datos
        // y controlar datos
        $clientes_model = new Clientes_Model();
        session_start();
        $mensaje = "";
        $error = "";
        if (!isset($_REQUEST["id"])) {
            die("Error, falta el id del cliente");
        }
        $id = $_REQUEST["id"];
        //accedo al modelo y opero
        $cliente = $clientes_model->read($id);
        if ($cliente == null) {
            die("No existe la articulo");
        }
        if ($cliente->getBaja() == true) {
            if($clientes_model->darBajaAlta($id, false)){
                $mensaje = "El cliente ". $cliente->getNick()." se ha dado de alta correctamente";
            } else {
                $error = "Ha ocurrido un problema al dar de alta el articulo";
            }
            
        } else {
            if($clientes_model->darBajaAlta($id, true)){
                $mensaje = "El cliente ". $cliente->getNick()." se ha dado de baja correctamente";
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
        $variables["clientes"] =$clientes_model->readAll();
        $usuario["usuario"] = $_SESSION["usuario"];
        $this->view->show("cabecera.php");
        $this->view->show("plantilla_header.php", $usuario);
        $this->view->show(RUTA_VISTAS . "listar_header.php");
        $this->view->show(RUTA_VISTAS . "listar.php", $variables);
        $this->view->show("plantilla_pie.php");
        $this->view->show("pie.php", $usuario);
    }
}
