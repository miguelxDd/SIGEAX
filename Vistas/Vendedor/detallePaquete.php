<?php
    include_once "Vistas/cabeza.php";
    include_once "Vistas/Vendedor/barraLateral.php";
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
        <!-- <label id="mensaje"></label> -->
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
<script src="Vistas/Vendedor/js/detallePaquete.js"></script>