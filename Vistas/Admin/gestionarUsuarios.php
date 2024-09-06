<?php
include_once "Vistas/cabeza.php";
include_once "Vistas/Admin/barraLateral.php";
?>
    <div class="card m-3">
        <div class="card-header">
            <h3>Gestionar usuarios registrados en el sistema</h3>
        </div>
        <div class="card-body">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <i data-feather="user-plus" class="me-2"></i> Agregar usuario
            </button>
            <hr>
            <h5 class="text-center">Usuarios registrados</h5>
            <div class="table-responsive p-1">
                <table class="table table-bordered table-striped" id="usuarios">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Tipo usuario</th>
                            <th>Fecha de creación</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <hr>
            <h5 class="text-center">Usuarios desactivados</h5>
            <div class="table-responsive p-1">
                <table class="table table-bordered table-striped" id="usuariosDesactivados">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Tipo usuario</th>
                            <th>Fecha de creación</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Agregar nuevo usuario</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <label class="col-md-4 col-form-label">Tipo de usuario</label>
                    <div class="col-md-8">
                        <select class="form-select" id="tipoUsuario">
                            <option value="cliente">Cliente</option>
                            <option value="recepcion">Recepcion</option>
                            <option value="vendedor">Vendedor</option>
                            <option value="repartidor">Repartidor</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="agregarUsuario()">Continuar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once "Vistas/pie.php";
?>
<script src="Vistas/Admin/js/gestionarUsuarios.js"></script>