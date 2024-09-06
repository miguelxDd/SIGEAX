<?php
    include_once "Vistas/cabeza.php";
    include_once "Vistas/Repartidor/barraLateral.php";
?>
    <div class="card m-3 p-3">
        <div class="card p-2 mb-2">
            <h3>Bienvenid@ <?php echo $_SESSION['nombre'] ?>.</h3>
        </div>

        <div class="row">
            <div class="col-md-6 my-2">
                <div class="card text-center p-4 h-100 tarjInicio">
                    <h4>Consultar rutas de envio normal.</h4>
                    <a href="paquetesNormal">
                        <i data-feather="truck" class="me-2 mb-1"></i>Ir a rutas
                    </a>
                </div>
            </div> 
            <div class="col-md-6 my-2">
                <div class="card text-center p-4 h-100 tarjInicio">
                    <h4>Consultar rutas de envio personalizado.</h4>
                    <a href="paquetesPersonalizado">
                        <i data-feather="send" class="me-2 mb-1"></i>Ir a rutas
                    </a>
                </div>
            </div> 
        </div>
    </div>
</div>

<?php
    require_once "Vistas/pie.php";
?>