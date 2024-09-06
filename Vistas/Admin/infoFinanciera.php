<?php
include_once "Vistas/cabeza.php";
include_once "Vistas/Admin/barraLateral.php";
?>
<script src="https://unpkg.com/lightweight-charts/dist/lightweight-charts.standalone.production.js"></script>
<div class="card m-3 p-3">
    <h4 class="text-center">Información financiera</h4>
    <hr>

    <div class="row">
        <div class="col-lg-6 my-2" id="col-grafico1">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-center">Ingresos por envíos normales</h4>
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <button class="nav-link active" id="ingresosDia" onclick="cambiarIngreEnvNormal()">Diario</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="ingresosSemana" onclick="cambiarIngreEnvNormal(true)">Semanal</button>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-0">
                    <div id="ingresosEnvNormal">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 my-2">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-center">Ingresos por envíos personalizados</h4>
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <button class="nav-link active" id="ingresosDia2" onclick="cambiarIngreEnvPerson()">Diario</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="ingresosSemana2" onclick="cambiarIngreEnvPerson(true)">Semanal</button>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-0">
                    <div id="ingresosEnvPerson">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 my-2" id="col-grafico1">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-center">Número de envíos normales</h4>
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <button class="nav-link active" id="numeroDia" onclick="cambiarNumEnvNormal()">Diario</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="numeroSemana" onclick="cambiarNumEnvNormal(true)">Semanal</button>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-0">
                    <div id="numeroEnvNormal">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 my-2">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-center">Número de envíos personalizados</h4>
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <button class="nav-link active" id="numeroDia2" onclick="cambiarNumEnvPerson()">Diario</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="numeroSemana2" onclick="cambiarNumEnvPerson(true)">Semanal</button>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-0">
                    <div id="numeroEnvPerson">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php
require_once "Vistas/pie.php";
?>

<script src="Vistas/Admin/js/infoFinanciera.js"></script>