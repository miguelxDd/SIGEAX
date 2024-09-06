<?php
    include_once "Vistas/cabeza.php";
    include_once "Vistas/Cliente/barraLateral.php";
?>
    <div class="card m-3 p-3">
        <div class="cad-header text-center">
            <h4>Mis órdenes</h4>
            <hr>
        </div>
        <div class="card-body">
            <div class="mb-3 row">
                <label for="tipoVista" class="col-md-2 col-form-label">Ver en vista: </label>
                <div class="col-md-3">
                    <select class="form-select" id="tipoVista">
                        <option value="detalles" selected>Detalles</option>
                        <option value="tabla">Tabla</option>                    
                    </select>
                </div>
                <label for="tipoEnvio" class="col-md-2 col-form-label">Mostrar paquetes: </label>
                <div class="col-md-3">
                    <select class="form-select" id="tipoEnvio">
                        <option value="normal" selected>Envio normal</option>
                        <option value="personalizado">Envio personalizado</option>                    
                    </select>
                </div>
                <div class="col-md-2">
                    <a class="btn btn-primary" href="paquetesPorVendedor" role="button">Filtrar por vendedor</a>
                </div>
            </div>
            <hr>
            <div class="table-responsive p-1" id="contenedorTabla">
                
            </div>



            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="contenedorDetalles"> 
                
            </div>
            <div id="controlPaginacion" class="mt-3 text-end">

            </div>            
        </div>
    </div>
</div>
    
<?php
    require_once "Vistas/pie.php";
?>
<script src="Vistas/Cliente/js/historialOrdenes.js"></script>