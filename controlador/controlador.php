<?php
session_start();
/**
 * Incluimos el modelo para poder acceder a su clase y a los métodos que implementa
 */
require_once 'modelo/modelo.php';

/**
 * Clase controlador que será la encargada de obtener, para cada tarea, los datos
 * necesarios de la base de datos, y posteriormente, tras su proceso de elaboración,
 * enviarlos a la vista para su visualización
 */
class controlador
{

    // El atributo $modelo es de la 'clase modelo' y será a través del que podremos
    // acceder a los datos y las operaciones de la base de datos desde el controlador
    private $modelo;
    // El atributo $mensajes se utiliza para almacenar los mensajes generados en las tareas,
    //que serán posteriormente transmitidos a la vista para su visualización
    private $mensajes;

    /**
     * Constructor que crea automáticamente un objeto modelo en el controlador e
     * inicializa los mensajes a vacío
     */
    public function __construct()
    {
        $this->modelo = new modelo();
        $this->mensajes = [];
    }

    /**
     * Método que envía al usuario a la página de inicio del sitio y le asigna
     * el título de manera dinámica
     */
    public function index()
    {
        // Almacenamos en el array 'parametros[]'los valores que vamos a mostrar en la vista
        $parametros = [
            "tituloventana" => "MyBlog PHP",
            "datos" => null,
            "mensajes" => [],
        ];
        //Comprobar usuario logueado antes de hacer la consulta especifica a cada usuario
        if (isset($_SESSION['user'])) { //Compruebo que se haya logueado un usuario
            if ($_SESSION['rol'] == 'admin') { //Si es admin, mostraré las tareass paginadas de admin
                $resultModelo = $this->modelo->listado();
            } elseif ($_SESSION['rol'] == 'user') { //Si es user normal, mostraré las tareass paginadas de user normal
                $resultModelo = $this->modelo->listadoxuser($_SESSION['iduser']);
            }
        } else { //Si no, muestro la pagina por defecto
            // Incluimos la vista en la que visualizaremos los datos o un mensaje de error
            $resultModelo = $this->modelo->listado();
        }
        // Si la consulta se realizó correctamente transferimos los datos obtenidos
        // de la consulta del modelo ($resultModelo["datos"]) a nuestro array parámetros
        // ($parametros["datos"]), que será el que le pasaremos a la vista para visualizarlos
        if ($resultModelo["correcto"]) {
            $parametros["datos"] = $resultModelo["datos"];
            //Definimos el mensaje para el alert de la vista de que todo fue correctamente
            $this->mensajes[] = [
                "tipo" => "success",
                "mensaje" => "El listado se realizó correctamente",
            ];
        } else {
            //Definimos el mensaje para el alert de la vista de que se produjeron errores al realizar el listado
            $this->mensajes[] = [
                "tipo" => "danger",
                "mensaje" => "El listado no pudo realizarse correctamente!! :( <br/>({$resultModelo["error"]})",
            ];
        }
        //Asignamos al campo 'mensajes' del array de parámetros el valor del atributo
        //'mensaje', que recoge cómo finalizó la operación:
        $parametros["mensajes"] = $this->mensajes;
        if (isset($_SESSION['user'])) { //Compruebo que se haya logueado un usuario
            if ($_SESSION['rol'] == 'admin') { //Si es admin, mostraré las tareass paginadas de admin
                include_once 'vistas/administrador.php';
            } elseif ($_SESSION['rol'] == 'user') { //Si es user normal, mostraré las tareass paginadas de user normal
                include_once 'vistas/usuario.php';
            }
        } else { //Si no, muestro la pagina por defecto
            // Incluimos la vista en la que visualizaremos los datos o un mensaje de error
            include_once 'vistas/inicio.php';
        }
    }

