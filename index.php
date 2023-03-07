<?php

/**
 * Script que se encarga de redirigir las rutas de los enlaces pulsado en la
 * vista del listado. A él deberá llegar el nombre de la acción y, si fuese
 * necesario, el id del usuario sobre el que se va a realizar dicha acción.
 * Lo hacemos para poder llamar directamente a los métodos del controlador, 
 * de lo contrario tendríamos que especificar los controladores en ficheros 
 * diferentes
 */
require_once 'controlador/controlador.php';

/**
 * La función verifica si se ha enviado un valor para el parámetro "$param" en un formulario HTTP 
 * utilizando el método POST. Si el valor está presente y no está vacío, 
 * la función devuelve verdadero (true). De lo contrario, la función devuelve falso (false).
 */
function checkParam($param)
{
  return isset($_POST[$param]) && !empty($_POST[$param]);
}

//Definimos un objeto controlador
$controlador = new controlador();

if ($_GET && isset($_GET['accion'])) {
  //Sanitizamos los datos que recibamos mediante el GET
  $accion = filter_input(INPUT_GET, "accion", FILTER_SANITIZE_STRING);
  //Verificamos que el objeto controlador que hemos creado implementa el
  //método que le hemos pasado mediante GET
  //var_dump($accion);
  if (method_exists($controlador, $accion)) {//Si ambos parámetros existen, el código verifica si el objeto "controlador" contiene el método indicado por el parámetro "accion"
    if ($accion == "login") {
      if (checkParam("usuario") && checkParam("password")) {//se verifica si existen los parámetros "usuario" y "password"
        $controlador->$accion($_POST['usuario'], $_POST['password']); //Ejecutamos el método login del controlador
      } else {
        $controlador->index();
      }
    } else {// En caso de que el parámetro "accion" sea distinto de "login" se ejecuta el método "accion" del objeto "controlador". 
      $controlador->$accion(); //Se ejecuta la operacion indicada en el parámetro GET 'accion'
    }
  } else {//Si no se cumplen las condiciones, se ejecuta el método "index" del objeto "controlador".
    $controlador->index();
  }
} else {
  $controlador->index();
}
