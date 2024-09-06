<?php
include_once "Vistas/cabeza.php";
include_once "Vistas/Admin/barraLateral.php";
?>
    <div class="card m-3">
        <div class="card-header">
            <h3 class="text-center">Información del usuario</h3>
        </div>
        <div class="card-body">
            <form class="row g-3 mb-2" id="informacionCliente">
                <h5 class="text-center">Datos personales</h5>
                <div class="col-md-8">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="col-md-4">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="tel" class="form-control" id="telefono" name="telefono" required>
                </div>
                <div id="paraClientes">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="departamento" class="form-label">Departamento</label>
                            <select id="departamento" name="departamento" class="form-select">
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="municipio" class="form-label">Municipio</label>
                            <select id="municipio" name="municipio" class="form-select">
                                <option value="0" selected>Seleccione departamento...</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Col. La Colonia Av. Avenida #123" required>
                </div>
                <div class="col-md-6">
                    <label for="documento" class="form-label">Documento</label>
                    <select id="documento" name="documento" class="form-select">
                        <option selected value="dui">DUI</option>
                        <option value="nit">NIT</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="num_documento" class="form-label">Número de documento</label>
                    <input type="text" class="form-control" id="num_documento" name="num_documento" required>
                    <small class="text-body-secondary">Escriba solo los números sin guiones ni espacios</small>
                </div>
                <section style="display: flex; gap: 5px; justify-content: center; margin-bottom: 5px;">
                    <button type="button" class="btn btn-primary" id="btnEditarInfoPersonal">
                        <i data-feather="edit" class="me-2"></i>Editar información personal
                    </button>
                    <button type="button" class="btn btn-primary" id="btnGuardarInfoPersonal">
                        <i data-feather="check" class="me-2"></i>Guardar cambios
                    </button>
                    <button type="button" class="btn btn-primary" id="btnCancelarInfoPersonal">
                        <i data-feather="x" class="me-2"></i>Cancelar
                    </button>
                </section>
                <button type="submit" id="submitParte1" hidden></button>
            </form>

            <form class="g-3 mb-2 paraClientes" id="informacionNegocio">
                <hr>
                <h5 class="text-center">Datos del negocio</h5>
                <section class="row">

                    <div class="col-md-6">
                        <section class="contenedorImagen">
                            <img src="Imagenes/negocioDefecto.png" alt="Logo del negocio" id="imagen del negocio" width="250" height="250">
                        </section>
                    </div>
                    <div class="col-md-6">
                        <section class="seccionInputImagen">
                            <label for="logo_negocio" class="form-label">Logo o imagen para tu negocio</label>
                            <input class="form-control" type="file" id="logo_negocio" name="logo_negocio">
                            <button type="button" class="btn btn-secondary mt-2" onclick="eliminarLogoNeg()"><i data-feather="x" class="me-1 mb-1"></i>Eliminar imagen</button>
                        </section>
                    </div>
                    <div class="col-md-8">
                        <label for="nombre_negocio" class="form-label">Nombre de tu negocio</label>
                        <input type="text" class="form-control" id="nombre_negocio" name="nombre_negocio" required>
                    </div>
                    <div class="col-md-4">
                        <label for="telefono_negocio" class="form-label">Teléfono del negocio</label>
                        <input type="tel" class="form-control" id="telefono_negocio" name="telefono_negocio" required>
                    </div>
                    <div class="col-md-8">
                        <label for="direccion_negocio" class="form-label">Dirección del negocio</label>
                        <input type="text" class="form-control" id="direccion_negocio" name="direccion_negocio" placeholder="Col. La Colonia Av. Avenida #123" required>
                    </div>
                    <div class="col-md-4">
                        <label for="correo_negocio" class="form-label">Correo del negocio</label>
                        <input type="mail" class="form-control" id="correo_negocio" name="correo_negocio" placeholder="negocio@ejemplo.com" required>
                    </div>
                    <div class="col-md-6">
                        <label for="departamento_negocio" class="form-label">Departamento</label>
                        <select id="departamento_negocio" name="departamento_negocio" class="form-select">
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="municipio_negocio" class="form-label">Municipio</label>
                        <select id="municipio_negocio" name="municipio_negocio" class="form-select">
                            <option value="0" selected>Seleccione departamento...</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="documento_negocio" class="form-label">Documento</label>
                        <select id="documento_negocio" name="documento_negocio" class="form-select">
                            <option value="nit">NIT</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="num_documento_negocio" class="form-label">Número de documento</label>
                        <input type="text" class="form-control" id="num_documento_negocio" name="num_documento_negocio" required>
                        <small class="text-body-secondary">Escriba solo los números sin guiones ni espacios</small>
                    </div>
                    <div class="col-md-6">
                        <label for="link" class="form-label">Link de página o perfil de Facebook (opcional)</label>
                        <input type="text" class="form-control" id="link" name="link" placeholder="https://www.facebook.com/">
                    </div>
                    <div class="col-md-6" style="display: flex; justify-content: center; align-items: flex-end; margin-bottom: 5px;">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="promocionar" name="promocionar">
                            <label class="form-check-label" for="promocionar">
                                Promocionar este negocio
                            </label>
                        </div>
                    </div>
                    <section style="display: flex; gap: 5px; justify-content: center; margin-top: 5px;">
                        <button type="button" class="btn btn-primary" id="btnEditarInfoNegocio">
                            <i data-feather="edit" class="me-2"></i>Editar información del negocio
                        </button>
                        <button type="button" class="btn btn-primary" id="btnGuardarInfoNegocio">
                            <i data-feather="check" class="me-2"></i>Guardar cambios
                        </button>
                        <button type="button" class="btn btn-primary" id="btnCancelarInfoNegocio">
                            <i data-feather="x" class="me-2"></i>Cancelar
                        </button>
                    </section>
                    <button type="submit" id="submitParte2" hidden></button>
                </section>
            </form>
            <hr>
            <form class="row g-3 mb-2" id="infoUsuario">
                <h5 class="text-center">Datos de usuario</h5>
                <div class="col-12">
                    <label for="user" class="form-label">Nombre de usuario</label>
                    <input type="text" class="form-control" id="user" name="user" required>
                    <small class="text-body-secondary">Escriba un usuario de por lo menos 5 caracteres</small>
                </div>
                <div id="cambiarContra">
                    <div class="col-12">
                        <label for="pass" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="pass" name="pass">
                    </div>
                </div>
                <section style="display: flex; gap: 5px; justify-content: center;">
                    <button type="button" class="btn btn-primary" id="btnEditarInfoUsuario">
                        <i data-feather="edit" class="me-2"></i>Editar nombre de usuario
                    </button>
                    <button type="button" class="btn btn-primary" id="btnGuardarInfoUsuario">
                        <i data-feather="check" class="me-2"></i>Guardar cambios
                    </button>
                    <button type="button" class="btn btn-primary" id="btnCancelarInfoUsuario">
                        <i data-feather="x" class="me-2"></i>Cancelar
                    </button>
                    <button type="button" class="btn btn-primary" id="btnCambiarContrasena">
                        <i data-feather="key" class="me-2"></i>Cambiar contraseña
                    </button>
                    <button type="button" class="btn btn-primary" id="btnGuardarContrasena">
                        <i data-feather="check" class="me-2"></i>Guardar contraseña
                    </button>
                    <button type="button" class="btn btn-primary" id="btnCancelarContrasena">
                        <i data-feather="x" class="me-2"></i>Cancelar
                    </button>
                </section>
                <button type="submit" id="submitParte3" hidden></button>
            </form>
        </div>
    </div>
</div>

<?php
require_once "Vistas/pie.php";
?>
<script src="Vistas/Admin/js/mostrarUsuario.js"></script>