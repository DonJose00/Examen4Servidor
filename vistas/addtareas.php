<?php
//session_start();
//var_dump($_SESSION['user']);

//Comprobamos que la Sesión está OK
//Si no existe redirigimos a vistas/login.php?error=accesonopermitido
if (!isset($_SESSION['user'])) {
    header("Location: vistas/login.php?error=accesonopermitido");
}
?>
<!-- CÓDIGO HTML -->
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('includes/head.php'); //Añadimos el head 
    ?>
</head>

<body>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xs-3 col-md-6 col-lg-3">
                <h2>Nueva Tarea</h2>
            </div>
        </div>
        <!-- Mensaje al añadir una entrada -->
        <div class="row justify-content-center">
            <div class="col-xs-3 col-md-6 col-lg-3">
                <?php foreach ($parametros["mensajes"] as $mensaje) : ?>
                    <div class="alert alert-<?= $mensaje["tipo"] ?>"><?= $mensaje["mensaje"] ?></div>
                <?php endforeach; ?>
            </div>
        </div>
        <script>
            CKEDITOR.replace('descripcion');
        </script>
        <!-- Formulario donde añadiremos los campos para poder añadir las nuevas entradas a nuestra BD -->
        <div class="row justify-content-center">
            <div class="col-xs-3 col-md-6 col-lg-6">
                <form action="index.php?accion=addtareas" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <label for="titulo">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required />
                    </div></br>
                    <div class="row">
                        <label for="imagen">Imagen</label>
                        <input type="file" class="form-control-file" id="imagen" name="imagen" required />
                    </div></br>
                    <div class="row">
                        <label for="categoria">Categoría</label>
                        <select class="form-control browser-default custom-select" id="categoria" name="categoria">
                            <option selected>Seleccione Categoría </option>
                            <?php
                            $resultModelo = $this->modelo->listadocategorias();
                            $listaCats = $resultModelo['datos'];
                            //var_dump($listaCats);
                            //Creo los options para cada categoria y así mostrarlas en un desplegable
                            foreach ($listaCats as $cat) {
                                echo '<option value="' . $cat['idcat'] . '">' . $cat['nombrecat'] . '</option>';
                            }
                            ?>
                        </select>
                    </div></br>
                    <div class="row">
                        <label for="descripcion">Descripción</label>
                        <textarea class="ckeditor" id="descripcion" name="descripcion" required></textarea>
                    </div></br>
                    <div class="row">
                        <label for="prioridad">Prioridad</label>
                        <input type="text" class="form-control" id="prioridad" name="prioridad" required />
                    </div></br>
                    <div class="row">
                        <label for="lugar">Lugar</label>
                        <input type="text" class="form-control" id="lugar" name="lugar" required />
                    </div></br>
                    <input type="hidden" name="id_user" value="<?php echo $_SESSION['iduser']; ?>">
                    <div class="btn-group" role="group">
                        <button type="submit" class="btn btn-primary" name="Enviar">Enviar</button>
                        <button type="reset" class="btn btn-secondary" name="Limpiar">Limpiar</button>
                        <a type="button" class="btn btn-info" href="index.php?accion=userlogued">Atrás</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>