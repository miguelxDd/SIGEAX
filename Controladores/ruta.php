<?php
//Iniciamos o retomamos la sesion
session_start();
//establecemos la zona horaria predeterminada a usar.
date_default_timezone_set('America/El_Salvador');
//Incluimos los modelos a usar
require_once "../Modelos/ruta.php";
require_once "../Componentes/componentes.php";
//Creamos los objetos para acceder a los metodos del modelo que se conecta a la base de datos
$ruta = new Ruta();
$componentes = new Componentes();
//Definimos el switch para realizar las diversas acciones segun sea el caso
switch($_GET['accion']){
    case 'listarRutas':
        $parRepartidor = (isset($_GET['paraRepartidor'])) ? true : false;
        if(isset($_GET['recepcion'])){
            $parRepartidor = true;
            $rutasL = $ruta->listarRutas();
        }else{
            $rutasL = $ruta->listarRutas($parRepartidor);
        }
        $rutasConFecha = obtenerFechasRutas($rutasL, $ruta, $parRepartidor);
        echo $componentes->rutas($rutasConFecha, $parRepartidor);
    break;
    case 'listarRutasAdmin':
        $rutasL = $ruta->listarRutas();
        echo $componentes->listarRutas($rutasL);
    break;
    case 'verDestinosRuta':
        $destinosRuta = $ruta->listarDestinos($_GET['rutaid']);
        echo $componentes->listarDestinosRuta($destinosRuta);
    break;
    case 'listarDestinos':
        $parRepartidor = (isset($_GET['paraRepartidor'])) ? true : false;
        if($parRepartidor){
            $destinosRuta = $ruta->listarDestinoRepartidor($_GET['ruta'], $_GET['fecha']);
            echo $componentes->destinos($destinosRuta, $parRepartidor);
        }else{
            $destinosRuta = $ruta->listarDestinos($_GET['ruta']);
            echo $componentes->destinos($destinosRuta);
        }
    break;
    //--------------------------------------------------------------------
    // para obtener el número de paquetes enviados a los 10 principales destinos (mayor número de paquetes)
    case 'destMasPaqVendedor':
        $destinos = $ruta->destMasPaqVendedor($_SESSION['usuarioID']);
        echo json_encode($destinos);
    break;
    //--------------------------------------------------------------------
    // para obtener la info de un destino específico, se llama para la vista ruta de recepcion
    case 'infoDestino':
        $destino = $ruta->listarDestinos($_GET['ruta'], $_GET['destino']);
        if(isset($_GET['admin'])){
            echo json_encode($destino);
        }else{
            echo $componentes->infoDestino($destino);
        }
    break;
    //--------------------------------------------------------------------
    // para finalizar un destino, se llama desde la vista destino del repartidor al momento de que este
    // da click en el boton de finalizar destino
    case 'finalizarDestino':
        $destino = $ruta->finalizarDestino($_GET['ruta'], $_GET['destino'], $_GET['fecha']);
        if($destino == 1){
            echo json_encode(['estado' => true, 'mensaje' => 'Destino finalizado']);
        }else{
            echo json_encode(['estado' => false, 'mensaje' => 'Error al finalizar destino']);
        }
    break;
    //--------------------------------------------------------------------
    // para obtener el día de una ruta específica, se llama desde la vista gestionarRutas del admin
    case 'infoDeRuta':
        $rutaR = $ruta->obtenerDiaRuta($_GET['rutaid']);
        if(count($rutaR) > 0){
            $rutasListadas = $ruta->listarRutas();
            echo json_encode(['estado' => true, 'dia' => $rutaR[0]['dia'], 'diasOcupados' => obtenerDiasOcupados($rutasListadas)]);
        }else{
            echo json_encode(['estado' => false, 'mensaje' => 'Error al obtener el día de la ruta']);
        }
    break;
    case 'diasOcupados':
        $rutasListadas = $ruta->listarRutas();
        echo json_encode(['estado' => true, 'diasOcupados' => obtenerDiasOcupados($rutasListadas)]);
    break;
    //--------------------------------------------------------------------
    // para agregar una nueva ruta, se llama desde la vista gestionarRutas del admin
    case 'guardarNuevaRuta':
        $rutaR = $ruta->guardarNuevaRuta($_GET['dia']);
        if($rutaR == 1){
            echo json_encode(['estado' => true, 'mensaje' => 'Ruta agregada']);
        }else{
            echo json_encode(['estado' => false, 'mensaje' => 'Error al agregar la ruta']);
        }
    break;
    //--------------------------------------------------------------------
    // para editar el día de una ruta específica, se llama desde la vista gestionarRutas del admin
    case 'guardarNuevoDiaRuta':
        $rutaR = $ruta->guardarNuevoDiaRuta($_GET['rutaid'], $_GET['dia']);
        if($rutaR == 1){
            echo json_encode(['estado' => true, 'mensaje' => 'Día de ruta actualizado']);
        }else{
            echo json_encode(['estado' => false, 'mensaje' => 'Error al actualizar el día de la ruta']);
        }
    break;
    //--------------------------------------------------------------------
    // para eliminar una ruta específica, se llama desde la vista gestionarRutas del admin
    case 'eliminarRuta':
        $rutaR = $ruta->eliminarRuta($_GET['rutaid']);
        if($rutaR == 1){
            echo json_encode(['estado' => true, 'mensaje' => 'Ruta eliminada']);
        }else{
            echo json_encode(['estado' => false, 'mensaje' => 'Error al eliminar la ruta']);
        }
    break;
    //--------------------------------------------------------------------
    // para eliminar un destino específico, se llama desde la vista gestionarRutas del admin
    case 'eliminarDestino':
        $destinoR = $ruta->eliminarDestino($_GET['destinoid']);
        if($destinoR == 1){
            echo json_encode(['estado' => true, 'mensaje' => 'Destino eliminado']);
        }else{
            echo json_encode(['estado' => false, 'mensaje' => 'Error al eliminar el destino']);
        }
    break;
    //--------------------------------------------------------------------
    // para editar un destino específico, se llama desde la vista gestionarRutas del admin
    case 'guardarEditarDestino':
        $datos = json_decode(file_get_contents("php://input"), true);
        $destinoR = $ruta->guardarEditarDestino($datos['destinoid'], $datos['lugar_destino'], $datos['descripcion_destino'], $datos['departamento']
                                                , $datos['municipio'], $datos['hora_inicio'], $datos['hora_fin']);
        if($destinoR == 1){
            echo json_encode(['estado' => true, 'mensaje' => 'Destino actualizado']);
        }else{
            echo json_encode(['estado' => false, 'mensaje' => 'Error al actualizar el destino']);
        }
    break;
    //--------------------------------------------------------------------
    // para guardar un nuevo destino, se llama desde la vista gestionarRutas del admin
    case 'guardarNuevoDestino':
        $datos = json_decode(file_get_contents("php://input"), true);
        $destinoR = $ruta->guardarNuevoDestino($datos['rutaid'], $datos['lugar_destino'], $datos['descripcion_destino'], $datos['departamento']
                                                , $datos['municipio'], $datos['hora_inicio'], $datos['hora_fin']);
        if($destinoR == 1){
            echo json_encode(['estado' => true, 'mensaje' => 'Destino agregado']);
        }else{
            echo json_encode(['estado' => false, 'mensaje' => 'Error al agregar el destino']);
        }
    break;
}

