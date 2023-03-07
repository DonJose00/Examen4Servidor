<?php 
    $pag = 1;
    if (isset($_GET['pagina'])) {
        $pag = $_GET['pagina'];
    }
    //var_dump($resultModelo['paginas']);
    ?>
<div class="d-flex flex-wrap align-content-end justify-content-center">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <!-- Para calcular cuando la pagina sea menor al nº de paginas mínimo -->
            <li class="page-item <?php if ($pag<=1){echo 'disabled';}else{echo '';} ?>">
                <a class="page-link" href="index.php?pagina=<?php echo $pag-1 ?>">
                Anterior
                </a>
            </li>

            <!-- colocamos el paginador según el numero total de paginas que hay en entradas -->
            <?php for ($i = 1; $i <= $resultModelo['paginas']; $i++):?>
                <!-- Para saber el nº de pagina en donde nos encontramos -->
                <li class="<?php if ($pag==$i){echo 'page-item active';}else{echo 'page-item';}?>">
                    <!-- href="<php echo 'index.php?accion=paginado&pag='. $i?>" -->
                    <a class="page-link" href="index.php?pagina=<?php echo $i?>">
                    <?php echo $i?></a>
                </li>
            <?php endfor ?>

                <!-- Para calcular cuando la pagina sea mayor al nº de paginas máximas -->
            <li class="page-item <?php if ($pag>=$resultModelo['paginas']){echo 'disabled';}else{echo '';} ?>">
                <a class="page-link" href="index.php?pagina=<?php echo $pag+1?>">
                Siguiente
                </a>
            </li>
        </ul>
    </nav>
</div>

