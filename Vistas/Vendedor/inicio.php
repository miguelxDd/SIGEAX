<?php
    include_once "Vistas/cabeza.php";
    include_once "Vistas/Vendedor/barraLateral.php";
?>
    <div class="card m-3 p-3">
        <div class="card p-2 mb-2">
            <h3>Bienvenid@ <?php echo $_SESSION['nombre'] ?>.</h3>
        </div>

        <div class="row">
            <div class="col-md-6 my-2">
                <div class="card text-center p-4 h-100 tarjInicio">
                    <h4>Agrega paquetes para que sea más ágil su entrega.</h4>
                    <a href="agregarPaquete">
                        <i data-feather="plus" class="me-2 mb-1"></i>Agregar paquete
                    </a>
                </div>
            </div>
            <div class="col-md-6 my-2">
                <div class="card text-center p-4 h-100 tarjInicio">
                    <h4>Consulta tus paquetes.</h4>
                    <a href="paquetesVendedor">
                        <i data-feather="arrow-right" class="me-2 mb-1"></i>Ver paquetes
                    </a>
                </div>
            </div>
            <div class="col-md-6 my-2">
                <div class="card text-center p-4 h-100 tarjInicio">
                    <h4>Consulta algunas estadísticas por cliente.</h4>
                    <a href="estadisticasVendedor">
                        <i data-feather="arrow-right" class="me-2 mb-1"></i>Ver estadísticas.
                    </a>
                </div>
            </div>
            <div class="col-md-6 my-2">
                <div class="card text-center p-4 h-100 tarjInicio">
                    <h4>Consulta algunas estadísticas de los destinos.</h4>
                    <a href="estadisticasDestinos">
                        <i data-feather="arrow-right" class="me-2 mb-1"></i>Ver estadísticas.
                    </a>
                </div>
            </div>
            <div class="col-md-6 my-2">
                <div class="card text-center p-4 h-100 tarjInicio">
                    <h4>Consulta tus remuneraciones.</h4>
                    <a href="remuneraciones">
                        <i data-feather="dollar-sign" class="me-2 mb-1"></i>Ver.
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    require_once "Vistas/pie.php";
?>