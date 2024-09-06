<?php
include_once "Vistas/cabeza.php";
include_once "Vistas/Recepcion/barraLateral.php";
?>
<link rel="stylesheet" href="Vistas/Admin/css/estilos.css">
    <div class="card m-3 p-3">
        <h4>Gestiona las categorías de productos y sus productos para los costos de envío de referencia.</h4>
        <hr>
        <section class="row">
            <div class="col-md-6">
                <div class="card my-1">
                    <div class="card-header">
                        <h5 class="card-tittle text-center">Categorías</h5>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-primary" id="btnAgregarRuta" onclick="abrirModalAgregarCategoria()">
                            <i data-feather="plus"></i> Agregar categoría
                        </button>
                        <main class="listaRutas"></main>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card my-1">
                    <div class="card-header">
                        <h5 class="card-tittle text-center">Productos</h5>
                    </div>
                    <div class="card-body" id="cuerpoDestinos">
                        <h5 class="text-center">Seleccione una categoría.</h5>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<section class="contenedorModal" id="modalEditarCategoria">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title fs-5" id="tituloModalEditarCategoria"></h1>
        </div>
        <div class="card-body">
            <h5 id="mensajeModalEditarCategoria"></h5>
            <form class="row p-2" id="formInfoCategoria">
                <div class="mb-3">
                    <label for="nombre_categoria" class="form-label">Nombre de la categoría (*)</label>
                    <input type="text" class="form-control" name="nombre_categoria" id="nombre_categoria" placeholder="Electrodomésticos">
                </div>
            </form>
        </div>
        <footer class="card-footer">
            <button type="button" class="btn btn-secondary" onclick="cerrarModalEditarCategoria()">Cancelar</button>
            <button type="button" class="btn btn-primary" onclick="guardarNuevaCategoria()">Aceptar</button>
        </footer>
    </div>
</section>

<section class="contenedorModal" id="modalEditarProducto">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title fs-5" id="tituloModalEditarProducto"></h1>
        </div>
        <div class="modal-body">
            <h5 id="mensajeModalEditarProducto" class="text-center mt-2"></h5>
            <form class="row p-2" id="formInfoProducto">
                <div class="mb-3">
                    <label for="nombre_producto" class="form-label">Nombre producto (*)</label>
                    <input type="text" class="form-control" name="nombre_producto" id="nombre_producto">
                </div>
                <div class="mb-3">
                    <label for="costo_estimado" class="form-label">Costo estimado de envío (*)</label>
                    <input type="number" step="0.01" class="form-control" name="costo_estimado" id="costo_estimado">
                </div>                
            </form>
        </div>
        <footer class="card-footer">
            <button type="button" class="btn btn-secondary" onclick="cerrarModalEditarProducto()">Cancelar</button>
            <button type="button" class="btn btn-primary" onclick="guardarNuevoProducto()">Aceptar</button>
        </footer>
    </div>
</section>

<?php
require_once "Vistas/pie.php";
?>

<script src="Vistas/Admin/js/gestionarCatalogo.js"></script>