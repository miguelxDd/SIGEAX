<?php
include_once "Vistas/cabeza.php";
include_once "Vistas/Vendedor/barraLateral.php";
?>
<link rel="stylesheet" href="Vistas/Recepcion/css/registroVendedor.css">
<div class="card m-3">
    <div class="cad-header mt-2 text-center">
        <h4>Agregar un paquete</h4>
        <hr>
    </div>
    <div class="card-body">
        <form action="" method="post" id="formAgregarPaquete">
            <div class="card mb-2 infoFormularios">
                <div class="card-header">
                    Información del vendedor <i data-feather="chevron-up" class="ms-2 mb-1"></i>
                </div>
                <div class="card-body" id="formVendedor">
                    <input name="vendedorID" id="vendedorID" type="number" hidden>
                    <div class="mb-2 row">
                        <label for="telefono_vendedor" class="col-md-4 col-form-label">Seleccione un vendedor (*):</label>
                        <button class="btn btn-primary col-md-4" type="button" data-bs-toggle="modal" data-bs-target="#modalVendedor">Seleccionar</button>
                    </div>
                    <div class="mb-2 row">
                        <label for="nombre_vendedor" class="col-md-2 col-form-label">Nombre (*):</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="nombre_vendedor" name="nombre_vendedor" readonly>
                        </div>
                        <label for="negocio_vendedor" class="col-md-2 col-form-label">Negocio (*):</label>
                        <div class="col-md-4">
                            <select class="form-select" name="negocio_vendedor" id="negocio_vendedor">
                                <option value="0" selected>Seleccione</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-body-secondary">
                        campos con (*) son obligatorios
                    </div>
                </div>
            </div>
            <div class="card my-2 infoFormularios">
                <div class="card-header">
                    Información del cliente <i data-feather="chevron-up" class="ms-2 mb-1"></i>
                </div>
                <div class="card-body" id="formCliente">
                    <div class="mb-2 row">
                        <label for="nombre_cliente" class="col-md-2 col-form-label">Nombre (*):</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" required>
                        </div>
                        <label for="telefono_cliente" class="col-md-2 col-form-label">Teléfono:</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="telefono_cliente" name="telefono_cliente">
                        </div>
                    </div>
                    <div class="text-body-secondary">
                        campos con (*) son obligatorios
                    </div>
                </div>
            </div>
            <!-- ------------------/////////////////////////////////------------------------ -->
            <div class="card my-2 infoFormularios">
                <div class="card-header">
                    Información del entrega <i data-feather="chevron-up" class="ms-2 mb-1"></i>
                </div>
                <div class="card-body" id="formEntrega">
                    <div class="mb-2 row">                        
                        <label for="tipo_envio" class="col-md-2 col-form-label my-1">Tipo envío (*):</label>
                        <div class="col-md-4 my-1">
                            <select name="tipo_envio" id="tipo_envio" class="form-select">
                                <option value="" selected>Seleccione</option>
                                <option value="normal">Normal</option>
                                <option value="personalizado">Personalizado</option>
                            </select>
                        </div>
                    </div>
                    <div class="row pe-2 mt-1" id="envioNormal">

                    </div>
                    <div class="row" id="envioPersonalizado">

                    </div>
                    <div class="text-body-secondary">
                        campos con (*) son obligatorios
                    </div>
                </div>
            </div>
            <!-- ------------------/////////////////////////////////------------------------ -->
            <div class="card my-2 infoFormularios">
                <div class="card-header">
                    Información del paquete <i data-feather="chevron-up" class="ms-2 mb-1"></i>
                </div>
                <div class="card-body" id="formPaquete">
                    <div class="mb-2 row">
                        <label for="descripcion_paquete" class="col-md-2 col-form-label my-1">Descripción del paquete (*):</label>
                        <div class="col-md-10 my-1">
                            <textarea class="form-control" name="descripcion_paquete" id="descripcion_paquete" rows="3" required></textarea>
                        </div>
                        <label for="precio_paquete" class="col-md-3 col-form-label my-1">Precio del paquete (*):</label>
                        <div class="col-md-3 my-1">
                            <input type="number" step="0.01" class="form-control" id="precio_paquete" name="precio_paquete" required>
                        </div>
                        <label for="costo_envio" class="col-md-3 col-form-label my-1">Costo de envío (*):</label>
                        <div class="col-md-3 my-1">
                            <input type="number" step="0.01" class="form-control" id="costo_envio" name="costo_envio" required>
                        </div>
                    </div>
                    <div class="text-body-secondary">
                        campos con (*) son obligatorios
                    </div>
                </div>
            </div>
            <button class="btn btn-primary" type="submit">Guardar paquete</button>
        </form>
    </div>
</div>

<!-- Modal para seleccionar vendedor -->
<div class="modal fade" id="modalVendedor" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Seleccionar vendedor</h1>
                <button type="button" class="btn-close cerrarModalSelecVendedor" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <section id="seccionBuscarVendedor">
                    <div style="display: flex; justify-content: center; margin-bottom: 5px;">
                        <label class="col-form-label me-2">¿No se encuentra registrado el vendedor?</label>
                        <button class="btn btn-primary" type="button" onclick="cambiarARegistrarVendedor()">Registrar vendedor</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered" id="tablaVendedores" style="width: 100%">
                            <thead>
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Teléfono</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </section>
                <section id="seccionRegistrarVendedor">
                    
                </section>
            </div>
        </div>
    </div>
</div>

<!-- Mensajito -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Destino seleccionado</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Su selección se ha guardado.
        </div>
    </div>
    <div class="toast destinoCompleto" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Destino seleccionado</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Seleccione un destino completo.
        </div>
    </div>
    <div class="toast seleccioneVendedor" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Seleccione un vendedor</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Debe seleccionar un vendedor para poder continuar.
        </div>
    </div>
</div>
</div>
<?php
require_once "Vistas/pie.php";
?>
<script src="Vistas/Recepcion/js/agregarPaquete.js"></script>
<script src="Vistas/js/registroVendedor.js"></script>