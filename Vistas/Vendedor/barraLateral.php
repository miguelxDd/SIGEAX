<div class="offcanvas offcanvas-start" tabindex="-1" id="barraLateral">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Adara Xpress</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <hr style="margin: -3px 0 0 0;">
    <div class="offcanvas-body p-0">
        <div class="list-group rounded-0">
            <?php $inicio = ($_GET['url'] == 'inicio') ? 'active' : '' ?>
            <a href="inicio" class="list-group-item list-group-item-action list-group-item-secondary <?php echo $inicio ?>" style="border: none; padding-top: 15px; padding-bottom: 15px;">
                <i data-feather="home" class="me-3 mb-1"></i>Inicio
            </a>
            <?php $agrPaq = ($_GET['url'] == 'agregarPaquete') ? 'active' : '' ?>
            <a href="agregarPaquete" class="list-group-item list-group-item-action list-group-item-secondary <?php echo $agrPaq ?>" style="border: none; padding-top: 15px; padding-bottom: 15px;">
                <i data-feather="plus" class="me-3 mb-1"></i>Agregar paquete
            </a>
            <?php $paqVend = ($_GET['url'] == 'paquetesVendedor') ? 'active' : '' ?>
            <a href="paquetesVendedor" class="list-group-item list-group-item-action list-group-item-secondary <?php echo $paqVend ?>" style="border: none; padding-top: 15px; padding-bottom: 15px;">
                <i data-feather="package" class="me-3 mb-1"></i>Ver paquetes.
            </a>
            <?php $estVend = ($_GET['url'] == 'estadisticasVendedor') ? 'active' : '' ?>
            <a href="estadisticasVendedor" class="list-group-item list-group-item-action list-group-item-secondary <?php echo $estVend ?>" style="border: none; padding-top: 15px; padding-bottom: 15px;">
                <i data-feather="bar-chart" class="me-3 mb-1"></i>Ver estadísticas de Clientes.
            </a>
            <?php $estDest = ($_GET['url'] == 'estadisticasDestinos') ? 'active' : '' ?>
            <a href="estadisticasDestinos" class="list-group-item list-group-item-action list-group-item-secondary <?php echo $estDest ?>" style="border: none; padding-top: 15px; padding-bottom: 15px;">
                <i data-feather="bar-chart" class="me-3 mb-1"></i>Ver estadísticas de Destinos.
            </a>
            <?php $remu = ($_GET['url'] == 'remuneraciones') ? 'active' : '' ?>
            <a href="remuneraciones" class="list-group-item list-group-item-action list-group-item-secondary <?php echo $remu ?>" style="border: none; padding-top: 15px; padding-bottom: 15px;">
                <i data-feather="dollar-sign" class="me-3 mb-1"></i>Remuneraciones
            </a>
        </div>
    </div>
</div>