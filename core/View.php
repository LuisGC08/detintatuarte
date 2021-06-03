<?php
class View
{
   public function show($name, $vars = array())
   {
     

      //Cogemos una instancia de nuestra clase de configuracion.
      $config = Config::getInstance();

      //Creamos la ruta real a la plantilla
      $path = $config->get('VIEWS_FOLDER') . $name;

      //Si no existe el fichero en cuestion, lanzamos una excepción
      if (file_exists($path) == false)
          throw new Exception ('La plantilla '.$path.' no existe');

      //Si hay variables para asignar, las pasamos una a una.
      if(is_array($vars))
      {
          foreach ($vars as $key => $value)
          {
              $$key = $value;
          }
      }
      //Finalmente, incluimos la plantilla.
      include_once($path);
   }
}

?>