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
            <div id="contenedorTabla2">
                
            </div>         
            <div class="table-responsive" id="contenedorTabla">
                
            </div>
        </div>
    </div>
</div>
<?php
    require_once "Vistas/pie.php";
?>
<script src="Vistas/Cliente/js/paquetesPorVendedor.js"></script>