<?php
    include_once "Vistas/cabeza.php";
    include_once "Vistas/Repartidor/barraLateral.php";
?>
    <div class="card m-3 p-3">
        <div class="progress-bar">
            <div class="barraLLenado"></div>
            <div class="puntosProgreso">
                <div class="puntoProgreso">
                    <i data-feather="archive" style="transform: translateY(5px);"></i>
                    <span class="textoPuntos">En bodega</span>
                </div>
                <div class="puntoProgreso">
                    <i data-feather="truck" style="transform: translateY(5px);"></i>
                    <span class="textoPuntos">En ruta</span>
                </div>
                <div class="puntoProgreso">
                    <i data-feather="disc" style="transform: translateY(5px);"></i>
                    <span class="textoPuntos" id="palabraLarga">Listo para <span id="ajustarPeq">entregar</span></span>
                </div>
                <div class="puntoProgreso">
                    <i data-feather="check-circle" style="transform: translateY(5px);"></i>
                    <span class="textoPuntos">Entregado</span>
                </div>
            </div>
        </div>
    </div>    
    
    <div class="card m-3 p-3">
        <div style="background-color: paleturquoise; border-radius: 50px; padding: 10px; width: max-content; padding-right: 15px;" id="estado">

        </div>
        <h5 class="mt-2" id="titulo"></h5>
        <label id="mensaje"></label>
        <button class="btn btn-primary" onclick="empezarRuta()" id="btnEnCamino" style="max-width: 250px;">
            <i class="me-2 mb-1" data-feather="truck"></i> Voy en camino
        </button>
        <button class="btn btn-primary" onclick="listoEntregar()" id="btnListoEntregar" style="max-width: 250px;">
            <i class="me-2 mb-1" data-feather="disc"></i> Listo para entregar
        </button>
        <div id="paraFinalizar">
            <button class="btn btn-primary" onclick="entregado()" id="btnEntregado" style="max-width: 250px;">
                <i class="me-2 mb-1" data-feather="check-circle"></i> Entregado
            </button>
            <button class="btn btn-primary" onclick="noEntregado()" id="btnNoEntregado" style="max-width: 250px;">
                <i class="me-2 mb-1" data-feather="x-circle"></i> No entregado
            </button>
        </div>
    </div>

    <div class="card m-3 p-3">
        <div class="row">
            <div class="col-md-6 mt-2" id="infoPaquete">
                
            </div>
            <div class="col-md-6 mt-2">
                <div class="card p-2 h-100 text-center" id="tablaEstados">
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    require_once "Vistas/pie.php";
?>
<script src="Vistas/Repartidor/js/detallePaquete.js"></script>