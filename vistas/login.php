<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../css/style.css">
  <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>

    <!-- Link Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <div>
    <?php
if (isset($_GET['error'])) {
    if ($_GET['error'] == "crednovalidas") {
        ?>
        <div class="alert alert-danger">
          <strong>:O Error!!</strong> "Tu usuario o/y tu contraseña no son correctos, inténtelo de nuevo!! :("
        </div>
      <?php
} elseif ($_GET['error'] == "accesonopermitido") {
        ?>
        <div class="alert alert-danger">
          <strong>:O Error!!</strong> "No puede acceder directamente en esta página, ha de loguearse!! :O"
        </div>
    <?php }
}?>

  </div>
<div class="row justify-content-center">
  <div class="col-xs-2 col-sm-4 col-md-6 col-lg-8">
    <div class="container cuerpo text-center">
        <p><h2> <img src="../fotos/formulario.png" width="60px" /> Login de usuario:</h2></p>
      </div>
      <div class="container my-3">
          <div class="col-xs-2 col-sm-4 col-md-6 col-lg-8 s">
                <form action="../index.php?accion=login" method="post">
                  <div class="form-group col-5">
                    <label for="usuario">Usuario</label>
                    <input type="text" class="form-control" name="usuario">
                  </div>
                  <div class="form-group col-5">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control" name="password">
                  </div>
                  <input type="submit" class="btn btn-primary" name="enviar"></input>
                </form>
          </div>
      </div>
  </div>
</div>
</body>

</html>