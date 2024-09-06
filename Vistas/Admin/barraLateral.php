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
            <?php $gestionarRutas = ($_GET['url'] == 'gestionarRutas') ? 'active' : '' ?>
            <a href="gestionarRutas" class="list-group-item list-group-item-action list-group-item-secondary <?php echo $gestionarRutas ?>" style="border: none; padding-top: 15px; padding-bottom: 15px;">
                <i data-feather="sliders" class="me-3 mb-1"></i>Gestionar rutas
            </a>
            <?php $gestionarCatalogo = ($_GET['url'] == 'gestionarCatalogo') ? 'active' : '' ?>
            <a href="gestionarCatalogo" class="list-group-item list-group-item-action list-group-item-secondary <?php echo $gestionarCatalogo ?>" style="border: none; padding-top: 15px; padding-bottom: 15px;">
                <i data-feather="dollar-sign" class="me-3 mb-1"></i>Gestionar catálogo
            </a>
            <?php $gestioUsuarios = ($_GET['url'] == 'gestionarUsuarios') ? 'active' : '' ?>
            <a href="gestionarUsuarios" class="list-group-item list-group-item-action list-group-item-secondary <?php echo $gestioUsuarios ?>" style="border: none; padding-top: 15px; padding-bottom: 15px;">
                <i data-feather="users" class="me-3 mb-1"></i>Gestionar usuarios
            </a>
            <?php $reportes = ($_GET['url'] == 'reportes') ? 'active' : '' ?>
            <a href="reportes" class="list-group-item list-group-item-action list-group-item-secondary <?php echo $reportes ?>" style="border: none; padding-top: 15px; padding-bottom: 15px;">
                <i data-feather="bar-chart-2" class="me-3 mb-1"></i>Reportes
            </a>
            <?php $infoFinanciera = ($_GET['url'] == 'infoFinanciera') ? 'active' : '' ?>
            <a href="infoFinanciera" class="list-group-item list-group-item-action list-group-item-secondary <?php echo $infoFinanciera ?>" style="border: none; padding-top: 15px; padding-bottom: 15px;">
                <i data-feather="trending-up" class="me-3 mb-1"></i>Información financiera
            </a>
        </div>
    </div>
</div>