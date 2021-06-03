<?php
//Incluye el modelo que corresponde
define("RUTA_VISTAS", "contenido/Facturas/");
require_once 'models/Albaranes_Model.php';
require_once 'models/Facturas_Model.php';
require_once 'models/Lineas_facturas_Model.php';
require_once 'models/Lineas_albaran_Model.php';
require_once 'models/Clientes_Model.php';
require_once 'models/Articulos_Model.php';

class Facturas_Controller extends Base_Controller
{
    public function alta()
    {
        //Creamos una instancia de nuestro "modelo"
        $facturas_model = new Facturas_Model();
        $clientes_model = new Clientes_Model();
        $alb_model = new Albaranes_Model();
        $lin_alb_model = new Lineas_albaran_Model();
        $lin_fac_model = new Lineas_facturas_Model();
        $articulos_model = new Articulos_Model();

        //Creamos una instancia de nuestro "modelo"
        session_start();
        $error = "";
        $success = "";
        //Recojo datos si hay
        if (isset($_POST['cod_cliente'])) {
            $albaranes = $alb_model->filterBy("cod_cliente", "igual", $_POST["cod_cliente"]);
            //Pasamos a la vista toda la información que se desea representar
            $id_cliente = $_POST['cod_cliente'];
            $usuario["usuario"] = $_SESSION["usuario"];
            if (isset($_POST["check"])) {
                $factura = new Factura();
                $fecha = getdate();
                $factura->setFecha($fecha["year"] . "-" . $fecha["mon"] . "-" . $fecha["mday"]);
                $factura->setCod_cliente($id_cliente);
                $factura->setDescuento_factura($_POST["descuento"]);
                $facturas_model->create($factura);
                $num = 0;
                foreach ($_POST["check"] as $key => $cod_albaran) {
                    $albaran = $alb_model->read($cod_albaran);
                    $lin_fac = new Linea_factura();
                    $lin_fac->setCod_factura($factura->getCod_factura());
                    $lineas_albaran = $lin_alb_model->filterBy("cod_albaran", "igual", $albaran->getCod_albaran());
                    foreach ($lineas_albaran as $indice => $lin_alb) {
                        $num++;
                        $lin_fac->setNum_linea_factura($num);
                        $lin_fac->setPrecio($lin_alb->getPrecio());
                        $lin_fac->setCantidad($lin_alb->getCantidad());
                        $lin_fac->setDescuento($lin_alb->getDescuento());
                        $lin_fac->setIVA($lin_alb->getIVA());
                        $lin_fac->setCod_articulo($lin_alb->getCod_articulo());
                        $lin_fac->setCod_usuario_gestion($usuario["usuario"]->getCod_usuario_gestion());
                        $lin_fac->setNum_linea_albaran($lin_alb->getNum_linea_albaran());
                        $lin_fac->setCod_albaran($lin_alb->getCod_albaran());
                        $lin_fac_model->create($lin_fac);
                    }                    
                }
                $success="Factura creada";
            }
            $albaranes = $alb_model->filterBy("cod_cliente", "igual", $id_cliente);
            foreach ($albaranes as $key => $albaran) {
                if (!$albaran->getEsBorrable()) {
                    $albaranes = array_diff($albaranes, array($albaran));
                }
            }
            $articulos_pedido = [];
            $clientes_facturas = [];
            foreach ($albaranes as $key => $albaran) {
                $clientes_facturas[] = $clientes_model->read($albaran->getCod_cliente());
            }
            //Pasamos a la vista toda la información que se desea representar
            if (isset($_SESSION['cliente'])) {
                $usuario["cliente"] = $_SESSION['cliente'];
            }
            $variables = array();
            
            $variables["error"] = $error;
            $variables["success"] = $success;
            $usuario["usuario"] = $_SESSION["usuario"];
            $variables["articulos_pedido"] = $articulos_pedido;
            $variables['albaranes'] = $albaranes;
            $variables["albaranes"] = $albaranes;
            $variables["cliente"] = $clientes_model->read($id_cliente);
            $clientes = array();
            $clientes["cliente"] = $clientes_model->read($id_cliente);
            $clientes["clientes"] = $clientes_model->readAll();
            //Pasamos a la vista toda la información que se desea representar
            $this->view->show("cabecera.php");
            $this->view->show("plantilla_header.php", $usuario);
            $this->view->show(RUTA_VISTAS . "listar_header.php");
            $this->view->show(RUTA_VISTAS . "select_cliente.php", $clientes);
            $this->view->show(RUTA_VISTAS . "alta.php", $variables);
            $this->view->show("plantilla_pie.php");
            $this->view->show("pie.php", $usuario);
        } else {

            //Pasamos a la vista toda la información que se desea representar
            $variables['clientes'] = $clientes_model->readAll();
            $usuario["usuario"] = $_SESSION["usuario"];
            $usuario['cliente'] = $_SESSION['cliente'];
            //Pasamos a la vista toda la información que se desea representar
            $this->view->show("cabecera.php");
            $this->view->show("plantilla_header.php", $usuario);
            $this->view->show(RUTA_VISTAS . "listar_header.php");
            $this->view->show(RUTA_VISTAS . "select_cliente.php", $variables);
            $this->view->show("plantilla_pie.php");
            $this->view->show("pie.php", $usuario);
        }
    }
    public function listar()
    {
        //Creamos una instancia de nuestro "modelo"
        $facturas_model = new Facturas_Model();
        $cliente_model = new Clientes_Model();

        session_start();
        //Le pedimos al modelo todos los Piezas
        $facturas = $facturas_model->readAll();
        $clientes_facturas = [];
        foreach ($facturas as $key => $factura) {
            $clientes_facturas[] = $cliente_model->read($factura->getCod_cliente());
        }
        //Pasamos a la vista toda la información que se desea representar
        if (isset($_SESSION['cliente'])) {
            $usuario["cliente"] = $_SESSION['cliente'];
        }
        $variables = array();
        $usuario["usuario"] = $_SESSION["usuario"];
        $variables['facturas'] = $facturas;
        $variables['clientes_facturas'] = $clientes_facturas;

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
        $facturas_model = new facturas_Model();
        $cliente_model = new Clientes_Model();
        session_start();

        $campo = (isset($_REQUEST['campo'])) ? $_REQUEST['campo'] : "cod_factura";
        $filtro = (isset($_REQUEST['filtro'])) ? $_REQUEST['filtro'] : "contiene";
        $texto = (isset($_REQUEST['texto'])) ? $_REQUEST['texto'] : "%";

        //Le pedimos al modelo todos los Piezas
        $facturas = $facturas_model->filterBy($campo, $filtro, $texto);
        $clientes_facturas = [];
        foreach ($facturas as $key => $factura) {
            $clientes_facturas[] = $cliente_model->read($factura->getCod_cliente());
        }
        //Pasamos a la vista toda la información que se desea representar
        if (isset($_SESSION['cliente'])) {
            $usuario["cliente"] = $_SESSION['cliente'];
        }
        $varVistaFormFiltrar = ["campo" => $campo, "filtro" => $filtro, "texto" => $texto];
        $varVistaListar['facturas'] = $facturas;
        $usuario["usuario"] = $_SESSION["usuario"];
        $varVistaListar['clientes_facturas'] = $clientes_facturas;
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
        $facturas_model = new Facturas_Model();
        $lin_fac_model = new Lineas_facturas_Model();
        $articulo_model = new Articulos_Model();
        $clientes_model = new Clientes_Model();
        //Le pide al modelo LA pedido con id = $id
        $factura = $facturas_model->read($id);
        $lineas_factura = $lin_fac_model->filterBy("cod_factura", "igual", $id);

        if ($factura === null) {
            die("Identificador de albaran incorrecto");
        }
        $articulos_albaran = [];

        foreach ($lineas_factura as $key => $lin_fac) {
            $articulo = $articulo_model->read($lin_fac->getCod_articulo());
            $articulos_albaran[] = $articulo;

        }

        if (isset($_SESSION['cliente'])) {
            $usuario["cliente"] = $_SESSION['cliente'];
        }
        $variables = array();
        $usuario["usuario"] = $_SESSION["usuario"];
        $variables["cliente"] = $clientes_model->read($factura->getCod_cliente());
        $variables["lineas_facturas"] = $lineas_factura;
        $variables["articulos_albaran"] = $articulos_albaran;
        $variables['factura'] = $factura;

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
        $lineas_facturas_model = new Lineas_facturas_Model();
        $cliente_model = new Clientes_Model();
        $facturas_model = new Facturas_Model();

        session_start();
        $mensaje = "";
        $error = "";
        if (!isset($_REQUEST["id"])) {
            die("Error, falta el id del albarán a borrar");
        }
        $id = $_REQUEST["id"];
        //accedo al modelo y opero
        $factura = $facturas_model->read($id);
        $lineas_factura = $lineas_facturas_model->filterBy("cod_factura", "igual", $factura->getCod_factura());
        foreach ($lineas_factura as $key => $lin_fac) {
            $lineas_facturas_model->delete($lin_fac->getNum_linea_factura(), $factura->getCod_factura());
        }
        if ($facturas_model->delete($id)) {
            $mensaje = "La factura se ha eliminado correctamente";
        } else {
            $error = "Ha ocurrido un problema";
        }

        //Paso a la vista el resultado
        if (isset($_SESSION['cliente'])) {
            $usuario["cliente"] = $_SESSION['cliente'];
        }
        $facturas = $facturas_model->readAll();
        $clientes_facturas = [];
        foreach ($facturas as $key => $factura) {
            $clientes_facturas[] = $cliente_model->read($factura->getCod_cliente());
        }
        $variables["success"] = $mensaje;
        $variables["error"] = $error;
        $variables["facturas"] = $facturas;
        $usuario["usuario"] = $_SESSION["usuario"];
        $variables['clientes_facturas'] = $clientes_facturas;
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
        $facturas_model = new Facturas_Model();
        $lin_fac_model = new Lineas_facturas_Model();
        $articulo_model = new Articulos_Model();
        $clientes_model = new Clientes_Model();

        if (isset($_REQUEST["id"])) {
            $id = $_REQUEST["id"];
            $factura = $facturas_model->read($id);
        } elseif (isset($_POST['cod_factura'])) {
            $id = $_REQUEST["cod_factura"];
            $factura = $facturas_model->read($_POST['cod_factura']);
            if($_POST["descuento"] != $factura->getDescuento_factura()){
                $factura->setDescuento_factura($_POST["descuento"]);
                if($facturas_model->update($factura)){
                    $success = "Factura modificada correctamente";
                } else {
                    $error="Ha ocurrido un error";
                }
            }
            
            
        }

        //Le pide al modelo LA pedido con id = $id

        $lineas_factura = $lin_fac_model->filterBy("cod_factura", "igual", $id);

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
        $variables["lineas_facturas"] = $lineas_factura;
        $variables['articulos'] = $articulos;
        $variables["articulos_albaran"] = $articulos_albaran;
        $variables['factura'] = $factura;
        $variables["cliente"] = $clientes_model->read($factura->getCod_cliente());
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
    public function imprimir(){
        if (!isset($_REQUEST['id'])) {
            die("No has especificado un identificador de pedido.");
        }

        $id = $_REQUEST['id'];
        session_start();
        //Creamos una instancia de nuestro "modelo"
        $facturas_model = new Facturas_Model();
        $lin_fac_model = new Lineas_facturas_Model();
        $articulo_model = new Articulos_Model();
        $clientes_model = new Clientes_Model();
        //Le pide al modelo LA pedido con id = $id
        $factura = $facturas_model->read($id);
        $lineas_factura = $lin_fac_model->filterBy("cod_factura", "igual", $id);

        if ($factura === null) {
            die("Identificador de albaran incorrecto");
        }
        $articulos_albaran = [];

        foreach ($lineas_factura as $key => $lin_fac) {
            $articulo = $articulo_model->read($lin_fac->getCod_articulo());
            $articulos_albaran[] = $articulo;

        }

        if (isset($_SESSION['cliente'])) {
            $usuario["cliente"] = $_SESSION['cliente'];
        }
        $variables = array();
        $usuario["usuario"] = $_SESSION["usuario"];
        $variables["cliente"] = $clientes_model->read($factura->getCod_cliente());
        $variables["lineas_facturas"] = $lineas_factura;
        $variables["articulos_factura"] = $articulos_albaran;
        $variables['factura'] = $factura;

        //Finalmente presentamos nuestra plantilla
        $this->view->show(RUTA_VISTAS . "imprimir.php", $variables); 
    }
}
