<?php
include_once "Vistas/cabeza.php";
include_once "Vistas/Recepcion/barraLateral.php";
?>
<link rel="stylesheet" href="Vistas/Admin/css/estilos.css">
    <div class="card m-3 p-3">
        <h4>Gestión de rutas y sus destinos.</h4>
        <hr>
        <section class="row">
            <div class="col-md-6">
                <div class="card my-1">
                    <div class="card-header">
                        <h5 class="card-tittle text-center">Rutas</h5>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-primary" id="btnAgregarRuta" onclick="abrirModalAgregarRuta()">
                            <i data-feather="plus"></i> Agregar ruta
                        </button>
                        <main class="listaRutas"></main>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card my-1">
                    <div class="card-header">
                        <h5 class="card-tittle text-center">Destinos</h5>
                    </div>
                    <div class="card-body" id="cuerpoDestinos">
                        <h5 class="text-center">Seleccione una ruta.</h5>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Modal para editar ruta -->
<section class="contenedorModal" id="modalEditarRuta">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title fs-5" id="tituloModalEditarRuta"></h1>
        </div>
        <div class="card-body">
            <h5 id="mensajeModalEditarRuta"></h5>
            <section class="contenedorDiasSemana">
                <div class="rutaDia semana"><h5>Lunes</h5></div>
                <div class="rutaDia semana"><h5>Martes</h5></div>
                <div class="rutaDia semana"><h5>Miércoles</h5></div>
                <div class="rutaDia semana"><h5>Jueves</h5></div>
                <div class="rutaDia semana"><h5>Viernes</h5></div>
                <div class="rutaDia semana"><h5>Sábado</h5></div>
                <div class="rutaDia semana"><h5>Domingo</h5></div>
            </section>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-secondary" onclick="cerrarModalEditarRuta()">Cancelar</button>
            <button type="button" class="btn btn-primary" onclick="guardarNuevoDiaRuta()">Aceptar</button>
        </div>
    </div>
</section>

<!-- Modal para editar/agregar un destino -->
<section class="contenedorModal" id="modalEditarDestino">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title fs-5" id="tituloModalEditarDestino"></h1>
        </div>
        <div class="modal-body">
            <h5 id="mensajeModalEditarDestino" class="text-center mt-2"></h5>
            <form class="row p-2" id="formInfoDestino">
                <div class="mb-3">
                    <label for="lugar_destino" class="form-label">Lugar de destino (*)</label>
                    <input type="text" class="form-control" name="lugar_destino" id="lugar_destino" placeholder="Metrocentro">
                </div>
                <div class="mb-3">
                    <label for="descripcion_destino" class="form-label">Descripción:</label>
                    <input type="text" class="form-control" name="descripcion_destino" id="descripcion_destino" placeholder="Frente al selectos">
                </div>
                <div class="col-md-6">
                    <label for="departamento" class="form-label">Departamento (*)</label>
                    <select id="departamento" name="departamento" class="form-select">
                        <option value="0">Seleccione un departamento</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="municipio" class="form-label">Municipio (*)</label>
                    <select id="municipio" name="municipio" class="form-select">
                        <option value="0" selected>Seleccione un municipio</option>        
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="hora_inicio" class="form-label">Hora inicio (*)</label>
                    <input type="time" class="form-control" name="hora_inicio" id="hora_inicio">
                </div>
                <div class="col-md-6">
                    <label for="hora_fin" class="form-label">Hora fin (*)</label>
                    <input type="time" class="form-control" name="hora_fin" id="hora_fin">
                </div>
            </form>
        </div>
        <footer class="card-body">
            <button type="button" class="btn btn-secondary" onclick="cerrarModalEditarDestino()">Cancelar</button>
            <button type="button" class="btn btn-primary" onclick="guardarNuevoDestino()">Aceptar</button>
        </footer>
    </div>
</section>

<?php
require_once "Vistas/pie.php";
?>

<script src="Vistas/Admin/js/gestionarRutas.js"></script>