    public function login($user, $pass)
    {
        // Obtenemos los datos del usuario que pretende loguearse
        $datosuser = $this->modelo->login($user);
        if ($datosuser['correcto']) {
            if ($datosuser['datos']['nick'] == $user && $datosuser['datos']['contrasenia'] == $pass) {
                //session_start();
                $_SESSION['user'] = $user;
                $_SESSION['iduser'] = $datosuser['datos']['iduser'];
                $_SESSION['rol'] = $datosuser['datos']['rol'];
                $_SESSION['avatar'] = $datosuser['datos']['avatar'];
            } else {
                header("Location: ../vistas/login.php?error=crednovalidas");
            }
            $this->userlogued();
        } else {
            $this->mensajes[] = [
                "tipo" => "danger",
                "mensaje" => "Error!! No se pudieron obtener los datos del usuario!! :( <br/> ({$datosuser["error"]})",
            ];
        }
    }

    public function userlogued()
    {
        // Almacenamos en el array 'parametros[]'los valores que vamos a mostrar en la vista
        $parametros = [
            "tituloventana" => "MyBlog PHP - " . $_SESSION['user'] . " (" . $_SESSION['rol'] . ")",
            "datos" => null,
            "mensajes" => [],
        ];
        // Realizamos la consulta y almacenmos los resultados en la variable $resultModelo
        if (isset($_SESSION['user']) && $_SESSION['rol'] == "admin") {
            $resultModelo = $this->modelo->listado();
        } elseif (isset($_SESSION['user']) && $_SESSION['rol'] == "user") {
            $resultModelo = $this->modelo->listadoxuser($_SESSION['iduser']);
        }
        // Si la consulta se realizó correctamente transferimos los datos obtenidos
        // de la consulta del modelo ($resultModelo["datos"]) a nuestro array parámetros
        // ($parametros["datos"]), que será el que le pasaremos a la vista para visualizarlos
        if ($resultModelo["correcto"]) {
            $parametros["datos"] = $resultModelo["datos"];
            //Definimos el mensaje para el alert de la vista de que todo fue correctamente
            $this->mensajes[] = [
                "tipo" => "success",
                "mensaje" => "La consulta realizó correctamente!! :)",
            ];
        } else {
            //Definimos el mensaje para el alert de la vista de que se produjeron errores al realizar el listado
            $this->mensajes[] = [
                "tipo" => "danger",
                "mensaje" => "Error!! La consulta no pudo realizarse correctamente!! :( <br/>({$resultModelo["error"]})",
            ];
        }
        //Asignamos al campo 'mensajes' del array de parámetros el valor del atributo
        //'mensaje', que recoge cómo finalizó la operación:
        $parametros['mensajes'] = $this->mensajes;
        // Incluimos la vista en la que visualizaremos los datos o un mensaje de error
        if (isset($_SESSION['user']) && $_SESSION['rol'] == "admin") {
            include_once 'vistas/administrador.php';
        } elseif (isset($_SESSION['user']) && $_SESSION['rol'] == "user") {
            include_once 'vistas/usuario.php';
        }
    }

    public function logout()
    {
        //session_start();
        unset($_SESSION['iduser']);
        unset($_SESSION['user']);
        unset($_SESSION['rol']);

        $this->index();
    }

