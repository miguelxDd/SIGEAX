<?php
date_default_timezone_set("America/El_Salvador");
include_once "Vistas/cabeza.php";
include_once "Vistas/Admin/barraLateral.php";
?>
    <div class="card m-3">
        <div class="card-header">
            <h3 class="text-center">Aquí tienes alguna información que podría servirte</h3>
        </div>
        <div class="card-body">
            <h4>Total de paquetes y su valor por cada destino</h4>
            <section class="row">
                <div id="ultimos3Meses">
                    <p>Estás viendo información de los últimos 3 meses</p>
                    <div class="row">
                        <p class="col-md-3 form-label">Cambiar a fechas específicas</p>
                        <button type="button" class="btn btn-primary col-4" onclick="seleccionarFechas()">Seleccionar fechas</button>
                    </div>
                </div>
                <section id="paraSeleccionarFechas">
                    <div class="row">
                        <p>Selecciona las fechas que deseas ver</p>
                        <div class="col-3" style="display: flex; align-items: center;">
                            <button type="button" class="btn btn-danger" onclick="cerrarFechas()">
                                <i data-feather="arrow-left"></i> Volver
                            </button>
                        </div>
                        <div class="col-md-3">
                            <label for="fechaInicio">Fecha de inicio</label>
                            <input type="date" class="form-control" id="fechaInicio" value="<?php echo date("Y-m-d", strtotime("-3 months")); ?>">
                        </div>
                        <div class="col-md-3">
                            <label for="fechaFin">Fecha de fin</label>
                            <input type="date" class="form-control" id="fechaFin" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                        <div class="col-3" style="display: flex; align-items: center;">
                            <button type="button" class="btn btn-primary" id="btnFechas">Ver información</button>
                        </div>
                    </div>
                </section>
                <div class="col-md-6">
                    <div class="table-responsive p-1">
                        <table class="table table-bordered table-striped" id="destinosInfo">
                            <thead>
                                <tr>
                                    <th>Destino</th>
                                    <th># de paquetes</th>
                                    <th>Valor $</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <canvas id="destinosInfoChart"></canvas>
                </div>
            </section>
        </div>
    </div>
</div>

<?php
require_once "Vistas/pie.php";
?>
<script src="Vistas/Admin/js/reportes.js"></script>