<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - SIAX</title>
    <link rel="icon" href="Imagenes/logo.jpg">
    <!-- Feathericons v4.29-->
    <script src="https://unpkg.com/feather-icons"></script>
    <!-- Bootstrap v5.3.0 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="Vistas/css/estilos.css">
</head>
<body>
    <div class="loader" id="paginaCarga"><div id="cargando"></div></div>

    <div style="position:fixed;left:0px;top:0px;width:100%;height:100%;display:flex;justify-content:center;align-items:center;">
        <div class="d-grid col-8 col-md-5 col-xxl-3 mx-auto">
            <div class="card">
                <h5 class="text-center mt-4">Sistema Adara Xpress</h5>
                <div class="card-body">
                    <form method="POST" action="" id="formAcceso" autocomplete="off">
                        <div class="mb-2">
                            <label for="name">Usuario</label>
                            <input autocomplete="off" id="nombre" type="text" class="form-control" name="nombre" tabindex="1" required autofocus placeholder="usuario">                            
                        </div>
                        <div class="mb-2">
                            <label for="password" class="control-label">Contraseña</label>
                            <input autocomplete="off" id="clave" type="password" class="form-control" name="clave" tabindex="2" required placeholder="contraseña">
                        </div>
                        <div class="d-grid col-6 mx-auto">
                            <button class="btn btn-primary" type="submit">Iniciar Sesión</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <label>¿Aún no te has registrado? <a href="registrarse">Registrate ahora</a></label>        
                </div>
            </div>
        </div>
    </div>
<?php require_once "Vistas/pie.php"; ?>
<script src="Vistas/js/login.js"></script>