<?php
include_once "Vistas/cabeza.php";
include_once "Vistas/Vendedor/barraLateral.php";
?>
<div class="card m-3 p-3">
    <div class="cad-header text-center">
        <h4>Paquetes</h4>
        <hr>
    </div>
    <div class="card-body">
        <h4>Paquetes pendientes de confirmación</h4>
        <p>Acercate a entregar entos paquetes pronto para que puedan ser enviados a su destino.</p>
        <div class="table-responsive p-1">
            <table class="table table-bordered table-striped" id="paqPorConfirmar">
                <thead>
                    <tr>
                        <th>Identificador</th>
                        <th>Cliente</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Tipo de envio</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
    
                </tbody>
            </table>
        </div>

        <hr>

        <h4>Paquetes enviados</h4>
        <div class="mb-3 row">
            <label for="tipoEnvio" class="col-md-2 col-form-label">Mostrar paquetes: </label>
            <div class="col-md-3">
                <select class="form-select" id="tipoEnvio">
                    <option value="normal" selected>Envio normal</option>
                    <option value="personalizado">Envio personalizado</option>
                </select>
            </div>
            <div class="col-md-4">
                <a class="btn btn-primary" href="estadisticasVendedor" role="button">Filtrar por cliente</a>
            </div>
        </div>
        <div class="table-responsive p-2" id="contenedorTabla">

        </div>

    </div>
</div>
</div>
<?php
require_once "Vistas/pie.php";
?>
<script src="Vistas/Vendedor/js/paquetesVendedor.js"></script>