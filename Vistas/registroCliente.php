<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar cliente - SIAX</title>
    <link rel="icon" href="Imagenes/logo.jpg">
    <!-- Feathericons v4.29-->
    <script src="https://unpkg.com/feather-icons"></script>
    <!-- Bootstrap v5.3.0 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- Animate.css v4.1.1 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="Vistas/css/registros.css">
</head>

<body>
    <div class="loader" id="paginaCarga">
        <div id="cargando"></div>
    </div>
    <div class="contenido">
        <div class="card m-3">
            <div class="card-header">
                <h4 class="text-center">Registro de cliente</h4>
            </div>
            <div class="card-body">
                <main class="pasosRegistro">
                    <section class="paso1 animate__animated">
                        <h5 class="text-center">Información personal</h5>
                        <p class="text-center"><small class="text-body-secondary">Todos los campos son obligatorios</small></p>
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-warning alert-dismissible" role="alert">
                                    <strong>¡Advertencia!</strong> Asegurese de llenar todos los campos.
                                    <button type="button" class="btn-close"></button>
                                </div>
                                <div class="alert alert-warning alert-dismissible" role="alert">
                                    <strong>¡Advertencia!</strong> Debes aceptar los términos y condiciones.
                                    <button type="button" class="btn-close"></button>
                                </div>
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <strong>¡Error!</strong> Ingrese un número de teléfono válido.
                                    <button type="button" class="btn-close"></button>
                                </div>
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <strong>¡Error!</strong> Ingrese un número de documento válido.
                                    <button type="button" class="btn-close"></button>
                                </div>
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <strong>¡Error!</strong> Ha ocurrido un error inesperado. Intente nuevamente.
                                    <button type="button" class="btn-close"></button>
                                </div>
                            </div>
                        </div>
                        <form class="row g-3 mb-2" id="informacionCliente">
                            <div class="col-md-8">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="col-md-4">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" required>
                            </div>
                            <div class="col-12">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Col. La Colonia Av. Avenida #123" required>
                            </div>
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
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terminosCondiciones" name="terminosCondiciones">
                                    <label class="form-check-label" for="terminosCondiciones">
                                        Acepto los términos y condiciones
                                    </label>
                                </div>
                            </div>
                            <button type="submit" id="submitParte1" hidden></button>
                        </form>
                    </section>

                    <section class="paso2 animate__animated">
                        <h5 class="text-center">Información de inicio de sesión</h5>
                        <p class="text-center">Cree un usuario y contraseña para iniciar sesión en el sistema</p>
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <strong>¡Error!</strong> No se pudo registrar el cliente.
                                    <button type="button" class="btn-close"></button>
                                </div>
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <strong>¡Éxito!</strong> Se registró el cliente correctamente. Se te redireccionará al inicio de sesión para que inicies sesión con tu nuevo usuario.
                                    <button type="button" class="btn-close"></button>
                                </div>
                                <div class="alert alert-warning alert-dismissible" role="alert">
                                    <strong>¡Advertencia!</strong> El nombre de usuario no está disponible. Intente con otro.
                                    <button type="button" class="btn-close"></button>
                                </div>
                                <div class="alert alert-warning alert-dismissible" role="alert">
                                    <strong>¡Advertencia!</strong> Las contraseñas no coinciden.
                                    <button type="button" class="btn-close"></button>
                                </div>
                                <div class="alert alert-warning alert-dismissible" role="alert">
                                    <strong>¡Advertencia!</strong> Usuario demasiado corto.
                                    <button type="button" class="btn-close"></button>
                                </div>
                            </div>
                        </div>
                        <form class="row g-3 mb-2" id="infoUsuario">
                            <div class="col-12">
                                <label for="user" class="form-label">Nombre de usuario</label>
                                <input type="text" class="form-control" id="user" name="user" required>
                                <small class="text-body-secondary">Escriba un usuario de por lo menos 5 caracteres</small>
                            </div>
                            <div class="col-12">
                                <label for="pass" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="pass" name="pass" required>
                            </div>
                            <div class="col-12">
                                <label for="pass2" class="form-label">Confirmar contraseña</label>
                                <input type="password" class="form-control" id="pass2" name="pass2" required>
                            </div>
                            <button type="submit" id="submitParte2" hidden></button>
                        </form>
                    </section>
                </main>
                <footer class="botonesForm">
                    <button type="button" class="btn btn-secondary" id="btnCancelar"><i data-feather="x" class="me-1 mb-1"></i>Cancelar</button>
                    <div class="contenedorIndicadores">
                        <section class="indicadores">
                            <div class="indicador indicarPaso1 activo"></div>
                            <div class="indicador indicarPaso2"></div>
                        </section>
                        <small class="text-body-secondary" id="pasoActual">Paso 1 de 2</small>
                    </div>
                    <button type="button" class="btn btn-secondary" id="bntContinuar">Siguiente<i data-feather="arrow-right" class="ms-1 mb-1"></i></button>
                </footer>
            </div>
        </div>
    </div>
    <!-- JQuery v3.6 -->
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
    <!-- Bootstrap v5.3.0 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="Vistas/js/registroCliente.js"></script>
    <script>
        //Para insertar los iconos Father
        feather.replace();
        //Quitamos animacion de carga cuando se carga todo el documento
        document.addEventListener("DOMContentLoaded", function(event) {
            const carag = document.getElementById('paginaCarga');
            carag.classList.remove('loader');
            carag.innerHTML = '';
        });
    </script>
</body>

</html>