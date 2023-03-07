<?php
//session_start();
//var_dump($_SESSION['user']);

if (!isset($_SESSION['user'])) {
    header("Location: vistas/login.php?error=accesonopermitido");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once('includes/head.php'); ?>
</head>

<body>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xs-3 col-md-6 col-lg-3">
                <h2>Editar Entrada</h2>
            </div>
        </div>
        <!-- MENSAJE -->
        <div class="row justify-content-center">
            <div class="col-xs-3 col-md-6 col-lg-3">
                <?php foreach ($parametros['mensajes'] as $mensaje) : ?>
                    <div class="alert alert-<?= $mensaje['tipo'] ?>"><?= $mensaje['mensaje'] ?></div>
                <?php endforeach; ?>
            </div>
        </div>
        <script>
            CKEDITOR.replace('descripcion');
        </script>
        <!-- FORM -->
        <div class="row justify-content-center">
            <div class="col-xs-3 col-md-6 col-lg-6">
                <form action="index.php?accion=acttareas" method="post" enctype="multipart/form-data">
                    <!-- FECHA PUBLICACION -->
                    <div class="row">
                        <label for="fecha">Fecha de Publicación</label>
                        <input type="datetime-local" class="form-control" id="fecha" name="fecha" value="<?= $parametros['datos']['fecha'] ?>" readonly="readonly" />
                    </div>
                    <!-- TITULO -->
                    <div class=" row">
                        <label for="titulo">Título</label>
                        <input type="text" class="form-control" id="nuevotitulo" name="nuevotitulo" value="<?= $parametros['datos']['titulo'] ?>" required />
                    </div></br>
                    <!-- IMAGEN ACTUAL -->
                    <div class="row">
                        <?php if ($parametros['datos']['imagen'] != null && $parametros['datos']['imagen'] != "") : ?>
                            </br>Imagen actual: <img src="fotos/<?= $parametros['datos']['imagen'] ?>" /></br>
                        <?php endif; ?>
                        <!-- IMAGEN A ACTUALIZAR -->
                        <div class="row">
                            <label for="imagen">Actualizar imagen:</label>
                            <input type="file" class="form-control-file" id="imagen" name="imagen" value="<?= $parametros['datos']['imagen'] ?>" />
                        </div></br>
                    </div>
                    <!-- CATEGORIA -->
                    <div class="row">
                        <label for="categoria">Categoría</label>
                        <select class="form-control browser-default custom-select" id="nuevacategoria" name="nuevacategoria">
                            <?php
                            $resultModelo = $this->modelo->listadocategorias(); //Listo las categorias y las guardo en $resultModelo
                            $listaCats = $resultModelo['datos'];
                            //var_dump($resultModelo);
                            foreach ($listaCats as $cat) : ?> <!-- Las imprimo en options -->
                                <option value="<?= $cat['idcat'] ?>" <?= $cat['idcat'] == $parametros['datos']['idCategoria'] ? 'selected="selected"' : '' ?>><?= $cat['nombrecat'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div></br>
                    <div class="row">
                        <label for="descripcion">Descripción</label>
                        <textarea class="ckeditor" id="nuevadescripcion" name="nuevadescripcion" required><?= $parametros['datos']['descripcion'] ?></textarea>
                    </div></br>
                    <div class="row">
                        <label for="prioridad">Prioridad:</label>
                        <input type="text" class="form-control" id="nuevaprioridad" name="nuevaprioridad" value="<?= $parametros['datos']['prioridad'] ?>" />
                    </div></br>
                    <div class="row">
                        <label for="lugar">Lugar:</label>
                        <input type="text" class="form-control" id="nuevolugar" name="nuevolugar" value="<?= $parametros['datos']['lugar'] ?>" />
                    </div></br>
                    <input type="hidden" name="ident" value="<?= $parametros['datos']['ident']; ?>">
                    <input type="hidden" name="nombrecat" value="<?= $parametros['datos']['nombrecat']; ?>">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="submit" class="btn btn-primary" name="actualizar">Actualizar</button>
                        <button type="reset" class="btn btn-secondary" name="limpiar" style="margin-left: 10px">Limpiar</button>
                        <a type="button" class="btn btn-info" href="index.php?accion=userlogued" style="margin-left: 10px">Atrás</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>