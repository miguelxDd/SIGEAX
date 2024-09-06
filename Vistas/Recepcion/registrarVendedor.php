<?php
include_once "Vistas/cabeza.php";
include_once "Vistas/Recepcion/barraLateral.php";
?>
<link rel="stylesheet" href="Vistas/Recepcion/css/registroVendedor.css">
<div class="card m-3 p-3">
    <h4 class="text-center">Vendedores registrados</h4>
    <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop" id="abrirModal"
    style="max-width: 325px;">
        <i data-feather="plus"></i> Registrar nuevo vendedor
    </button>
    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered" id="tablaVendedores" style="width: 100%">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Teléfono</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>


<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registro de vendedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="cerrarModalRegistroVen"></button>
            </div>
            <div class="modal-body" id="insertarRegistroAqui">

            </div>
        </div>
    </div>
</div>
</div>

<?php
require_once "Vistas/pie.php";
?>

<script src="Vistas/Recepcion/js/registrarVendedor.js"></script>
<script src="Vistas/js/registroVendedor.js"></script>