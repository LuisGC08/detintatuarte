<?php
//Incluye el modelo que corresponde
define("RUTA_VISTAS", "contenido/Pedidos/");
require_once 'models/Pedidos_Model.php';
require_once 'models/Lineas_pedidos_Model.php';
require_once 'models/Clientes_Model.php';
require_once 'models/Articulos_Model.php';

class pedidos_Controller extends Base_Controller
{
    public function listar()
    {
        //Creamos una instancia de nuestro "modelo"
        $pedidos_model = new Pedidos_Model();
        $lin_ped_model = new Lineas_pedidos_Model();
        $lin_ped_model = new Lineas_pedidos_Model();
        $articulo_model = new Articulos_Model();
        $cliente_model = new Clientes_Model();

        session_start();
        //Le pedimos al modelo todos los Piezas
        $pedidos = $pedidos_model->readAll();
        $lineas_pedido = [];
        $articulos_pedido = [];
        $clientes_pedidos = [];
        foreach ($pedidos as $key => $pedido) {
            $clientes_pedidos[] = $cliente_model->read($pedido->getCod_cliente());
        }
        //Pasamos a la vista toda la información que se desea representar
        if (isset($_SESSION['cliente'])) {
            $usuario["cliente"] = $_SESSION['cliente'];
        }
        $variables = array();
        $usuario["usuario"] = $_SESSION["usuario"];
        $variables["lineas_pedido"] = $lineas_pedido;
        $variables["articulos_pedido"] = $articulos_pedido;
        $variables['pedidos'] = $pedidos;
        $variables['clientes_pedidos'] = $clientes_pedidos;

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
        $pedidos_model = new Pedidos_Model();
        $cliente_model = new Clientes_Model();
        session_start();

        $campo = (isset($_REQUEST['campo'])) ? $_REQUEST['campo'] : "cod_pedido";
        $filtro = (isset($_REQUEST['filtro'])) ? $_REQUEST['filtro'] : "contiene";
        $texto = (isset($_REQUEST['texto'])) ? $_REQUEST['texto'] : "%";

        //Le pedimos al modelo todos los Piezas
        $pedidos = $pedidos_model->filterBy($campo, $filtro, $texto);

        $clientes_pedidos = [];
        foreach ($pedidos as $key => $pedido) {
            $clientes_pedidos[] = $cliente_model->read($pedido->getCod_cliente());
        }
        //Pasamos a la vista toda la información que se desea representar
        if (isset($_SESSION['cliente'])) {
            $usuario["cliente"] = $_SESSION['cliente'];
        }
        $varVistaFormFiltrar = ["campo" => $campo, "filtro" => $filtro, "texto" => $texto];
        $varVistaListar['pedidos'] = $pedidos;
        $usuario["usuario"] = $_SESSION["usuario"];
        $varVistaListar['clientes_pedidos'] = $clientes_pedidos;
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
        if (!isset($_REQUEST['id'])) {
            die("No has especificado un identificador de pedido.");
        }

        $id = $_REQUEST['id'];
        session_start();
        //Creamos una instancia de nuestro "modelo"
        $pedidos_model = new Pedidos_Model();
        $lin_ped_model = new Lineas_pedidos_Model();
        $articulo_model = new Articulos_Model();
        $clientes_model = new Clientes_Model();
        //Le pide al modelo LA pedido con id = $id
        $pedido = $pedidos_model->read($id);
        $lineas_pedido = $lin_ped_model->filterBy("cod_pedido", "igual", $id);

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
        $usuario["usuario"] = $_SESSION["usuario"];
        $variables["lineas_pedido"] = $lineas_pedido;
        $variables["articulos_pedido"] = $articulos_pedido;
        $variables['pedido'] = $pedido;
        $variables["cliente"] = $clientes_model->read($pedido->getCod_cliente());

        //Finalmente presentamos nuestra plantilla
        $this->view->show("cabecera.php");
        $this->view->show("plantilla_header.php", $usuario);
        $this->view->show(RUTA_VISTAS . "listar_header.php");
        $this->view->show(RUTA_VISTAS . "ver.php", $variables);
        $this->view->show("plantilla_pie.php");
        $this->view->show("pie.php", $usuario);
    }


