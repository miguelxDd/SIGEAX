<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar vendedor - SIAX</title>
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
                <h4 class="text-center">Registro de vendedor</h4>
            </div>
            <div class="card-body" id="insertarRegistroAqui">
                
            </div>
        </div>
    </div>
    <!-- JQuery v3.6 -->
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
    <!-- Bootstrap v5.3.0 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="Vistas/js/global.js"></script>
    <script src="Vistas/js/componentes.js"></script>
    <script src="Vistas/Admin/js/registroVendedor.js"></script>
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