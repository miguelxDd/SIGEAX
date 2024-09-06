<?php
include_once "Vistas/cabeza.php";
include_once "Vistas/Repartidor/barraLateral.php";
?>
    <div class="card m-3 p-3">
        <section style="display: flex; justify-content: center; align-items: center;" id="parainfodestino">
        </section>
        <section class="my-2">
            <button class="btn btn-primary btnEstadoRuta" id="btnEmpezarRuta"><i data-feather="truck" class="me-1"></i> Voy en camino</button>
            <button class="btn btn-primary btnEstadoRuta" id="btnEnLugar"><i data-feather="map-pin" class="me-1"></i> Llegué al destino</button>
            <button class="btn btn-primary btnEstadoRuta" id="btnFinDestino"><i data-feather="check" class="me-1"></i> Finalizar destino</button>
            <div class="alert alert-success mt-2" role="alert" id="alertaDestinoFinalizado">
                <i data-feather="check-circle" class="me-1"></i> Destino finalizado
            </div>
        </section>
        <div class="table-responsive p-1">
            <table class="table table-striped table-hover table-bordered" id="paquetesDeRuta">
                <thead>
                    <tr>
                        <th>Identificador de paquete</th>
                        <th>Nombre del vendedor</th>
                        <th>Nombre del cliente</th>
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="infoPaqueteCompleta" style="display: flex; align-items: center; justify-content: center; flex-direction: column;">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cerrarModalPaqInfo">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once "Vistas/pie.php";
?>

<script src="Vistas/Repartidor/js/destino.js"></script>