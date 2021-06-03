<?php
//Incluye el modelo que corresponde
define("RUTA_VISTAS", "contenido/");
require_once 'models/Login_Model.php';
require_once 'models/Clientes_Model.php';
require_once 'models/Articulos_Model.php';
require_once 'models/Albaranes_Model.php';
require_once 'models/Pedidos_Model.php';
require_once 'models/Facturas_Model.php';
class Login_Controller extends Base_Controller
{
    public function signIn()
    {
        session_start();
        session_destroy();
        $this->view->show("cabecera.php");
        $this->view->show("login.php");
        $this->view->show("pie.php");
    }
    public function comprobarUsuario()
    {

        $login_model = new Login_Model();
        session_start();

        $nick = (isset($_REQUEST['nick'])) ? $_REQUEST['nick'] : "";
        $password = (isset($_REQUEST['password'])) ? $_REQUEST['password'] : "";
        $dataResult = [];
        $usuario = $login_model->signIn($nick, $password);
        if (!is_null($usuario)) {
            $_SESSION["usuario"] = $usuario;
            $dataResult["success"] = true;
        } else {
            $dataResult["success"] = false;
            $dataResult["data"] = [
                'mensaje' => "Usuario o contraseña incorrectos",
                'nick' => $nick,
                'password' => $password
            ];
        }
        echo json_encode($dataResult);
    }
    public function home()
    {
        session_start();
        $clientes_model = new Clientes_Model();
        $articulos_model = new Articulos_Model();
        $pedidos_model = new Pedidos_Model();
        $albaranes_model = new Albaranes_Model();
        $facturas_model = new Facturas_Model();
        $variables = [];
        $variables["clientes"] = count($clientes_model->readALL());
        $variables["articulos"] = count($articulos_model->readALL());
        $variables["pedidos"] = count($pedidos_model->readALL());
        $variables["albaranes"] = count($albaranes_model->readALL());
        $variables["facturas"] = count($facturas_model->readALL());
        $usuario["usuario"] = $_SESSION["usuario"];
        $this->view->show("cabecera.php");
        $this->view->show("plantilla_header.php", $usuario);
        $this->view->show(RUTA_VISTAS . "home.php", $variables);
        $this->view->show("plantilla_pie.php");
        $this->view->show("pie.php");
    }
}