    public function addtareas()
    {
        //array que almacenara mensajes de error
        $error = array();

        // Al pulsar el botón Enviar se obtienen los datos enviados del formulario en sus variables POST
        if (isset($_POST) && !empty($_POST) && isset($_POST['Enviar'])) {
            //var_dump($_POST);
            //Guardamos en las variables los datos introducidos en los campos que pasaremos por el POST
            $titulo = $_POST['titulo'];
            $imagen = null;
            $fecha = date("Y-m-d H:i:s");
            $descripcion = $_POST['descripcion'];
            $usuario_id = $_SESSION['iduser'];
            $categoria_id = $_POST['categoria'];
            $prioridad = $_POST['prioridad'];
            $lugar = $_POST['lugar'];
            //Comprobamos  validamos el campo imagen
            if (isset($_FILES['imagen']) && (!empty($_FILES['imagen']['tmp_name']))) {
                if (!is_dir("fotos")) {
                    $dir = mkdir("fotos", 0777, true);
                } else {
                    $dir = true;
                }
                if ($dir) {
                    $nombrefichimg = time() . "-" . $_FILES['imagen']['name'];
                    $movfichimg = move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/" . $nombrefichimg);
                    $imagen = $nombrefichimg;
                    if ($movfichimg) {
                        $imagencargada = true;
                    } else {
                        $imagencargada = false;
                        $this->mensajes[] = [
                            'tipo' => "danger",
                            'mensaje' => "Error: La imagen no se cargó correctamente! :(",
                        ];
                        $error['imagen'] = "Error: La imagen no se cargó correctamente! :(";
                    }
                }
            }
            //var_dump($error);
            // Si no se produjeron errores...
            if (count($error) == 0) {
                //var_dump($usuario_id);
                //Como no hay ningún error, hacemos la consulta y le pasamos los datos que queremos insertar
                //Guardamos el resultado de la consulta en la variable $resultModelo
                $resultModelo = $this->modelo->addtareas([
                    'usuario_id' => $usuario_id,
                    'categoria_id' => $categoria_id,
                    'titulo' => $titulo,
                    "imagen" => $imagen,
                    'descripcion' => $descripcion,
                    'prioridad' => $prioridad,
                    'lugar' => $lugar,
                    'fecha' => $fecha,
                ]);
                //var_dump($resultModelo);
                if ($resultModelo['correcto']) { //Si todo va bien :)
                    $this->mensajes[] = [
                        'tipo' => "success",
                        'mensaje' => "La tareas se registró correctamente!! :)",
                    ];
                } else { //Si va mal :(
                    $this->mensajes[] = [
                        'tipo' => "danger",
                        'mensaje' => "Error!! La tareas no pudo registrarse!! :( <br />({$resultModelo["error"]})",
                    ];
                }
            } else { //Si hay errores...
                $this->mensajes[] = [
                    'tipo' => "danger",
                    'mensaje' => "Datos de registro de tareass erróneos!! :(",
                ];
            }
        }
        /**
         * Array de parámetros que se puede utilizar para almacenar y pasar información y 
         * mensajes entre diferentes partes de una aplicación.
         */
        $parametros = [
            'datos' => [
                'titulo' => isset($titulo) ? $titulo : "",
                'descripcion' => isset($descripcion) ? $descripcion : "",
                'imagen' => isset($imagen) ? $imagen : "",
                'prioridad' => isset($prioridad) ? $prioridad : "",
                'lugar' => isset($lugar) ? $lugar : "",
                'fecha' => isset($fecha) ? $fecha : "",
            ],
            'mensajes' => $this->mensajes,
        ];
        //var_dump($parametros['datos']);
        include_once 'vistas/addtareas.php';
    }

    public function deltareas()
    {
        if (isset($_GET['id']) && (is_numeric($_GET['id']))) {
            $id = $_GET['id'];
            $resultModelo = $this->modelo->deltareas($id);
            //var_dump($resultModelo);
            if ($resultModelo['correcto']) :
                $this->mensajes[] = [
                    'tipo' => "success",
                    'mensaje' => "Se eliminó correctamente la tareas $id :)",
                ];
            else :
                $this->mensajes[] = [
                    'tipo' => "danger",
                    'mensaje' => "Error!! La eliminación de la tareas no se realizó correctamente!! :( <br/>({$resultModelo["error"]})",
                ];
            endif;
        } else {
            $this->mensajes[] = [
                'tipo' => "danger",
                'mensaje' => "Error!! No se pudo acceder al identificador de la tareas a eliminar!! :(",
            ];
        }
        //Relizamos el listado de los usuarios
        $this->userlogued();
    }

