<?php
include_once "Vistas/cabeza.php";
include_once "Vistas/Repartidor/barraLateral.php";
?>
    <div class="card m-3 p-3">
        <h4 class="text-center">Paquetes personalizados.</h4>
        <hr>
        <div class="row">
            <div class="col-md-6 mb-1" style="margin: auto;">
                <div class="card text-center p-4 h-100">
                    <h4>Hoy tienes <span id="totalPaquetesHoy"></span> paquetes personalizados.</h4>
                    <h6>Abajo puedes consultar todos ellos para realizar la entrega.</h6>
                </div>
            </div>
        </div>
        <div class="table-responsive p-1">
            <table class="table table-striped table-hover table-bordered" id="tablaPaquetesPersonalizadosHoy">
                <thead>
                    <tr>
                        <th>Identificador</th>
                        <th>Cliente</th>
                        <th>Fecha de entrega</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table> 
        </div>
        <hr class="mt-5 mb-5">
        <div class="row">
            <div class="col-md-6 mb-1" style="margin: auto;">
                <div class="card text-center p-4 h-100">
                    <h4>Tienes <span id="totalPaquetesT"></span> paquetes personalizados para entregar después.</h4>
                    <h6>Abajo puedes consultar la información de ellos. (Estos son los paquetes a entregar en los próximos días)</h6>
                </div>
            </div>
        </div>
        <div class="table-responsive p-1">
            <table class="table table-striped table-hover table-bordered" id="tablaPaquetesPersonalizadosT">
                <thead>
                    <tr>
                        <th>Identificador</th>
                        <th>Cliente</th>
                        <th>Fecha de entrega</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
require_once "Vistas/pie.php";
?>

<script src="Vistas/Repartidor/js/paquetesPersonalizado.js"></script>