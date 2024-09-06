<?php
include_once "Vistas/cabeza.php";
include_once "Vistas/Recepcion/barraLateral.php";
?>
<div class="card m-3 p-3">
    <h4>Gestiona la salida de paquetes para cada ruta.</h4>
    <hr>
    <div class="row" id="rutasDestinos">

    </div>
    <hr class="mt-3 mb-3">
    <h4>Gestiona la salida de paquetes de envio personalizado.</h4>
    <div class="table-responsive p-1">
        <table class="table table-striped table-hover table-bordered" id="tablaPaquetesPersonalizados" style="width: 100%;">
            <thead>
                <tr>
                    <th>Identificador</th>
                    <th>Nombre del vendedor</th>
                    <th>Nombre del cliente</th>
                    <th>Fecha a entregar</th>
                    <th></th>
                </tr>
        </table>
        <tbody>
        </tbody>
    </div>
</div>


<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" id="abrirModal" hidden>
    Launch static backdrop modal
</button>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Paquetes confirmados para el destino</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="display: flex; align-items: center; justify-content: center; flex-direction: column;">
                <section id="parainfodestino">

                </section>
                <div class="table-responsive mt-2"  style="width: 100%;">
                    <table class="table table-striped table-hover table-bordered" id="paquetesDeRuta" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Identificador de paquete</th>
                                <th>Nombre del vendedor</th>
                                <th>Nombre del cliente</th>
                                <th>Fecha a entregar</th>
                                <th></th>
                            </tr>
                    </table>
                    <tbody>

                    </tbody>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cerrarModalPaqInfo">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div id="modalPaqueteInfo"
    style="height: 100vh; width: 100%; align-items: center; justify-content: center; z-index: 9999; display: none; position: fixed; top: 0;">
    <div class="card">
        <div class="modal-content">
            <div class="card-header">
                <h5 class="text-center">Paquete <span id="identificadorDePaquete"></span></h5>
            </div>
            <div class="card-body" id="infoPaqueteCompleta" style="display: flex; align-items: center; justify-content: center; flex-direction: column;">

            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-secondary" onclick="cerrarModalPaqInfo()">Cerrar</button>
            </div>
        </div>
    </div>
</div>
</div>

<?php
require_once "Vistas/pie.php";
?>

<script src="Vistas/Recepcion/js/rutas.js"></script>