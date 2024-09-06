<?php
    include_once "Vistas/cabeza.php";
    include_once "Vistas/Vendedor/barraLateral.php";
?>
    <div class="card m-3 p-3">
        <div class="cad-header text-center">
            <h4>Remuneraciones</h4>
            <hr>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-1" style="margin: auto;">
                    <div class="card text-center p-4 h-100">
                        <h4>Tienes un total de  <span id="totalRePendientes"></span> remuneraciones pendientes</h4>
                        <h6>Puedes consultar las remuneraciones que no has cobrado abajo</h6>
                    </div>
                </div>
                <div class="col-md-6 mb-1" style="margin: auto;">
                    <div class="card text-center p-4 h-100">
                        <h4>Tienes un total de <span id="totalRePendientesD"></span> en remuneraciones pendientes</h4>
                        <h6>Puedes consultar las remuneraciones que no has cobrado abajo</h6>
                    </div>
                </div>
            </div>
            <div class="table-responsive mt-2">
                <table class="table table-striped table-hover table-bordered" id="tablaRemuneraciones">
                    <thead>
                        <tr>
                            <th>Identificador de paquete</th>
                            <th>Fecha de envio</th>
                            <th>Precio</th>
                            <th>Costo de envio</th>
                            <th>Remuneracion</th>
                            <th>Remuneracion - renta</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
    require_once "Vistas/pie.php";
?>
<script src="Vistas/Vendedor/js/remuneraciones.js"></script>