    public function acttareas()
    {
        $errores = array();
        // Valores iniciales de las variables del formulario
        $valtitulo = "";
        $valdescripcion = "";
        $valfecha = "";
        $valimagen = "";
        $valprioridad = "";
        $vallugar = "";

        // Detectamos si se ha pulsado el botón 'actualizar' del formulario de edición
        if (isset($_POST['actualizar'])) {

            $ident = $_POST['ident'];
            $nuevoidcategoria = $_POST['nuevacategoria'];
            $nuevonombrecategoria = $_POST['nombrecat'];
            $nuevotitulo = $_POST['nuevotitulo'];
            $nuevadescripcion = $_POST['nuevadescripcion'];
            $fecha = $_POST['fecha'];
            $nuevaimagen = $_FILES['imagen'];
            $nuevaprioridad = $_POST['nuevaprioridad'];
            $nuevalugar = $_POST['nuevolugar'];
            //var_dump($_POST);
            //var_dump($_FILES);

            $imagen = null;

            //Gestión de la imagen de la tareas
            if (!is_dir("fotos")) {
                $carpeta = mkdir("fotos", 0777, true);
            } else {
                $carpeta = true;
            }

            if ($carpeta) {
                $nombreImagen = $_FILES['imagen']['name'];
                $moverImagen = move_uploaded_file($_FILES['imagen']['tmp_name'], "fotos/" . $nombreImagen);
                $imagen = $nombreImagen;

                if (!$moverImagen) {
                    $errores['imagen'] = "Error al cargar la imagen!! :(";
                }
            }

            $nuevaimagen = $imagen;

            if (count($errores) == 0) {
                $resultModelo = $this->modelo->acttareas([
                    'ident' => $ident,
                    'idCategoria' => $nuevoidcategoria,
                    'titulo' => $nuevotitulo,
                    'imagen' => $nuevaimagen,
                    'descripcion' => $nuevadescripcion,
                    'prioridad' => $nuevaprioridad,
                    'lugar' => $nuevalugar
                ]);
                //var_dump($resultModelo);
                //Controlamos si la operación se realizó correctamente
                if ($resultModelo['correcto']) :
                    $this->mensajes[] = [
                        'tipo' => "success",
                        'mensaje' => "La tareas se actualizó correctamente!! :)",
                    ];
                else :
                    $this->mensajes[] = [
                        'tipo' => "danger",
                        'mensaje' => "La tareas no pudo actualizarse!! :( <br/>({$resultModelo["error"]})",
                    ];
                endif;
            } else {
                $this->mensajes[] = [
                    'tipo' => "danger",
                    'mensaje' => "Datos de edición de tareas erróneos!! :(",
                ];
            }

            // Valores para mostrar en el formulario
            $validtareas = $ident;
            $validcategoria = $nuevoidcategoria;
            $valnombrecategoria = $nuevonombrecategoria;
            $valfecha = $fecha;
            $valtitulo = $nuevotitulo;
            $valimagen = $nuevaimagen;
            $valdescripcion = $nuevadescripcion;
        } else { //Si no hemos pulsado el boton actualizar, mostramos los datos que tenemos de dicha tareas
            if (isset($_GET['id']) && (is_numeric($_GET['id']))) {
                $id = $_GET['id'];
                //Ejecutamos la consulta para obtener una tareas por su id
                $resultModelo = $this->modelo->listadotareas($id);
                //se generan mensajes
                if ($resultModelo['correcto']) {
                    $this->mensajes[] = [
                        "tipo" => "success",
                        "mensaje" => "Los datos de la tareas se obtuvieron correctamente!! :)",
                    ];

                    $validtareas = $resultModelo['datos']['ident'];
                    $validcategoria = $resultModelo['datos']['idcat'];
                    $valnombrecategoria = $resultModelo['datos']['nombrecat'];
                    $valfecha = $resultModelo['datos']['fecha'];
                    $valtitulo = $resultModelo['datos']['titulo'];
                    $valimagen = $resultModelo['datos']['imagen'];
                    $valdescripcion = $resultModelo['datos']['descripcion'];
                } else {
                    $this->mensajes[] = [
                        'tipo' => "danger",
                        'mensaje' => "No se pudieron obtener los datos de la tareas!! :( <br/>({$resultModelo["error"]})",
                    ];
                }
            }
        }
        //Preparamos un array con todos los valores que tendremos que rellenar en
        //la vista acttareas: título de la página y campos del formulario
        $parametros = [
            'tituloventana' => "Blog con PHP",
            'datos' => [
                'ident' => $validtareas,
                'fecha' => $valfecha,
                'idCategoria' => $validcategoria,
                'nombrecat' => $valnombrecategoria,
                'titulo' => $valtitulo,
                'imagen' => $valimagen,
                'descripcion' => $valdescripcion,
            ],
            'mensajes' => $this->mensajes,
        ];
        //Mostramos la vista acttareas
        include_once 'vistas/acttareas.php';
    }

