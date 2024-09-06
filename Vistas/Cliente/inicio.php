<?php
    include_once "Vistas/cabeza.php";
    include_once "Vistas/Cliente/barraLateral.php";
    include_once "Modelos/consultas.php";
    $consultar = new Consulta();
?>
    <div class="card m-3 p-3">
        <div class="card p-3 mb-2">
            <h3>Bienvenid@ <?php echo $_SESSION['nombre'] ?></h3>
        </div>

        <div class="row">
            <div class="col-md-6 mt-2">
                <div class="card text-center p-4 h-100 tarjInicio">
                    <?php $respuesta = $consultar->numPaquetesPendientes($_SESSION['usuarioID']) ?>
                    <h4>Tienes <?php echo $respuesta['numero'] ?> paquetes pendientes</h4>
                    <a href="historialOrdenes">
                        <i data-feather="arrow-right" class="me-2 mb-1"></i>Ver mis órdenes
                    </a>
                </div>
            </div>
            <div class="col-md-6 mt-2">
                <div class="card text-center p-4 h-100 tarjInicio">
                    <?php $respuesta = $consultar->numPaquetesCompletados($_SESSION['usuarioID']) ?>
                    <h4>Tienes <?php echo $respuesta['numero'] ?> paquetes completados</h4>
                    <a href="historialOrdenes">
                        <i data-feather="arrow-right" class="me-2 mb-1"></i>Ver mis órdenes
                    </a>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="card p-2 mb-2 col-11 col-sm-8 col-lg-5 col-xxl-4 m-auto">
                <h5 class="mt-2 text-center">Visita el perfil de Facebook de estos vendedores</h5>
                <table class="table table-striped table-hover text-center" id="tablaPerfilVendedores">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
    require_once "Vistas/pie.php";
?>
<script src="Vistas/Cliente/js/inicioCliente.js"></script>