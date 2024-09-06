<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - SIAX</title>
    <link rel="icon" href="Imagenes/logo.jpg">
    <!-- Feathericons v4.29-->
    <script src="https://unpkg.com/feather-icons"></script>
    <!-- Bootstrap v5.3.0 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- Animate.css v4.1.1 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="Vistas/css/registrarse.css">
</head>

<body>
    <div class="loader" id="paginaCarga">
        <div id="cargando"></div>
    </div>
    <div class="contenido">
        <div class="card m-3">
            <div class="card-header">
                <h5 class="text-center">Registrarte en Sistema Adara Xpress</h5>
            </div>
            <div class="card-body">
                <section class="opciones">
                    <label><strong>¿Cómo vas a usar nuestro sistema?</strong></label>
                    <div>
                        <button class="btnCliente btnsOpci activo"><i data-feather="user" class="me-2 mb-1"></i>Usar como cliente</button>
                        <button class="btnVendedor btnsOpci">Usar como vendedor<i data-feather="package" class="ms-2 mb-1"></i></button>
                    </div>
                </section>

                <section class="opcionesContenido">
                    <div class="card mb-3 opcionCliente animate__animated">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="Imagenes/entrega.jpg" class="img-fluid rounded-start opcionImagen" alt="Imagen de la entrega de paquete a un cliente">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body cuerpoContenido">
                                    <h5 class="card-title">¿Usaras nuestro sistema como cliente?</h5>
                                    <p class="card-text">Registrate como cliente para llevar el registro de todos los paquetes que
                                    compras. Podrás ver en detalle el movimiento de tus paquetes para saber cuando esten en ruta o están el su destino para ser retirados.</p>
                                    <a href="registroCliente" class="btn btn-secondary">Registrarse como cliente</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3 opcionVendedor animate__animated">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="Imagenes/graficos.jpg" class="img-fluid rounded-start opcionImagen" alt="Imagen de estadísticas para el vendedor">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body cuerpoContenido">
                                    <h5 class="card-title">¿Tienes un negocio y vendes productos?</h5>
                                    <p class="card-text">Registrate como vendedor para llevar un control de todos lospaquetes que vendes, el detalle
                                    de tus ganancias, clientes frecuentes, algunas estadísticas que te pueden servir y más.</p>
                                    <a href="registroVendedor" class="btn btn-secondary">Registrarse como vendedor</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="indicadores">
                    <div class="indicador indicarCliente activo"></div>
                    <div class="indicador indicarVendedor"></div>
                </section>

                <div class="card my-2 p-2 text-center">
                    <label><strong>¿Ya tienes una cuenta?</strong></label>
                    <div>
                        <a href="login">Iniciar sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- JQuery v3.6 -->
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
    <!-- Bootstrap v5.3.0 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="Vistas/js/registrarse.js"></script>
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