function obtenerFechasRutas($rutas, $ruta, $parRepartidor){
    $rutasConFecha = [];
    foreach($rutas as $r){
        $infoDestino = $ruta->obtenerFechaRuta($r['rutaID']);
        $dia = '';
        switch ($infoDestino['dia']){
            case 'Lunes': $dia = 'Monday'; break;
            case 'Martes': $dia = 'Tuesday'; break;
            case 'Miércoles': $dia = 'Wednesday'; break;
            case 'Jueves': $dia = 'Thursday'; break;
            case 'Viernes': $dia = 'Friday'; break;
            case 'Sábado': $dia = 'Saturday'; break;
            case 'Domingo': $dia = 'Sunday'; break;
            default:
            if($infoDestino['dia'] == 'Miercoles'){ $dia = 'Wednesday'; }
            if($infoDestino['dia'] == 'Sabado'){ $dia = 'Saturday'; }
            break;
        }
        if($parRepartidor){
            $array = ["rutaID" => $r['rutaID'], "dia" => $r['dia'] . ' (' . date('Y-m-d', strtotime('this '.$dia)) . ')'];
        }else{
            $array = ["rutaID" => $r['rutaID'], "dia" => $r['dia'] . ' (' . date('Y-m-d', strtotime('next '.$dia)) . ')'];
        }
        array_push($rutasConFecha, $array);
    }
    return $rutasConFecha;
}

function obtenerDiasOcupados($rutas){
    $dias = [];
    foreach($rutas as $ruta){
        switch ($ruta['dia']){
            case 'Lunes': array_push($dias, 'Lunes'); break;
            case 'Martes': array_push($dias, 'Martes'); break;
            case 'Miércoles': array_push($dias, 'Miércoles'); break;
            case 'Jueves': array_push($dias, 'Jueves'); break;
            case 'Viernes': array_push($dias, 'Viernes'); break;
            case 'Sábado': array_push($dias, 'Sábado'); break;
            case 'Domingo': array_push($dias, 'Domingo'); break;
            default:
                if($ruta['dia'] == 'Miercoles'){ array_push($dias, 'Miércoles'); }
                if($ruta['dia'] == 'Sabado'){ array_push($dias, 'Sábado'); }
            break;
        }
    }
    return $dias;
}
?>