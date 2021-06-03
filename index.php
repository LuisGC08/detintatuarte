<?php
ini_set("error_log", "php-error.log");

//Incluyo el FrontController
require_once 'core/FrontController.php';

try
{
   
   FrontController::main();
}
catch (Exception $e)
{
   echo $e->getMessage();
}

 ?>