    public function detalletareas()
    {
        if (isset($_GET['id']) && (is_numeric($_GET['id']))) {
            $id = $_GET['id'];
            $resultModelo = $this->modelo->listadotareas($id);
            //var_dump($resultModelo);

            if ($resultModelo['correcto']) :
                $parametros = [
                    'tituloventana' => "Blog con PHP",
                    'datos' => [
                        'ident' => $resultModelo['datos']['ident'],
                        'fecha' => $resultModelo['datos']['fecha'],
                        'idCategoria' => $resultModelo['datos']['idCategoria'],
                        'nombrecat' => $resultModelo['datos']['nombrecat'],
                        'titulo' => $resultModelo['datos']['titulo'],
                        'imagen' => $resultModelo['datos']['imagen'],
                        'descripcion' => $resultModelo['datos']['descripcion'],
                        'nick' => $resultModelo['datos']['nick'],
                        'nombre' => $resultModelo['datos']['nombre'],
                        'apellidos' => $resultModelo['datos']['apellidos'],
                        'email' => $resultModelo['datos']['email'],
                        'avatar' => $resultModelo['datos']['avatar'],
                        'rol' => $resultModelo['datos']['rol'],
                    ],
                    'mensajes' => [
                        'tipo' => "success",
                        'mensaje' => "Se obtuvieron correctamente los datos de la tareas $id :)",
                    ],
                ];
            else :
                $parametros = [
                    'tituloventana' => "Blog con PHP",
                    'mensajes' => [
                        'tipo' => "danger",
                        'mensaje' => "Error!! No se pudieron obtener los datos de la tareas $id :( <br/>({$resultModelo["error"]})",
                    ],
                ];
            endif;
        } else {
            $parametros = [
                'tituloventana' => "Blog con PHP",
                'mensajes' => [
                    'tipo' => "danger",
                    'mensaje' => "Error!! No se pudo acceder a la tareas :(",
                ],
            ];
        }

        //var_dump($parametros);

        //Mostramos la vista detalletareas
        include_once 'vistas/detalletareas.php';
    }

    public function listadolog()
    {
        $parametrosVistas = [
            'datos' => [],
            'tipo' => null,
            'mensaje' => null,
        ];
        if (isset($_SESSION['user'])) { //Compruebo que se haya logueado un usuario
            if ($_SESSION['rol'] == 'admin') { //Si es admin, mostraré las tareass paginadas de admin
                $resultModelo = $this->modelo->listado_logs();
            }
        }

        if ($resultModelo['correcto']) {
            $parametrosVistas['datos'] = $resultModelo['datos'];
            //$parametrosVistas['paginas'] = $resultadoModelo['paginas'];
            $parametrosVistas['tipo'] = 'alert alert-success text-center';
            $parametrosVistas['mensaje'] = 'lectura de log';
        } else {
            $parametrosVistas['tipo'] = 'alert alert-danger text-center';
            $parametrosVistas['mensaje'] = $resultModelo['mensaje'];
        }
        include_once 'vistas/log.php';
    }
}
