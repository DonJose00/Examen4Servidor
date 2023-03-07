<?php

/**
 *   Clase 'modelo' que implementa el modelo de nuestra aplicación en una
 * arquitectura MVC. Se encarga de gestionar el acceso a la base de datos
 * en una capa especializada
 */
class modelo
{

    //Atributo que contendrá la referencia a la base de datos
    private $conexion;
    // Parámetros de conexión a la base de datos
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db = "bdlistadotarea";

    /**
     * Constructor de la clase que ejecutará directamente el método 'conectar()'
     */
    public function __construct()
    {
        $this->conectar();
    }

    /**
     * Método que realiza la conexión a la base de datos de usuarios mediante PDO.
     * Devuelve TRUE si se realizó correctamente y FALSE en caso contrario.
     * @return boolean
     */
    public function conectar()
    {
        try {
            $this->conexion = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pass);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return true;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * Función que nos permite conocer si estamos conectados o no a la base de datos.
     * Devuelve TRUE si se realizó correctamente y FALSE en caso contrario.
     * @return boolean
     */
    public function estaConectado()
    {
        if ($this->conexion) :
            return true;
        else :
            return false;
        endif;
    }

    /**
     * Función que realiza el listado de todos los usuarios registrados
     * Devuelve un array asociativo con tres campos:
     * -'correcto': indica si el listado se realizó correctamente o no.
     * -'datos': almacena todos los datos obtenidos de la consulta.
     * -'error': almacena el mensaje asociado a una situación errónea (excepción)
     * @return type
     */

    public function login($user)
    {
        $resultmodelo = [
            "correcto" => false,
            "datos" => null,
            "error" => null,
        ];
        //Realizamos la consulta...
        try { //Definimos la instrucción SQL para obtener todos los datos del usuario que desea loguearse
            $sql = "SELECT * FROM usuarios where nick = '$user'";
            // Hacemos directamente la consulta al no tener parámetros
            $resultsquery = $this->conexion->query($sql);
            //Supervisamos si se obtuvieron los datos correctamente...
            if ($resultsquery) {
                $resultmodelo["correcto"] = true;
                $resultmodelo["datos"] = $resultsquery->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $ex) {
            $resultmodelo["error"] = $ex->getMessage();
        }

        return $resultmodelo;
    }

    // Obtiene el listado general de usuarios registrados en la tabla
    //Listado por defecto y administrador, muestra todas las tareas de todos los usuarios
    public function listado()
    {
        $resultmodelo = [
            "correcto" => false,
            "datos" => null,
            "error" => null,
        ];
        //Realizamos la consulta...
        try { //Definimos la instrucción SQL
            $limit = 3; //Cuántos productos mostrar por página
            $pagina = 1; //Paginas que voy a tener por defecto
            if (isset($_GET["pagina"])) { //Si recibimos el dato de la pagina
                $pagina = $_GET["pagina"]; //Lo guardamos en la variable $pagina
            }
            //El offset es saltar X productos que viene dado por multiplicar la página - 1 * los productos por página
            $offset = ($pagina - 1) * $limit;
            $numtareas = $this->conexion->query("SELECT COUNT(*) FROM tareas");
            if ($numtareas) {
                $total = $numtareas->fetchColumn();
                $resultmodelo['paginas'] = ceil($total / $limit); //Si tenemos 15 tareas / 3 productos por pagina = 5 paginas
            }
            $sql = "SELECT * FROM (tareas LEFT JOIN  usuarios ON usuarios.iduser=tareas.idUsuario) LEFT JOIN categoria ON tareas.idCategoria=categoria.idcat ORDER BY TIME(tareas.fecha) ASC LIMIT $limit OFFSET $offset";
            // Hacemos directamente la consulta al no tener parámetros
            $resultsquery = $this->conexion->query($sql);
            //Supervisamos si el listado se realizó correctamente...
            if ($resultsquery) :
                $resultmodelo["correcto"] = true;
                $resultmodelo["datos"] = $resultsquery->fetchAll(PDO::FETCH_ASSOC);
            endif; // o no :(
        } catch (PDOException $ex) {
            $resultmodelo["error"] = $ex->getMessage();
        }
        return $resultmodelo;
    }
    //Obtiene los datos del usuario cuyo id coincida con el que se le pasa como parámetro
    //Para filtrar por usuario y así poder listar correctamente.
    public function listadoxuser($id)
    {
        $resultmodelo = [
            "correcto" => false,
            "datos" => null,
            "error" => null,
        ];
        //Realizamos la consulta...
        try { //Definimos la instrucción SQL
            # Cuántos productos mostrar por página
            $limit = 3;
            $pagina = 1;
            if (isset($_GET["pagina"])) {
                $pagina = $_GET["pagina"];
            }
            # El offset es saltar X productos que viene dado por multiplicar la página - 1 * los productos por página
            $offset = ($pagina - 1) * $limit;
            $numtareas = $this->conexion->query("SELECT COUNT(*) FROM tareas WHERE idUsuario = $id ");
            if ($numtareas) {
                $total = $numtareas->fetchColumn();
                $resultmodelo['paginas'] = ceil($total / $limit); //Si tenemos 15 tareas / 3 productos por pagina = 5 paginas
            }
            $sql = "SELECT * FROM (tareas
                      LEFT JOIN usuarios ON usuarios.iduser=tareas.idUsuario)
                      LEFT JOIN categoria ON tareas.idCategoria=categoria.idcat
                        WHERE tareas.idUsuario IN (SELECT iduser FROM usuarios WHERE rol='user')
                              LIMIT $limit OFFSET $offset";
            // Hacemos directamente la consulta al no tener parámetros
            $resultsquery = $this->conexion->query($sql);
            //Supervisamos si el listado se realizó correctamente...
            if ($resultsquery) {
                $resultmodelo["correcto"] = true;
                $resultmodelo["datos"] = $resultsquery->fetchAll(PDO::FETCH_ASSOC);
            }
            // o no :(
        } catch (PDOException $ex) {
            $resultmodelo["error"] = $ex->getMessage();
        }
        return $resultmodelo;
    }

    //Obtiene los datos de la tareas cuyo id coincida con el que se le pasa como parámetro
    //Cuando pulsamos en actualizar tareas, nos hará la consulta de los datos de dicha tareas solamente.
    //Para que podamos ver los datos en sus respectivos campos y así saber que queremos cambiar.
    public function listadotareas($id)
    {
        $resultmodelo = [
            "correcto" => false,
            "datos" => null,
            "error" => null,
        ];
        //Realizamos la consulta...
        try { //Definimos la instrucción SQL
            $sql = "SELECT * FROM (tareas LEFT JOIN  usuarios ON usuarios.iduser=tareas.idUsuario) LEFT JOIN categoria ON tareas.idCategoria=categoria.idcat WHERE ident=$id;";
            // Hacemos directamente la consulta al no tener parámetros
            $resultsquery = $this->conexion->query($sql);
            //Supervisamos si el listado se realizó correctamente...
            if ($resultsquery) {
                $resultmodelo['correcto'] = true;
                $resultmodelo['datos'] = $resultsquery->fetch(PDO::FETCH_ASSOC);
            }
            // o no :(
        } catch (PDOException $ex) {
            $resultmodelo['error'] = $ex->getMessage();
        }

        return $resultmodelo;
    }
    //Obtiene los datos del usuario cuyo id coincida con el que se le pasa como parámetro
    public function listadocategorias()
    {
        $resultmodelo = [
            "correcto" => false,
            "datos" => null,
            "error" => null,
        ];
        //Realizamos la consulta...
        try { //Definimos la instrucción SQL
            $sql = "SELECT * FROM categoria;";
            // Hacemos directamente la consulta al no tener parámetros
            $resultsquery = $this->conexion->query($sql);
            //Supervisamos si la inserción se realizó correctamente...
            if ($resultsquery) {
                $resultmodelo["correcto"] = true;
                $resultmodelo["datos"] = $resultsquery->fetchAll(PDO::FETCH_ASSOC);
            }
            // o no :(
        } catch (PDOException $ex) {
            $resultmodelo["error"] = $ex->getMessage();
        }

        return $resultmodelo;
    }

    public function addtareas($datos)
    {
        echo "addtareas:O";
        //var_dump($datos);
        //variable procedimiento almacenado
        $operacion = "Se ha registado una nueva tareas :)!!";

        $resultmodelo = [
            'correcto' => false,
            'error' => null,
        ];

        try {
            // Definición de la instruccion SQL Insert mediante una consulta preparada
            $sql = "INSERT INTO tareas (idUsuario,idCategoria,titulo,imagen,descripcion,prioridad,lugar,fecha) VALUES (:usuario_id, :categoria_id, :titulo, :imagen, :descripcion,:prioridad,:lugar,:fecha)";
            //Prepararamos la consulta
            $query = $this->conexion->prepare($sql);
            //Ejecutamos la consulta haciendo el param-binding
            $query->execute([
                'usuario_id' => $datos['usuario_id'],
                'categoria_id' => $datos['categoria_id'],
                'titulo' => $datos['titulo'],
                'imagen' => $datos['imagen'],
                'descripcion' => $datos['descripcion'],
                'prioridad' => $datos["prioridad"],
                'lugar' => $datos["lugar"],
                'fecha' => $datos["fecha"],
            ]);
            if ($query) {
                $resultmodelo['correcto'] = true;
                //REGISTRO DE LOGS
                // Definición de la instruccion SQL Insert mediante una consulta preparada
                $sql = "INSERT INTO logs(usuarios, fecha, operaciones) VALUES (:usuarios, :fecha, :operaciones)";
                //Prepararamos la consulta
                $query = $this->conexion->prepare($sql);
                //Ejecutamos la consulta haciendo el param-binding
                $query->execute([
                    'usuarios' => $_SESSION['user'], //le asignamos a la variable usuarios que está dentro del value de la sentencia sql el usuario que esté logueado en ese momento
                    'fecha' => $datos["fecha"],
                    'operaciones' => 'Nueva tareas',
                ]);
            }
        } catch (PDOException $ex) {
            $resultmodelo['error'] = $ex->getMessage();
        }
        return $resultmodelo;
    }

    public function deltareas($id)
    {
        $resultmodelo = [
            'correcto' => false,
            'error' => null,
        ];

        if (isset($id) && is_numeric($id)) {
            try {
                //Definimos la consulta
                $sql = "DELETE FROM tareas WHERE ident= :id";
                //Preparamos la consulta
                $query = $this->conexion->prepare($sql);
                //Ejecutamos la consulta
                $query->execute(['id' => $id]);
                //Marcamos que el borrado se realizó correctamente
                if ($query) {
                    $resultmodelo["correcto"] = true;
                    //REGISTRO DE LOGS
                    // Definición de la instruccion SQL Insert mediante una consulta preparada
                    $sql = "INSERT INTO logs(usuarios, fecha, operaciones) VALUES (:usuarios, :fecha, :operaciones)";
                    //Prepararamos la consulta
                    $query = $this->conexion->prepare($sql);
                    //Ejecutamos la consulta haciendo el param-binding
                    $query->execute([
                        'usuarios' => $_SESSION['user'], //le asignamos a la variable usuarios que está dentro del value de la sentencia sql el usuario que esté logueado en ese momento
                        'fecha' => date('Y-m-d H:i:s'),
                        'operaciones' => 'tareas eliminada',
                    ]);
                }
            } catch (PDOException $ex) {
                $resultmodelo['error'] = $ex->getMessage();
            }
        }
        return $resultmodelo;
    }

    public function acttareas($datos)
    {
        $resultmodelo = [
            'correcto' => false,
            'error' => null,
        ];

        try {
            // Definimos la instruccion SQL
            $sql = "UPDATE tareas SET idCategoria= :idCategoria, titulo= :titulo, imagen= :imagen, descripcion= :descripcion, prioridad= :prioridad, lugar= :lugar WHERE ident= :ident";
            //Ejecutamos la sentencia
            $query = $this->conexion->prepare($sql);
            $query->execute([
                'ident' => $datos['ident'],
                'idCategoria' => $datos['idCategoria'],
                'titulo' => $datos['titulo'],
                'imagen' => $datos['imagen'],
                'descripcion' => $datos['descripcion'],
                'prioridad' => $datos["prioridad"],
                'lugar' => $datos["lugar"],
            ]);
            if ($query) {
                $resultmodelo['correcto'] = true;
                //REGISTRO DE LOGS
                // Definición de la instruccion SQL Insert mediante una consulta preparada
                $sql = "INSERT INTO logs(usuarios, fecha, operaciones) VALUES (:usuarios, :fecha, :operaciones)";
                //Prepararamos la consulta
                $query = $this->conexion->prepare($sql);
                //Ejecutamos la consulta haciendo el param-binding
                $query->execute([
                    'usuarios' => $_SESSION['user'], //le asignamos a la variable usuarios que está dentro del value de la sentencia sql el usuario que esté logueado en ese momento
                    'fecha' => date('Y-m-d H:i:s'),
                    'operaciones' => 'Actualización de tareas',
                ]);
            }
        } catch (PDOException $ex) {
            $resultmodelo['error'] = $ex->getMessage();
        }
        return $resultmodelo;
    }

    public function listado_logs()
    {
        $resultmodelo = [
            'correcto' => null,
            'mensaje' => null,
            'datos' => [],
        ];

        try {
            $resultsquery = $this->conexion->query("SELECT * FROM logs");
            if ($resultsquery) {
                $resultmodelo['correcto'] = true;
                $resultmodelo['datos'] = $resultsquery->fetchAll(PDO::FETCH_ASSOC); //Guardamos en $parametros['datos'] el resultado recogido del select anterior
                $resultmodelo['mensaje'] = 'La consulta se ha realizado correctamente';
            }
        } catch (PDOException $ex) {
            $resultmodelo['error'] = $ex->getMessage();
        }
        $conexion = null;
        return $resultmodelo;
    }
}
