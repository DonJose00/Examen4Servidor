<?php
//session_start();
//var_dump($_SESSION['user']);

/* if (!isset($_SESSION['user'])) {
    header("Location: vistas/login.php?error=accesonopermitido");
} */
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('includes/head.php'); ?>
</head>

<body>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xs-3 col-md-8 col-lg-3">
                <h2>Detalle de Entrada</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xs-3 col-md-8 col-lg-4">
                <div class="alert alert-<?= $parametros['mensajes']['tipo'] ?>"><?= $parametros['mensajes']['mensaje'] ?></div>
            </div>
        </div>
        <script>
            CKEDITOR.replace('descripcion');
        </script>

        <div class="row justify-content-center">
            <div class="col-xs-3 col-md-6 col-lg-6">
                <?php (isset($_SESSION['user'])) ? $ruta = "index.php?accion=userlogued" : $ruta = "index.php" ?>
                <form action="<?= $ruta ?>" method="post" enctype="multipart/form-data">
                <!-- DETALLE SOBRE LA ENTRADA -->
                    <div class="row">
                        <label for="fecha">Fecha de Publicación</label>
                        <input type="datetime-local" class="form-control" id="fecha" name="fecha" value="<?= $parametros['datos']['fecha'] ?>" readonly="readonly" />
                    </div>
                    <div class=" row">
                        <label for="titulo">Título</label>
                        <input type="text" class="form-control" id="nuevotitulo" name="nuevotitulo" value="<?= $parametros['datos']['titulo'] ?>" readonly="readonly" />
                    </div></br>
                    <div class="row">
                        <?php if ($parametros['datos']['imagen'] != null && $parametros['datos']['imagen'] != "") : ?>
                            </br>Imagen actual: <img src="fotos/<?= $parametros['datos']['imagen'] ?>" width="40" /></br>
                        <?php endif; ?>
                    </div>
                    <div class="row">
                        <label for="categoria">Categoría</label>
                        <input type="text" class="form-control" id="categoria" value="<?= $parametros['datos']['nombrecat'] ?>" readonly="readonly">
                    </div></br>
                    <div class="row">
                        <label for="descripcion">Descripción</label>
                        <textarea class="ckeditor" id="nuevadescripcion" name="nuevadescripcion" readonly="readonly"><?= $parametros['datos']['descripcion'] ?></textarea>
                    </div></br>

                    <!-- DETALLES SOBRE EL USUARIO -->
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="inputNombre">Nombre</label>
                            <input type="text" class="form-control" id="inputNombre" value="<?= $parametros['datos']['nombre'] ?>" readonly="readonly">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputApellidos">Apellidos</label>
                            <input type="text" class="form-control" id="inputApellidos" value="<?= $parametros['datos']['apellidos'] ?>" readonly="readonly">
                        </div>
                        <div class="form-group col-md-5">
                            <label for="inputEmail">Email</label>
                            <input type="email" class="form-control" id="inputEmail" value="<?= $parametros['datos']['email'] ?>" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="inputAvatar">Avatar</label>
                            <img src="fotos/<?= $parametros['datos']['avatar'] ?>" width="100" /></br>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputNick">Nick</label>
                            <input type="text" class="form-control" id="inputNick" value="<?= $parametros['datos']['nick'] ?>" readonly="readonly">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputRol">Rol</label>
                            <input type="text" class="form-control" id="inputRol" value="<?= $parametros['datos']['rol'] ?>" readonly="readonly">
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="btn-group" role="group">
                            <button type="submit" class="btn btn-primary" name="btncerrar">Cerrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>