    public function eliminar()
    {
        //recoger datos
        // y controlar datos
        $pedidos_model = new Pedidos_Model();
        $clientes_model = new Clientes_Model();
        session_start();
        $mensaje = "";
        $error = "";
        if (!isset($_REQUEST["id"])) {
            die("Error, falta el id de la pieza a borrar");
        }
        $id = $_REQUEST["id"];
        //accedo al modelo y opero
        $pedido = $pedidos_model->read($id);
        if ($pedido == null) {
            die("No existe la pieza");
        }
        if ($pedidos_model->delete($id)) {
            $mensaje = "El pedido se ha eliminado correctamente";
        } else {
            $error = "Ha ocurrido un problema";
        }

        //Paso a la vista el resultado
        if (isset($_SESSION['cliente'])) {
            $usuario["cliente"] = $_SESSION['cliente'];
        }
        $pedidos = $pedidos_model->readAll();
        $clientes_pedidos = [];
        foreach ($pedidos as $key => $pedido) {
            $clientes_pedidos[] = $clientes_model->read($pedido->getCod_cliente());
        }
        $variables["success"] = $mensaje;
        $variables["error"] = $error;
        $variables["pedidos"] = $pedidos;
        $usuario["usuario"] = $_SESSION["usuario"];
        $varVistaListar['clientes_pedidos'] = $clientes_pedidos;
        $this->view->show("cabecera.php");
        $this->view->show("plantilla_header.php", $usuario);
        $this->view->show(RUTA_VISTAS . "listar_header.php");
        $this->view->show(RUTA_VISTAS . "listar.php", $variables);
        $this->view->show("plantilla_pie.php");
        $this->view->show("pie.php", $usuario);
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

        if (isset($_REQUEST["id"])) {
            $id = $_REQUEST["id"];
            $pedido = $pedidos_model->read($id);
        } elseif (isset($_POST['cod_pedido'])) {
            $id=$_REQUEST["cod_pedido"];
            $pedido = $pedidos_model->read($_POST['cod_pedido']);
            $lineas_pedido = $lin_ped_model->filterBy("cod_pedido", "igual", $_POST['cod_pedido']);
            for ($i = 0; $i < count($lineas_pedido); $i++) {
                foreach ($lineas_pedido as $key => $linea_pedido) {
                    if (isset($_POST["cantidad" . $i])) {
                        if ($_POST["num" . $i] == $linea_pedido->getNum_linea_pedido()) {
                            if($_POST["cod_articulo" . $i] != $linea_pedido->getCod_articulo() || $_POST["precio" . $i] != $linea_pedido->getPrecio() || $_POST["cantidad" . $i] != $linea_pedido->getCantidad()){
                                $linea_pedido->setCod_articulo($_POST["cod_articulo" . $i]);
                                $linea_pedido->setPrecio($_POST["precio" . $i]);
                                $linea_pedido->setCantidad($_POST["cantidad" . $i]);
                                if ($lin_ped_model->update($linea_pedido, $linea_pedido->getNum_linea_pedido())) {
                                    $success = "El pedido ha sido modificado correctamente";
                                } else {
                                    $error = "Ha ocurrido un error";
                                }
                            }
                            
                        }
                    }
                }
            }
        }

        //Le pide al modelo LA pedido con id = $id

        $lineas_pedido = $lin_ped_model->filterBy("cod_pedido", "igual", $id);

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
        $articulos = $articulo_model->readAll();
        foreach ($articulos as $key => $art) {
            if($art->getBaja() != false){
                $articulos = array_diff($articulos, array($art));
            }
        }
        $variables = array();
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
