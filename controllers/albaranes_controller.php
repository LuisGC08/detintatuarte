<?php
//Incluye el modelo que corresponde
define("RUTA_VISTAS", "contenido/Albaranes/");
require_once 'models/Albaranes_Model.php';
require_once 'models/Pedidos_Model.php';
require_once 'models/Lineas_pedidos_Model.php';
require_once 'models/Lineas_albaran_Model.php';
require_once 'models/Clientes_Model.php';
require_once 'models/Articulos_Model.php';

class Albaranes_Controller extends Base_Controller
{
    public function alta()
    {
        //Creamos una instancia de nuestro "modelo"
        session_start();
        $errores = "";
        $success = "";
        $pedidos_model = new Pedidos_Model();
        $cliente_model = new Clientes_Model();
        $alb_model = new Albaranes_Model();
        $lin_alb_model = new Lineas_albaran_Model();
        $lin_ped_model = new Lineas_pedidos_Model();
        $usuario["usuario"] = $_SESSION["usuario"];
        $usu_gestion = $usuario["usuario"];
        //Recojo datos si hay
        if (isset($_POST['id'])) {
            $albaran = new Albaran();
            $pedido = $pedidos_model->read($_POST['id']);
            $fecha = getdate();
            $albaran->setFecha($fecha["year"] . "-" . $fecha["mon"] . "-" . $fecha["mday"]);
            $albaran->setCod_cliente($pedido->getCod_cliente());
            $alb_model->create($albaran);
            $lineas_pedido = $lin_ped_model->filterBy("cod_pedido", "igual", $pedido->getCod_pedido());
            foreach ($lineas_pedido as $key => $lin_ped) {
                $lin_alb = new Linea_albaran();
                $lin_alb->setNum_linea_albaran($key + 1);
                $lin_alb->setCod_albaran($albaran->getCod_albaran());
                $lin_alb->setPrecio($lin_ped->getPrecio());
                $lin_alb->setCod_articulo($lin_ped->getCod_articulo());
                $lin_alb->setCantidad($lin_ped->getCantidad() - $lin_ped->getCantidadEnAlbaran());
                $lin_alb->setCod_usu_gestion($usu_gestion->getCod_usuario_gestion());
                $lin_alb->setNum_linea_pedido($lin_ped->getNum_linea_pedido());
                $lin_alb->setCod_pedido($lin_ped->getCod_pedido());
                $lin_alb_model->create($lin_alb);
                $cant_ant = $lin_ped->getCantidadEnAlbaran();
                $lin_ped->setCantidadEnAlbaran($lin_alb->getCantidad() + $cant_ant);
                $lin_ped_model->update($lin_ped, $lin_ped->getNum_linea_pedido());
            }
            $success = "Albarán de pedido " . $pedido->getCod_pedido() . " generado correctamente";
        }
        //Creamos una instancia de nuestro "modelo"

        //Le pedimos al modelo todos los Piezas
        $pedidos = $pedidos_model->readAll();
        $clientes_pedidos = [];
        foreach ($pedidos as $key => $pedido) {
            $clientes_pedidos[] = $cliente_model->read($pedido->getCod_cliente());
            $ped_alb = $lin_alb_model->filterBy("cod_pedido", "igual", $pedido->getCod_pedido());
            if (!empty($ped_alb)) {
                $lineas_pedido = $lin_ped_model->filterBy("cod_pedido", "igual", $pedido->getCod_pedido());
                $poneren_alb = false;
                if (!$pedido->getEsEditable()) {
                    $pedidos = array_diff($pedidos, array($pedido));
                }
            }
        }

        //Pasamos a la vista toda la información que se desea representar
        if (isset($_SESSION['cliente'])) {
            $usuario["cliente"] = $_SESSION['cliente'];
        }
        $variables = array();
        $variables["success"] = $success;
        $variables["error"] = $errores;
        $variables['pedidos'] = $pedidos;
        $variables['clientes_pedidos'] = $clientes_pedidos;

        //Finalmente presentamos nuestra plantilla
        $this->view->show("cabecera.php");
        $this->view->show("plantilla_header.php", $usuario);
        $this->view->show(RUTA_VISTAS . "listar_header.php");
        $this->view->show(RUTA_VISTAS . "alta.php", $variables);
        $this->view->show("plantilla_pie.php");
        $this->view->show("pie.php", $usuario);
    }
    public function listar()
    {
        //Creamos una instancia de nuestro "modelo"
        $albaranes_model = new Albaranes_Model();
        $cliente_model = new Clientes_Model();

        session_start();
        //Le pedimos al modelo todos los Piezas
        $albaranes = $albaranes_model->readAll();
        $articulos_pedido = [];
        $clientes_pedidos = [];
        foreach ($albaranes as $key => $albaran) {
            $clientes_pedidos[] = $cliente_model->read($albaran->getCod_cliente());
        }
        //Pasamos a la vista toda la información que se desea representar
        if (isset($_SESSION['cliente'])) {
            $usuario["cliente"] = $_SESSION['cliente'];
        }
        $variables = array();
        $usuario["usuario"] = $_SESSION["usuario"];
        $variables["articulos_pedido"] = $articulos_pedido;
        $variables['albaranes'] = $albaranes;
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
        $albaranes_model = new Albaranes_Model();
        $cliente_model = new Clientes_Model();
        session_start();

        $campo = (isset($_REQUEST['campo'])) ? $_REQUEST['campo'] : "cod_albaran";
        $filtro = (isset($_REQUEST['filtro'])) ? $_REQUEST['filtro'] : "contiene";
        $texto = (isset($_REQUEST['texto'])) ? $_REQUEST['texto'] : "%";

        //Le pedimos al modelo todos los Piezas
        $albaranes = $albaranes_model->filterBy($campo, $filtro, $texto);
        $clientes_pedidos = [];
        foreach ($albaranes as $key => $pedido) {
            $clientes_pedidos[] = $cliente_model->read($pedido->getCod_cliente());
        }
        //Pasamos a la vista toda la información que se desea representar
        if (isset($_SESSION['cliente'])) {
            $usuario["cliente"] = $_SESSION['cliente'];
        }
        $varVistaFormFiltrar = ["campo" => $campo, "filtro" => $filtro, "texto" => $texto];
        $varVistaListar['albaranes'] = $albaranes;
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
        $albaranes_model = new Albaranes_Model();
        $lin_alb_model = new Lineas_albaran_Model();
        $articulo_model = new Articulos_Model();
        $clientes_model = new Clientes_Model();
        //Le pide al modelo LA pedido con id = $id
        $albaran = $albaranes_model->read($id);
        $lineas_albaran = $lin_alb_model->filterBy("cod_albaran", "igual", $id);

        if ($albaran === null) {
            die("Identificador de albaran incorrecto");
        }
        $articulos_albaran = [];
        foreach ($lineas_albaran as $key => $lin_alb) {
            $articulo = $articulo_model->read($lin_alb->getCod_articulo());
            $articulos_albaran[] = $articulo;
        }

        if (isset($_SESSION['cliente'])) {
            $usuario["cliente"] = $_SESSION['cliente'];
        }
        $variables = array();
        $usuario["usuario"] = $_SESSION["usuario"];
        $variables["cliente"] = $clientes_model->read($albaran->getCod_cliente());
        $variables["lineas_albaran"] = $lineas_albaran;
        $variables["articulos_albaran"] = $articulos_albaran;
        $variables['albaran'] = $albaran;

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
        $albaranes_model = new Albaranes_Model();
        $lineas_pedido_model = new Lineas_pedidos_Model();
        $lineas_albaranes_model = new Lineas_albaran_Model();
        $cliente_model = new Clientes_Model();

        session_start();
        $mensaje = "";
        $error = "";
        if (!isset($_REQUEST["id"])) {
            die("Error, falta el id del albarán a borrar");
        }
        $id = $_REQUEST["id"];
        //accedo al modelo y opero
        $albaran = $albaranes_model->read($id);
        $lineas_albaran = $lineas_albaranes_model->filterBy("cod_albaran", "igual", $albaran->getCod_albaran());
        $lineas_pedido = $lineas_pedido_model->filterBy("cod_pedido", "igual", $lineas_albaran[0]->getCod_pedido());
        foreach ($lineas_pedido as $key => $lin_ped) {
            $lin_ped->setCantidadEnAlbaran(0);
            $lineas_pedido_model->update($lin_ped, $lin_ped->getNum_linea_pedido());
        }
        if ($albaran == null) {
            die("No existe el albarán");
        }
        if ($albaranes_model->delete($id)) {
            $mensaje = "El albarán se ha eliminado correctamente";
        } else {
            $error = "Ha ocurrido un problema";
        }

        //Paso a la vista el resultado
        if (isset($_SESSION['cliente'])) {
            $usuario["cliente"] = $_SESSION['cliente'];
        }
        $albaranes = $albaranes_model->readAll();
        $clientes_pedidos = [];
        foreach ($albaranes as $key => $albaran) {
            $clientes_pedidos[] = $cliente_model->read($albaran->getCod_cliente());
        }
        $variables["success"] = $mensaje;
        $variables["error"] = $error;
        $variables["albaranes"] = $albaranes;
        $usuario["usuario"] = $_SESSION["usuario"];
        $variables['clientes_pedidos'] = $clientes_pedidos;
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
        $albaranes_model = new Albaranes_Model();
        $lin_alb_model = new Lineas_albaran_Model();
        $articulo_model = new Articulos_Model();
        $clientes_model = new Clientes_Model();

        if (isset($_REQUEST["id"])) {
            $id = $_REQUEST["id"];
            $albaran = $albaranes_model->read($id);
        } elseif (isset($_POST['cod_albaran'])) {
            $id = $_REQUEST["cod_albaran"];
            $albaran = $albaranes_model->read($_POST['cod_albaran']);
            $lineas_albaran = $lin_alb_model->filterBy("cod_albaran", "igual", $_POST['cod_albaran']);
            for ($i = 0; $i < count($lineas_albaran); $i++) {
                foreach ($lineas_albaran as $key => $linea_albaran) {
                    if (isset($_POST["num" . $i])) {
                        if ($_POST["num" . $i] == $linea_albaran->getNum_linea_albaran()) {
                            if($_POST["IVA" . $i] != $linea_albaran->getIVA() || $_POST["desc" . $i] != $linea_albaran->getDescuento() || $_POST["precio" . $i] != $linea_albaran->getPrecio()){
                                $linea_albaran->setPrecio($_POST["precio" . $i]);
                                $linea_albaran->setIVA($_POST["IVA" . $i]);
                                $linea_albaran->setDescuento($_POST["desc" . $i]);
                                $lin_alb_model->update($linea_albaran, $linea_albaran->getNum_linea_albaran());
                            } 
                            $success = "El albarán ha sido modificado correctamente";
                        }
                    }
                }
            }
        }

        //Le pide al modelo LA pedido con id = $id

        $lineas_albaran = $lin_alb_model->filterBy("cod_albaran", "igual", $id);

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
        $this->view->show(RUTA_VISTAS . "listar_header.php");
        $this->view->show(RUTA_VISTAS . "editar.php", $variables);
        $this->view->show("plantilla_pie.php");
        $this->view->show("pie.php", $usuario);
    }
}
