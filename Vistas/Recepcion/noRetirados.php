<?php
    include_once "Vistas/cabeza.php";
    include_once "Vistas/Recepcion/barraLateral.php";
?>
<link rel="stylesheet" href="Vistas/Recepcion/css/modales.css">
    <div class="card m-3 p-3">
        <h4>Consulta, devuelve o reprograma el envío de paquetes que no fueron retirados.</h4>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered" id="noRetirados">
                <thead>
                    <tr>
                        <th>Identificador de paquete</th>
                        <th>Nombre del vendedor</th>
                        <th>Telefono del vendedor</th>
                        <th>Nombre del cliente</th>
                        <th>Fecha a entregar</th>
                        <th>Estado</th>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Paquete <span id="identificadorDePaquete"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btnCerrarModalPaq"></button>
                </div>
                <div class="modal-body" id="infoPaqueteCompleta" style="display: flex; align-items: center; justify-content: center; flex-direction: column;">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="devolverPaquete()" id="btnDevolver"><i data-feather="package" class="me-2"></i> Devolver</button>
                    <button type="button" class="btn btn-primary" onclick="reprogramar()" id="btnReprogramar"><i data-feather="truck" class="me-2"></i> Reprogramar entrega</button>
                    <button type="button" class="btn btn-secondary" onclick="cancelarReprogramacion()" id="btnCancelarReprogramacion"><i data-feather="x" class="me-2"></i> Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarReprogramacion()" id="btnGuardarReprogramacion"><i data-feather="save" class="me-2"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="contenedorModalNivel1" id="cmodalRutas">
        <main class="modalSeleccionarRuta" id="modalRutas">
            <div class="row pe-2 mt-1" id="envioNormal">

            </div>
        </main>
    </section>
<?php
    require_once "Vistas/pie.php";
?>
<script src="Vistas/Recepcion/js/noRetirados.js"></script>