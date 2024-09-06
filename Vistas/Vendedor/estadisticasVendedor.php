<?php
include_once "Vistas/cabeza.php";
include_once "Vistas/Vendedor/barraLateral.php";
?>
<div class="card m-3 p-3">
    <div class="cad-header text-center">
        <h4>Información</h4>
        <hr>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-1" style="margin: auto;">
                <div class="card text-center p-4 h-100">
                    <h4>Has entregado paquetes a un total de <span id="totalClientes"></span> clientes</h4>
                    <h6>Abajo puedes ver el número de paquetes por cada uno de los clientes</h6>
                </div>
            </div>
        </div>
        <section class="contenedorSecciones">
            <div class="seccionAMover" id="seccion1">
                <h4 class="text-center mt-2">Número de paquetes por cliente</h4>
                <table class="table table-striped text-center table-bordered table-hover" id="numporCliente">
                    <thead>
                        <tr class="table-secondary">
                            <th>Nombre cliente</th>
                            <th># de paquetes</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">

                    </tbody>
                </table>
            </div>
            <div class="seccionAMover" id="seccion2">
                <button class="btn btn-secondary mt-2" onclick="cambiarASeccion1()">
                    <i data-feather="arrow-left"></i>Regresar a clientes
                </button>
                <h4 class="text-center mt-2">Paquetes entregados a <span id="nombreCliente"></span></h4>
                <table class="table table-striped text-center table-bordered table-hover" id="paquetesCliente">
                    <thead>
                        <tr class="table-secondary">
                            <th>identificador</th>
                            <th>Descripción</th>
                            <th>Fecha envío</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">

                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
</div>
<?php
require_once "Vistas/pie.php";
?>
<script src="Vistas/Vendedor/js/estadisticasVendedor.js"></script>