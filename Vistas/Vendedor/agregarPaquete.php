<?php
    include_once "Vistas/cabeza.php";
    include_once "Vistas/Vendedor/barraLateral.php";
?>
    <div class="card m-3 p-3">
        <div class="cad-header text-center">
            <h4>Agregar un paquete</h4>
            <hr>
        </div>
        <div class="card-body">
            <form action="" method="post" id="formAgregarPaquete">
                <div class="card my-2 infoFormularios">
                    <div class="card-header">
                        Información del cliente <i data-feather="chevron-up" class="ms-2 mb-1"></i>
                    </div>
                    <div class="card-body" id="formCliente">
                        <div class="mb-2 row">
                            <label for="nombre_cliente" class="col-md-2 col-form-label">Nombre (*):</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" maxlength=5 required>
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
                            <label for="precio_paquete" class="col-12 col-form-label mt-1">
                                Seleccione algún producto de la lista que se asemeje lo más posible al contenido del paquete para que obtenga 
                                un estimado del costo de envío. 
                                <p class="text-body-secondary">
                                    Este costo de envio es solo un estimado, puede variar al momento que se acerque a entregar el paquete.
                                </p>
                            </label>
                            <label for="categoria_producto" class="col-md-2 col-form-label">Categoria:</label>
                            <div class="col-md-4">
                                <select name="categoria_producto" id="categoria_producto" class="form-select">
                                    
                                </select>
                            </div>
                            <div class="col-md-6 d-flex" id="colProductosCat">

                            </div>
                            <label class="col-12 col-form-label">Estimación del costo de envío: <strong id="labelEstimacion">$0.00</strong></label>
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
    </div>
</div>
<?php
    require_once "Vistas/pie.php";
?>
<script src="Vistas/Vendedor/js/agregarPaquete.js"></script>