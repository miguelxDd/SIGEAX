<?php
//reaunudamos la sesion
session_start();
if(isset($_GET['url'])){
    if(isset($_SESSION['usuarioID'])){
        $yaEntro = false;
        switch($_SESSION['tipo_usuario']){
            case 'cliente':
                // Vistas para clientes
                if($_GET['url'] == 'inicio'
                || $_GET['url'] == 'historialOrdenes'
                || $_GET['url'] == 'paquetesPorVendedor'
                || $_GET['url'] == 'detallePaquete'){
                    $yaEntro = true;
                    include "Vistas/Cliente/".$_GET['url'].".php";
                }
                break;
            case 'vendedor':
                // Vistas para vendedores
                if($_GET['url'] == 'inicio'
                || $_GET['url'] == 'agregarPaquete'
                || $_GET['url'] == 'paquetesVendedor'
                || $_GET['url'] == 'verPaquete'
                || $_GET['url'] == 'estadisticasVendedor'
                || $_GET['url'] == 'remuneraciones'
                || $_GET['url'] == 'detallePaquete'
                || $_GET['url'] == 'estadisticasDestinos'){
                    $yaEntro = true;
                    include "Vistas/Vendedor/".$_GET['url'].".php";
                }
                break;
            case 'recepcion':
                //Vistas para recepcion
                if($_GET['url'] == 'inicio'
                || $_GET['url'] == 'agregarPaquete'
                || $_GET['url'] == 'registrarVendedor'
                || $_GET['url'] == 'rutas'
                || $_GET['url'] == 'noRetirados'
                || $_GET['url'] == 'paquetesRecibir'){
                    $yaEntro = true;
                    include "Vistas/Recepcion/".$_GET['url'].".php";
                }
                break;
            case 'repartidor':
                    //Vistas para repartidor
                    if($_GET['url'] == 'inicio'
                    || $_GET['url'] == 'paquetesPersonalizado'
                    || $_GET['url'] == 'destino'
                    || $_GET['url'] == 'detallePaquete'
                    || $_GET['url'] == 'paquetesNormal'){
                        $yaEntro = true;
                        include "Vistas/Repartidor/".$_GET['url'].".php";
                    }
                break;
            case 'admin':
                //Vistas para el administrador
                if($_GET['url'] == 'inicio'
                || $_GET['url'] == 'gestionarRutas'
                || $_GET['url'] == 'gestionarCatalogoReferencia'
                || $_GET['url'] == 'infoFinanciera'
                || $_GET['url'] == 'gestionarUsuarios'
                || $_GET['url'] == 'registroCliente'
                || $_GET['url'] == 'registroVendedor'
                || $_GET['url'] == 'mostrarUsuario'
                || $_GET['url'] == 'reportes'
                || $_GET['url'] == 'registroEmpleado'
                || $_GET['url'] == 'registrarVendedor'){
                    $yaEntro = true;
                    include "Vistas/Admin/".$_GET['url'].".php";
                }
                break;
        }
        if($_GET['url'] == 'cerrarSesion'){
            include "Vistas/".$_GET['url'].".php";
        }else{
            if(!$yaEntro){
                include "Vistas/404.php";
            }
        }        
    }else{
        // Vistas para usuarios no registrados
        if($_GET['url'] == 'login'
        || $_GET['url'] == 'registrarse'
        || $_GET['url'] == 'registroCliente'
        || $_GET['url'] == 'inicio'
        || $_GET['url'] == 'registroVendedor'){
            if($_GET['url'] == 'inicio'){ // Si no esta logueado y quiere ir a inicio, lo mandamos a login
                header("location: login");
            }else{
                include "Vistas/".$_GET['url'].".php";
            }
        }else{
            include "Vistas/404.php";
        }
    }
}else{
    include "Vistas/login.php";
}