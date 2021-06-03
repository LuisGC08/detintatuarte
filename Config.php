<?php
require_once 'core/Config.php';

$config = Config::getInstance();


$config->set('CONTROLLERS_FOLDER', 'controllers/');
$config->set('MODELS_FOLDER', 'models/');
$config->set('VIEWS_FOLDER', 'views/');

$config->set('DEFAULT_CONTROLLER', 'login');//ha rellenar

$config->set('DEFAULT_ACTION', 'signIn');//ha rellenar

$config->set('dbhost', 'localhost');
$config->set('dbname', 'deTintaTuArte');//ha rellenar
$config->set('dbuser', 'root'); // esto lo deberíamos cambiar

$config->set('dbpass', '');
?>