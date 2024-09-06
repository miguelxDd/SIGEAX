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
            <?php $misOrdenes = ($_GET['url'] == 'historialOrdenes') ? 'active' : '' ?>
            <a href="historialOrdenes" class="list-group-item list-group-item-action list-group-item-secondary <?php echo $misOrdenes ?>" style="border: none; padding-top: 15px; padding-bottom: 15px;">
                <i data-feather="package" class="me-3 mb-1"></i>Mis órdenes
            </a>
        </div>
    </div>
</div>