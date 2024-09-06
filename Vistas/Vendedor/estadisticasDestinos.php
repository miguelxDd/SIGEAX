<?php
    include_once "Vistas/cabeza.php";
    include_once "Vistas/Vendedor/barraLateral.php";
?>
    <div class="card m-3 p-3">
        <div class="cad-header text-center">
            <h4>Información de destinos</h4>
            <hr>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-1" style="margin: auto;">
                    <div class="card text-center p-4 h-100">
                        <h4>Has enviado paquetes a un total de <span id="totalDestinos"></span> destinos</h4>
                        <h6>Abajo puedes ver el número de paquetes de los 10 principales destinos</h6>
                    </div>
                </div>
            </div>
            <h4 class="text-center my-2">Los 10 destinos con más paquetes</h4>
            <canvas id="myChart"></canvas>
        </div>
    </div>
</div>
<?php
    require_once "Vistas/pie.php";
?>
<script src="Vistas/Vendedor/js/estadisticasDestinos.js"></script>