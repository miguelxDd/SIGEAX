<?php
include_once "Vistas/cabeza.php";
include_once "Vistas/Recepcion/barraLateral.php";
?>
<div class="card m-3 p-3">
    <h4>Confirma los paquetes que te entreguen.</h4>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered" id="paquetesPorConfirmar">
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


<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" id="abrirModal" hidden>
  Launch static backdrop modal
</button>

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Paquete <span id="identificadorDePaquete"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="infoPaqueteCompleta" style="display: flex; align-items: center; justify-content: center; flex-direction: column;">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cerrarModalPaqInfo">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="confirmarRecepcionPaquete()"><i data-feather="check"></i> Confirmar paquete</button>
            </div>
        </div>
    </div>
</div>
</div>

<?php
require_once "Vistas/pie.php";
?>

<script src="Vistas/Recepcion/js/paquetesRecibir.js"></script>