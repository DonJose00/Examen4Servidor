<!DOCTYPE html>
<html lang="es">
<?php require 'includes/head.php';?>

<body>
    <div class="row justify-content-center">
    <div class="col-xs-2 col-sm-4 col-md-6 col-lg-8">
        <table class="table table-success table-striped">
            <thead class="thead-dark text-center">
                <tr>
                    <th>Usuario</th>
                    <th>Fecha</th>
                    <th>Operaciones</th>
                </tr>
            </thead>
            <tbody>
            <?php
                //var_dump($parametrosVistas['datos']);
                foreach ($parametrosVistas['datos'] as $entrada): ?>
                <tr>
                    <td class="text-center"><?php echo $entrada['usuarios']; ?></td>
                    <td class="text-center"><?php echo $entrada['fecha']; ?></td>
                    <td class="text-center"><?php echo $entrada['operaciones']; ?></td>
                </tr>
                <?php endforeach?>
            </tbody>
        </table>
        <a class="btn btn-primary" href="index.php?accion=userlogued">Atrás</a>
    </div>
</div>

    <!-- añadimos paginado -->
    <!-- <div class="d-flex flex-wrap align-content-end justify-content-center">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link" href="index.php?accion=listado_logs&pag=<php
                if ($_GET['pag'] > 1) {
                    echo ($_GET['pag'] - 1);
                } else {
                    echo $_GET['pag'];
                }
                ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
                </a>
            </li>
 colocamos el paginador según el numero total de paginas que hay en entradas
<php
    for ($i = 1; $i <= $parametrosVistas['paginas']; $i++) {?>
        <li class="<php if ($_GET['pag'] == $i) {
        echo 'page-item active';
    } else {
        echo 'page-item';
    }
?>">
<a class="page-link" href="<php echo 'index.php?accion=listado_logs&pag=' . $i; ?>"><php echo $i; ?></a></li>
<php }?>
    <li class="page-item">
    <a class="page-link" href="index.php?accion=listado_logs&pag=<php
    if ($_GET['pag'] < $parametrosVistas['paginas']) {
        echo ($_GET['pag'] + 1);
    } else {
        echo $_GET['pag'];
    }
?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
    </nav>
    </div>
    <div style="padding-top: 20px; padding-bottom:20px; text-align:center;">
    <a href="imprimirPDF.php" title="Imprimir"><img src="img/pdf.png" width="40px" height="47px"></a>
    <a href="index.php?accion=logsExcel" title="Imprimir"><img src="img/excel.jpg" width="40px" height="47px"></a></div>
    <div style="padding-top: 20px; padding-bottom:20px; text-align:center;"> -->

</body>
</html>