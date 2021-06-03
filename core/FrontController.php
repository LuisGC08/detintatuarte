<?php
spl_autoload_register(function ($clase) {
    require_once './core/' . $clase . '.php';
});

class FrontController
{
  static function main()
  {
  
    require_once './Config.php'; 

   

    $controller = $config->get('DEFAULT_CONTROLLER');
    if(!empty($_GET['controller']))
      $controller = $_GET['controller'];

    
    $action = $config->get('DEFAULT_ACTION');
    if(!empty($_GET['action']))
      $action = $_GET['action'];

    $controller .= "_controller";

    $controller_path = $config->get('CONTROLLERS_FOLDER') .
                       $controller . '.php';

  
    if (!is_file($controller_path))
      throw new Exception('El controlador no existe ' .
                          $controller_path . ' - 404 not found');

    require_once $controller_path;

   
    if (!is_callable(array($controller, $action)))
      throw new Exception($controller . '->' . $action . ' no existe');

   
    $controller = new $controller();
    $controller->$action();
  }
} 
