<?php
    include_once "Vistas/cabeza.php";
    include_once "Vistas/Admin/barraLateral.php";
?>
    <div class="card m-3 p-3">
        <div class="card p-2 mb-2">
            <h3>Bienvenid@ administrador.</h3>
        </div>

        <div class="row">
            <div class="col-md-6 my-2">
                <div class="card text-center p-4 h-100 tarjInicio">
                    <h4>Gestiona las rutas de envio normal.</h4>
                    <a href="gestionarRutas">
                        <i data-feather="sliders" class="me-2 mb-1"></i>Ir a rutas
                    </a>
                </div>
            </div> 
            <div class="col-md-6 my-2">
                <div class="card text-center p-4 h-100 tarjInicio">
                    <h4>Gestionar el catálogo de costos de envío.</h4>
                    <a href="gestionarCatalogoReferencia">
                        <i data-feather="dollar-sign" class="me-2 mb-1"></i>Gestionar
                    </a>
                </div>
            </div> 
            <div class="col-md-6 my-2">
                <div class="card text-center p-4 h-100 tarjInicio">
                    <h4>Consultar datos financieros.</h4>
                    <a href="infoFinanciera">
                        <i data-feather="dollar-sign" class="me-2 mb-1"></i>Consultar
                    </a>
                </div>
            </div>
            <div class="col-md-6 my-2">
                <div class="card text-center p-4 h-100 tarjInicio">
                    <h4>Gestinar usuarios.</h4>
                    <a href="gestionarUsuarios">
                        <i data-feather="users" class="me-2 mb-1"></i>Gestionar
                    </a>
                </div>
            </div>
            <div class="col-md-6 my-2">
                <div class="card text-center p-4 h-100 tarjInicio">
                    <h4>Consulta reportes.</h4>
                    <a href="reportes">
                        <i data-feather="bar-chart-2" class="me-2 mb-1"></i>Ver reportes
                    </a>
                </div>
            </div>
            <div class="col-md-6 my-2">
                <div class="card text-center p-4 h-100 tarjInicio">
                    <h4>Consulta información financiera.</h4>
                    <a href="infoFinanciera">
                        <i data-feather="trending-up" class="me-2 mb-1"></i>Ver información
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    require_once "Vistas/pie.php";
?>