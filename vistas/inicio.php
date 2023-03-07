<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/style.css">
  <?php require_once('includes/head.php'); ?>
</head>

<body>
  <div class="container-fluid" style=" background: #daffdb;">
    <div class="row justify-content-center">
        <?php foreach ($parametros['datos'] as $entrada) {?>
          <div class="row justify-content-center" style="margin-top:10px; padding:8px;">
            <div class="card col-xs-2 col-sm-4 col-md-6 col-lg-8 text-center">
              <div class="bg-success p-2 text-dark bg-opacity-25">
                <strong>Categoría:</strong> <?php echo $entrada['nombrecat'] . " - " ?> <strong>Fecha:</strong> <?php echo $entrada['fecha'] ?>
              </div>
              <div class="card-body">
                <h5 class="bg-success p-2 text-dark bg-opacity-25"> <?php echo $entrada['titulo'] ?></h5>
                <img class="img-fluid" src='fotos/<?php echo $entrada['imagen'] ?>' style="float: left;width: 150px">
                <p class="card-text"> <?php echo $entrada['descripcion'] ?> </p>
                <a class="btn btn-dark" href="index.php?accion=detalleEntrada&id= <?= $entrada['ident']; ?>"> Leer más...</a>
              </div>
              <div class="p-3 mb-2 bg-success text-white">
                <img src="fotos/<?php echo $entrada['avatar']; ?>" style="width: 20px;"> <?php echo "  " . $entrada['nick'] ?>
              </div>
            </div>
          </div>
        <?php } ?> <!-- Termina el foreach -->
    </div>
  </div>
  
  <?php include('listadoPag.php'); ?>

</body>

</html>