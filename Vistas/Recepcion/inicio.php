<?php
    include_once "Vistas/cabeza.php";
    include_once "Vistas/Recepcion/barraLateral.php";
?>
    <div class="card m-3 p-3">
        <div class="card p-2 mb-2">
            <h3>Bienvenid@ <?php echo $_SESSION['nombre'] ?>.</h3>
        </div>

        <div class="row">
            <div class="col-md-6 my-2">
                <div class="card text-center p-4 h-100 tarjInicio">
                    <h4>Agregar paquete.</h4>
                    <a href="agregarPaquete">
                        <i data-feather="plus" class="me-2 mb-1"></i>Agregar paquete
                    </a>
                </div>
            </div>
            <div class="col-md-6 my-2">
                <div class="card text-center p-4 h-100 tarjInicio">
                    <h4>Consultar los paquetes a recibir.</h4>
                    <a href="paquetesRecibir">
                        <i data-feather="arrow-right" class="me-2 mb-1"></i>Ver paquetes
                    </a>
                </div>
            </div>
            <div class="col-md-6 my-2">
                <div class="card text-center p-4 h-100 tarjInicio">
                    <h4>Consultar vendedores.</h4>
                    <a href="registrarVendedor">
                        <i data-feather="arrow-right" class="me-2 mb-1"></i>Registrar vendedores.
                    </a>
                </div>
            </div>
            <div class="col-md-6 my-2">
                <div class="card text-center p-4 h-100 tarjInicio">
                    <h4>Consulta los paquetes que no fueron retirados.</h4>
                    <a href="noRetirados">
                        <i data-feather="arrow-right" class="me-2 mb-1"></i>Ver paquetes.
                    </a>
                </div>
            </div>
            <div class="col-md-6 my-2">
                <div class="card text-center p-4 h-100 tarjInicio">
                    <h4>Gestiona la salida de paquetes.</h4>
                    <a href="rutas">
                        <i data-feather="arrow-right" class="me-2 mb-1"></i>Gestionar.
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    require_once "Vistas/pie.php";
?>