<?php
class DBManager
{
  // Contenedor de la instancia
  private static $instance;
  private $conexion;

  //creo el constructor
  private function __construct() { 

  }

  // obtengo el objeto de la instancia
  public static function getInstance ()
  {
    if ( is_null ( self::$instance) ) {
       self::$instance = new self();
    }
    return self::$instance;
  }

  public function conectar () {
    if (is_null($this->conexion)) {
      $config = Config::getInstance();
      $host = $config->get('dbhost');
      $dbname = $config->get('dbname');
      $dbuser = $config->get('dbuser');
      $dbpass = $config->get('dbpass');
      $this->conexion = new PDO("mysql:host=$host;dbname=$dbname",
                         $dbuser, $dbpass);

      $this->conexion->setAttribute(PDO::ATTR_ERRMODE,
                        PDO::ERRMODE_EXCEPTION);

     
      $this->conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,
                        PDO::FETCH_ASSOC);
    }
    return $this->conexion;
 }
} 
?>