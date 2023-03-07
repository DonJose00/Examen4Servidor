<?php
//session_start();
//var_dump($_SESSION['user']);
if (!isset($_SESSION['user']) || ($_SESSION['rol'] != "user")) {
  header("Location: vistas/login.php?error=accesonopermitido");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once('includes/head.php'); ?>
</head>

<body>
  <div class="container-fluid" style=" background: #daffdb;">
    <div class="row justify-content-center">
      <?php if ($parametros['datos'] != null) {  ?>
        <?php foreach ($parametros['datos'] as $entradaUsu) {?>
          <div class="row justify-content-center" style="margin-top:10px; padding:8px;">
            <div class="card col-xs-2 col-sm-4 col-md-6 col-lg-8 text-center">
              <div class="bg-success p-2 text-dark bg-opacity-25">
                <strong>Categoría:</strong> <?php echo $entradaUsu['nombrecat'] . " - " ?> <strong>Fecha:</strong> <?php echo $entradaUsu['fecha'] ?>
              </div>
              <div class="card-body">
                <h5 class="bg-success p-2 text-dark bg-opacity-25"> <?php echo $entradaUsu['titulo'] ?></h5>
                <img class="img-fluid" src='fotos/<?php echo $entradaUsu['imagen'] ?>' style="float: left;width: 150px">
                <p class="card-text"> <?php echo $entradaUsu['descripcion'] ?> </p>
                <a class="btn btn-info btn-sm" href="index.php?accion=actEntrada&id= <?= $entradaUsu['ident']; ?>">Editar</a>
                <a class="btn btn-secondary btn-sm" href="index.php?accion=detalleEntrada&id= <?= $entradaUsu['ident']; ?>">Detalle</a>
                <a class="btn btn-danger btn-sm" href="index.php?accion=delEntrada&id= <?= $entradaUsu['ident']; ?>">Eliminar</a>
              </div>
              <div class="p-3 mb-2 bg-success text-white">
                <img src="fotos/<?php echo $entradaUsu['avatar']; ?>" style="width: 20px;"> <?php echo "  " . $entradaUsu['nick'] ?>
              </div>
            </div>
          </div>
        <?php } ?> <!-- Termina el foreach -->
      <?php } else {  ?>
        <h5 class="card-header font-weight-bold"> No se encontraron datos asociados a usuarios:(!!</h5>
      <?php }  ?>
    </div>
  </div>
  <?php include('listadoPag.php'); ?>
</body>

</html>