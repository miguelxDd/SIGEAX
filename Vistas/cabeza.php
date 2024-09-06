<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAX</title>
    <link rel="icon" href="Imagenes/logo.jpg">
    <!-- Feathericons v4.29-->
    <script src="https://unpkg.com/feather-icons"></script>
    <!-- Bootstrap v5.3.0 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- DATATABLES -->
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.6/b-2.4.2/b-html5-2.4.2/datatables.min.css" rel="stylesheet">
    <!-- Animate.css v4.1.1 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="Vistas/css/estilos.css">
</head>
<body>
    <div class="loader" id="paginaCarga"><div id="cargando"></div></div>
    <div class="contenido">
        <header>
            <nav class="navbar navbar-expand-lg bg-primary-subtle mt-3 mx-3 rounded-3">
                <div class="container-fluid">
                    <div class="d-flex">
                        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#barraLateral" aria-controls="offcanvasExample">
                            <i data-feather="align-justify"></i>
                        </button>
                        <h4 class="mx-3 my-auto">Adara Xpress</h4>
                    </div>            
                    <div class="d-flex">
                        <div class="dropdown dropstart">
                            <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 50%; padding: 0px">
                                <img src="https://th.bing.com/th/id/R.8e2c571ff125b3531705198a15d3103c?rik=gzhbzBpXBa%2bxMA&riu=http%3a%2f%2fpluspng.com%2fimg-png%2fuser-png-icon-big-image-png-2240.png&ehk=VeWsrun%2fvDy5QDv2Z6Xm8XnIMXyeaz2fhR3AgxlvxAc%3d&risl=&pid=ImgRaw&r=0"
                                alt="foto de perfil" style="width: 30px; height: 30px;">
                            </button>
                            <ul class="dropdown-menu">
                                <label class="mx-2"><?php echo ($_SESSION['tipo_usuario'] == 'admin')? 'Aministrador' : $_SESSION['nombre'] ?></label> <hr style="margin: 5px 0 0 0;">
                                <li><a class="dropdown-item" href="perfil">Perfil</a></li>
                                <li><a class="dropdown-item" href="cerrarSesion">Cerrar Sesión</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
    