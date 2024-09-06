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
            <?php $agregarpaquete = ($_GET['url'] == 'agregarPaquete') ? 'active' : '' ?>
            <a href="agregarPaquete" class="list-group-item list-group-item-action list-group-item-secondary <?php echo $agregarpaquete ?>" style="border: none; padding-top: 15px; padding-bottom: 15px;">
                <i data-feather="plus" class="me-3 mb-1"></i>Agregar paquete
            </a>
            <?php $paquetesrecibir = ($_GET['url'] == 'paquetesRecibir') ? 'active' : '' ?>
            <a href="paquetesRecibir" class="list-group-item list-group-item-action list-group-item-secondary <?php echo $paquetesrecibir ?>" style="border: none; padding-top: 15px; padding-bottom: 15px;">
                <i data-feather="inbox" class="me-3 mb-1"></i>Paquetes por recibir
            </a>
            <?php $registrarvendedor = ($_GET['url'] == 'registrarVendedor') ? 'active' : '' ?>
            <a href="registrarVendedor" class="list-group-item list-group-item-action list-group-item-secondary <?php echo $registrarvendedor ?>" style="border: none; padding-top: 15px; padding-bottom: 15px;">
                <i data-feather="user-plus" class="me-3 mb-1"></i>Registrar vendedor
            </a>
            <?php $noRetirados = ($_GET['url'] == 'noRetirados') ? 'active' : '' ?>
            <a href="noRetirados" class="list-group-item list-group-item-action list-group-item-secondary <?php echo $noRetirados ?>" style="border: none; padding-top: 15px; padding-bottom: 15px;">
                <i data-feather="package" class="me-3 mb-1"></i>Paquetes no retirados
            </a>
            <?php $salidaPaquetes = ($_GET['url'] == 'rutas') ? 'active' : '' ?>
            <a href="rutas" class="list-group-item list-group-item-action list-group-item-secondary <?php echo $salidaPaquetes ?>" style="border: none; padding-top: 15px; padding-bottom: 15px;">
                <i data-feather="share" class="me-3 mb-1"></i>Salida de paquetes
            </a>
        </div>
    </div>
</div>