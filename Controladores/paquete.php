<?php
//Iniciamos o retomamos la sesion
session_start();
//establecemos la zona horaria predeterminada a usar.
date_default_timezone_set('America/El_Salvador');
//Incluimos los modelos a usar
require_once "../Modelos/paquete.php";
require_once "../Modelos/usuario.php";
require_once "../Modelos/ruta.php";
//incluimos los componentes
require_once "../Componentes/componentes.php";
//Creamos los objetos para acceder a los metodos del modelo que se conecta a la base de datos
$paquete = new Paquete();
$usuario = new User();
$ruta = new Ruta();
$componentes = new Componentes();
//Definimos el switch para realizar las diversas acciones segun sea el caso
switch($_GET['accion']){
    //---------- Para listar todos los paquetes de envio normal en la vista de detalle Paquete de un cliente------------------    
    case 'listarNormales':
        $respuesta = $paquete->listar($_SESSION['usuarioID']);
        if($_GET['vista'] == 'tabla'){
            foreach($respuesta as $reg){
                $paquetes[]=array(
                "0"=>$reg['identificador'],
                "1"=>$reg['descripcion'],
                "2"=>$reg['fecha'],
                "3"=>'$' . $reg['total'],
                "4"=>$reg['destino'],
                "5"=>$reg['estado'],
                "6"=>'<a class="btn btn-primary" href="detallePaquete" role="button" onclick="verDetalle('.$reg['paqueteID'].', \'Envio normal\')">Ver detalles</a>',
                );
            }
            $results=array(
                 "sEcho"=>1,//info para datatables
                 "iTotalRecords"=>count($paquetes),//enviamos el total de registros al datatable
                 "iTotalDisplayRecords"=>count($paquetes),//enviamos el total de registros a visualizar
                 "aaData"=>$paquetes);
            echo json_encode($results);
        }else{
            $vistahtml = '';
            $respuestaArray = array();
            foreach($respuesta as $reg){
                $vistahtml .= $componentes->vistaDetallePaquete($reg['estado'], 'Envio normal', $reg['vendedor'], $reg['descripcion'], $reg['precio'], $reg['costo_envio'], $reg['destino'], obtenerFechaParaNormal($reg['rutaID'], $reg['destinoID'], $ruta, $reg['fecha'], true), $reg['paqueteID'], $reg['identificador']);
                array_push($respuestaArray, $vistahtml); $vistahtml = '';
            }
            echo json_encode($respuestaArray);
        }
    break;
    //-----------------------------------------------------------------------------------------------------------------
    //para listar los paquetes de envio normal de un vendedor, vista paquetesVendedor
    case 'paquetesNormalesVendedor':
        $paquetes = $paquete->listarNormalesVendedor($_SESSION['idcliente']);
        $paquetee = array();
        foreach($paquetes as $paque){
            $paquetee[]=array(
            "0"=>$paque['identificador'],
            "1"=>$paque['descripcion'],
            "2"=>$paque['fecha'],
            "3"=>'$'.number_format($paque['total'], 2 , '.', ','),
            "4"=>$paque['destino'],
            "5"=>$paque['estado'],
            "6"=>'<a class="btn btn-primary" href="detallePaquete" role="button" onclick="verDetalle('.$paque['paqueteID'].', \'Envio normal\')"><i data-feather="eye" class="me-2"></i>Ver detalles</a>',
            );
        }
        $results=array(
            "sEcho"=>1,//info para datatables
            "iTotalRecords"=>count($paquetee),//enviamos el total de registros al datatable
            "iTotalDisplayRecords"=>count($paquetee),//enviamos el total de registros a visualizar
            "aaData"=>$paquetee);
         echo json_encode($results);
    break;
    //-----------------------------------------------------------------------------------------------------------------
    //para listar los paquetes de envio personalizado de un vendedor, vista paquetesVendedor
    case 'paquetesPersonalizadosVendedor':
        $paquetes = $paquete->listarPersonalizadosVendedor($_SESSION['idcliente']);
        $paquetee = array();
        foreach($paquetes as $paque){
            $paquetee[]=array(
            "0"=>$paque['identificador'],
            "1"=>$paque['descripcion'],
            "2"=>$paque['fecha'],
            "3"=>'$'.number_format($paque['total'], 2 , '.', ','),
            "4"=>$paque['direccion_cliente'],
            "5"=>$paque['estado'],
            "6"=>'<a class="btn btn-primary" href="detallePaquete" role="button" onclick="verDetalle('.$paque['paqueteID'].', \'Envio personalizado\')"><i data-feather="eye" class="me-2"></i>Ver detalles</a>',
            );
        }
        $results=array(
            "sEcho"=>1,//info para datatables
            "iTotalRecords"=>count($paquetee),//enviamos el total de registros al datatable
            "iTotalDisplayRecords"=>count($paquetee),//enviamos el total de registros a visualizar
            "aaData"=>$paquetee);
         echo json_encode($results);
    break;
    //-----------------------------------------------------------------------------------------------------------
    //---------- Para listar todos los paquetes de envio personalizado en la vista de detalle Paquete de un cliente------------------
    case 'listarPersonalizado':
        $respuesta = $paquete->listarPersonalizados($_SESSION['usuarioID']);
        if($_GET['vista'] == 'tabla'){
            foreach($respuesta as $reg){
                $paquetes[]=array(
                "0"=>$reg['identificador'],
                "1"=>$reg['descripcion'],
                "2"=>$reg['fecha'],
                "3"=>'$' . $reg['total'],
                "4"=>$reg['direccion_cliente'],
                "5"=>$reg['estado'],
                "6"=>'<a class="btn btn-primary" href="detallePaquete" role="button" onclick="verDetalle('.$reg['paqueteID'].', \'Envio personalizado\')">Ver detalles</a>',
                );
            }
            $results=array(
                 "sEcho"=>1,//info para datatables
                 "iTotalRecords"=>count($paquetes),//enviamos el total de registros al datatable
                 "iTotalDisplayRecords"=>count($paquetes),//enviamos el total de registros a visualizar
                 "aaData"=>$paquetes);
            echo json_encode($results);
        }else{
            $vistahtml = "";
            $respuestaArray = array();
            foreach($respuesta as $reg){
                $vistahtml .= $componentes->vistaDetallePaquete($reg['estado'], 'Envio personalizado', $reg['vendedor'], $reg['descripcion'], $reg['precio'], $reg['costo_envio'], $reg['direccion_cliente'], $reg['fecha'], $reg['paqueteID'], $reg['identificador']);
            }
            array_push($respuestaArray, $vistahtml); $vistahtml = '';
            echo json_encode($respuestaArray);
        }
    break;
    //-----------------------------------------------------------------------------------------------------------------
    //---------- Obtener la informacion completa de un paquete para la vista detalle Paquete de un cliente ------------------
    case 'infoPaquete':
        $reg = $paquete->infoPaquete($_GET['idPaquete'], $_GET['personalizado']);
        $estados = $paquete->infoEstados($_GET['idPaquete']);
        $detallehtml = $componentes->vistaDetallePaquete($reg['estado'], (($_GET['personalizado'] == 0)? 'Envio normal' : 'Envio personalizado'), $reg['vendedor'], $reg['descripcion'], $reg['precio'], $reg['costo_envio'], (($_GET['personalizado'] == 0)? $reg['destino'] : $reg['direccion_cliente']), (($_GET['personalizado'] == 0)? obtenerFechaParaNormal($reg['rutaID'], $reg['destinoID'], $ruta, $reg['fecha'], true) : $reg['fecha']), $reg['paqueteID'], $reg['identificador'], 1, $reg['telefono_cliente'], $reg['telefono_vendedor']);
        $estadosPaquete = $componentes->tablaEstadosPaquete($estados);
        if(count($estados) > 0){
            echo json_encode(["estado" => $reg['estado'], "detalles" => $detallehtml, "estados" => $estadosPaquete, "fechaUltimo" => (array_pop($estados))['fecha_estado']]);
        }else{
            echo json_encode(["estado" => $reg['estado'], "detalles" => $detallehtml]);
        }
    break;
    //-----------------------------------------------------------------------------------------------------------------
    //---------- Obtener el numero de paquetes por vendedor en la vista paquetesPorVendedor ------------------
    case 'vendedorNUM':
        $vendedores = $paquete->listarNUM($_SESSION['usuarioID']);
        $vendPaq = [];
        foreach($vendedores as $reg){
            array_push($vendPaq, array(
            "0"=>$reg['vendedor'],
            "1"=>$reg['numero'],
            "2"=>'<a class="btn btn-primary" role="button" onclick="verPaquetesVendedor('.$reg['vendedorID'].', \''.$reg['vendedor'].'\')">
                    <i data-feather="eye" class="me-2 mb-1"></i>Ver paquetes</a>',
            ));
        }
        $results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($vendPaq),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($vendPaq),//enviamos el total de registros a visualizar
             "aaData"=>$vendPaq);
        echo json_encode($results);
    break;
    //-----------------------------------------------------------------------------------------------------------------
    //---------- Obtener el número de paquetes por clientes en la vista estadisticasVendedor ------------------
    case 'clienteNUM':
        $clientes = $paquete->listarNUMClientes($_SESSION['usuarioID']);
        $cliPaq = [];
        foreach($clientes as $reg){
            array_push($cliPaq, array(
            "0"=>$reg['cliente'],
            "1"=>$reg['numero'],
            "2"=>'<a class="btn btn-primary" role="button" onclick="verPaquetesCliente('.$reg['usuarioID'].', \''.$reg['cliente'].'\')">
                    <i data-feather="eye" class="me-2 mb-1"></i>Ver paquetes</a>',
            ));
        }
        $results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($cliPaq),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($cliPaq),//enviamos el total de registros a visualizar
             "aaData"=>$cliPaq);
        echo json_encode($results);
    break;
    //-----------------------------------------------------------------------------------------------------------------
    //------ para obtener el listado de paquetes para un cliente especifico en la vista estadisticasVendedor -------------
    case 'paqCliente':
        $paquetes = $paquete->listarPaqCli($_GET['cliente'], $_SESSION['idcliente']);
        $paquetee = array();
        foreach($paquetes as $paq){
            $paquetee[]=array(
            "0"=>$paq['identificador'],
            "1"=>$paq['descripcion'],
            "2"=>$paq['fecha'],
            "3"=>'$'.number_format($paq['total'], 2 , '.', ','),
            "4"=>'<a class="btn btn-primary" href="detallePaquete" role="button" onclick="verDetalle('.$paq['paqueteID'].', '.$paq['tipo'].')"><i data-feather="eye" class="me-2 mb-1"></i>Ver detalles</a>',
            );
        }
        $results=array(
            "sEcho"=>1,//info para datatables
            "iTotalRecords"=>count($paquetee),//enviamos el total de registros al datatable
            "iTotalDisplayRecords"=>count($paquetee),//enviamos el total de registros a visualizar
            "aaData"=>$paquetee);
         echo json_encode($results);
    break;
    //-----------------------------------------------------------------------------------------------------------------
    //---------- Obtener la informacion de los paquetes envio personalizado de un vendedor especifico ------------------
    case 'paqVendedor':
        $paquetes = $paquete->listarPaqVen($_GET['vendedor'], $_SESSION['usuarioID']);
        $paquetee = array();
        foreach($paquetes as $paq){
            $paquetee[]=array(
            "0"=>$paq['descripcion'],
            "1"=>$paq['fecha'],
            "2"=>'$'.number_format($paq['total'], 2 , '.', ','),
            "3"=>'<a class="btn btn-primary" href="detallePaquete" role="button" onclick="verDetalle('.$paq['paqueteID'].', '.$paq['tipo'].')"><i data-feather="eye" class="me-2 mb-1"></i>Ver detalles</a>',
            );
        }
        $results=array(
            "sEcho"=>1,//info para datatables
            "iTotalRecords"=>count($paquetee),//enviamos el total de registros al datatable
            "iTotalDisplayRecords"=>count($paquetee),//enviamos el total de registros a visualizar
            "aaData"=>$paquetee);
       echo json_encode($results);
    break;
    //-----------------------------------------------------------------------------------------------------------------
    //---------- Obtener las categorias de productos para hacer la estimación de costo de envío en la vista agregar paquete para vendedores ------------------
    case 'categoriasProd':
        $categorias = $paquete->listarCategoriasProd();
        $selectVista = $componentes->selectProductosCategoria($categorias);
        echo $selectVista;
    break;
    //-----------------------------------------------------------------------------------------------------------------
    //---------- Obtener los productos de una categoria para la estimación de costo de envío en la vista agregar paquete para vendedores ------------------
    case 'listarProductosCat':
        $productos = $paquete->listarProductosCat($_GET['categoria']);
        $opcionesVista = $componentes->opcionesProductosCat($productos);
        echo $opcionesVista;
    break;
    //-----------------------------------------------------------------------------------------------------------------
    //---------- Obtiene el clienteID y el numero de telefono del vendedor necesarios para agregar un paquete en la vista agregarPaquete -----------
    case 'infoVendedor':
        if(isset($_GET['vendedorID'])){
            $infoVendedor = $usuario->infoVendedor2($_GET['vendedorID']);
            echo json_encode($infoVendedor);
        }else{
            $infoVendedor = $usuario->infoVendedor($_SESSION['usuarioID']);
            echo json_encode($infoVendedor);
        }
    break;
    //-----------------------------------------------------------------------------------------------------------------
    //---------- Guarda un paquete por un vendedor para ser confirmado después en la vista agregarPaquete ------------------
    case 'guardarPaqVendedor':
        $direccionPersonalizado = ($_POST['tipo_envio'] == 'normal')? '' : $_POST['direccion_paquete'];
        $rutaid = ($_POST['tipo_envio'] == 'normal')? $_POST['rutaid'] : null;
        $destino = ($_POST['tipo_envio'] == 'normal')? $_POST['destinoid'] : null;
        $recepcion = (isset($_GET['recepcion']))? $_GET['recepcion'] : 0; $fechaEnvio = (isset($_POST['fecha_envio']))? $_POST['fecha_envio'] : obtenerFechaParaNormal($rutaid, $destino, $ruta);    
        $infoPaquete = [$_POST['vendedorID'], $rutaid, $destino, $_POST['descripcion_paquete'], (($_POST['tipo_envio'] == 'normal')? 0 : 1 ), $_POST['nombre_cliente'], $_POST['telefono_cliente']
        , $_POST['telefono_vendedor'], $fechaEnvio, $_POST['precio_paquete'], $_POST['estimacion_envio'], $direccionPersonalizado, $recepcion, nuevoCorrelativoPaquete($paquete)];
        $respuesta = $paquete->guardarPaq($infoPaquete);
        if($recepcion == 1){
            $respuesta = $paquete->escribirEstado($respuesta, 'En bodega');
        }
        echo $respuesta;
    break;
    //-----------------------------------------------------------------------------------------------------------------
    // confirma la recepcion de un paquete en la vista paquetesRecibir ------------------
    case 'confirmarRecepcionPaquete':
        $respuesta = $paquete->escribirEstado($_GET['idPaquete'], 'En bodega');
        $respuesta = $paquete->confirmarRecepcionPaquete($_GET['idPaquete'], $_GET['costo_envio']);
        if($respuesta == 1){
            echo json_encode(['estado' => true, 'mensaje' => 'Paquete confirmado correctamente.']);
        }else{
            echo json_encode(['estado' => false, 'mensaje' => 'Error al confirmar el paquete.']);
        }
    break;
    //-----------------------------------------------------------------------------------------------------------------
    //---------- obtiene los paquetes que han sido agregados por un vendedor para mostrarlos en la vista paquetesVendedor ------------------
    case 'paquetesAgregados':
        $paquetes = $paquete->paquetesAgregados($_SESSION['idcliente']);
        $array = array();
        foreach($paquetes as $paquete){
            $array[] = array(
                "0"=>$paquete['identificador'],
                "1"=>$paquete['nombre_cliente'],
                "2"=>$paquete['descripcion'],
                "3"=>'$'.$paquete['precio'],
                "4"=>'<div style="background-color: #6c757d; color: azure;border-radius: 10px; width: max-content; padding: 2% 5%; margin: auto;">'.(($paquete['es_personalizado'] == '0')? 'Envio normal' : 'Envio Personalizado').'</div>',
                "5"=>'<a class="btn btn-primary" onclick="verPaquete('.$paquete['paqueteID'].')"><i data-feather="eye" class="me-2 mb-1"></i>Ver</a>',
            );
        }
        $results=array(
            "sEcho"=>1,//info para datatables
            "iTotalRecords"=>count($array),//enviamos el total de registros al datatable
            "iTotalDisplayRecords"=>count($array),//enviamos el total de registros a visualizar
            "aaData"=>$array);
         echo json_encode($results);
    break;
    //-----------------------------------------------------------------------------------------------------------------
    //---------- obtiene la informacion de un paquete agregado por un vendedor para la vista verPaquete ------------------
    case 'verPaquete':
        $paqueteInform = $paquete->paqueteInform($_GET['paquete']);
        echo json_encode($paqueteInform);        
    break;
    case 'infoDestino':
        $destino = $paquete->paqueteInformDestino($_GET['paquete']);
        echo json_encode($destino);        
    break;
    //-----------------------------------------------------------------------------------------------------------------
    //---------- edita la informacion de un paquete por un vendedor ------------------
    case 'editarPaqVendedor':
        $direccionPersonalizado = ($_POST['tipo_envio'] == 'normal')? '' : $_POST['direccion_paquete'];
        $rutaid = ($_POST['tipo_envio'] == 'normal')? $_POST['rutaid'] : null;
        $destino = ($_POST['tipo_envio'] == 'normal')? $_POST['destinoid'] : null;
        $infoPaquete = [$_POST['vendedorID'], $rutaid, $destino, $_POST['descripcion_paquete'], (($_POST['tipo_envio'] == 'normal')? 0 : 1 ), $_POST['nombre_cliente'], $_POST['telefono_cliente']
        , $_POST['telefono_vendedor'], $_POST['fecha_envio'], $_POST['precio_paquete'], $_POST['estimacion_envio'], $direccionPersonalizado, 0, $_POST['paqueteID']];
        $respuesta = $paquete->editarPaq($infoPaquete);
        echo $respuesta;
    break;
    //-----------------------------------------------------------------------------------------------------------------
    // lista los paquetes que los vendedores han agregado para ser confirmados por la recepcionista al momento de recibirlos ------------------
    // se llama desde la vistapaquetesRecibir
    case 'listarPaquetesAConfirmar':
        $paquetes = $paquete->listarPaquetesAConfirmar();
        $data = array();
        foreach($paquetes as $paquete){
            $data[] = array(
                "0"=>$paquete['identificador'],
                "1"=>$paquete['vendedor'],
                "2"=>$paquete['nombre_cliente'],
                "3"=>$paquete['fecha'],
                "4"=>'<button class="btn btn-primary" onclick="verInfoCompleta('. $paquete['paqueteID'] .', \'' . $paquete['identificador'] . '\', ' . $paquete['es_personalizado'] . ')"><i data-feather="eye" class="me-2 mb-1"></i>Ver</button>'
            );
        }
        $results = array(
            "sEcho"=>1,//info para datatables
            "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
            "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;
    //-----------------------------------------------------------------------------------------------------------------
    // lista los paquetes de un destino especifico para que el de recepcion confirme su salida ------------------
    case 'listarPaquetesRuta':
        $paquetes = $paquete->listarPaquetesRuta($_GET['ruta'], $_GET['destino'], $_GET['fecha']);
        $data = array();
        foreach($paquetes as $paq){
            $data[] = array(
                "0"=>$paq['identificador'],
                "1"=>$paq['vendedor'],
                "2"=>$paq['nombre_cliente'],
                "3"=>$paq['fecha'],
                "4"=>($paq['listoSalir'] == 1)? '<div style="background-color: #6c757d; color: azure;border-radius: 10px; width: max-content; padding: 2% 5%; margin: auto;">Listo para salir</div>' 
                : '<button class="btn btn-primary" onclick="verInfoCompleta('. $paq['paqueteID'] .', \'' . $paq['identificador'] . '\', \'0\')"><i data-feather="eye" class="me-2 mb-1"></i>Ver</button>
                    <button class="btn btn-success" onclick="confirmarSalida('. $paq['paqueteID'] .')"><i data-feather="check" class="me-2 mb-1"></i>Confirmar salida</button>'
            );
        }
        $results = array(
            "sEcho"=>1,//info para datatables
            "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
            "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;
    //-----------------------------------------------------------------------------------------------------------------
    // lista los paquetes de envio personalizado para que el de recepcion confirme su salida ------------------
    case 'listarPaquetesPersonalizados':
        $paquetes = $paquete->listarPaquetesPersonalizados();
        $data = array();
        foreach($paquetes as $paq){
            $data[] = array(
                "0"=>$paq['identificador'],
                "1"=>$paq['vendedor'],
                "2"=>$paq['nombre_cliente'],
                "3"=>$paq['fecha'],
                "4"=>($paq['listoSalir'] == 1)? '<div style="background-color: #6c757d; color: azure;border-radius: 10px; width: max-content; padding: 2% 5%; margin: auto;">Listo para salir</div>' 
                : '<button class="btn btn-primary" onclick="verInfoCompleta('. $paq['paqueteID'] .', \'' . $paq['identificador'] . '\', \'1\')"><i data-feather="eye" class="me-2 mb-1"></i>Ver</button>
                    <button class="btn btn-success" onclick="confirmarSalida('. $paq['paqueteID'] .')"><i data-feather="check" class="me-2 mb-1"></i>Confirmar salida</button>'
            );
        }
        $results = array(
            "sEcho"=>1,//info para datatables
            "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
            "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;
    //-----------------------------------------------------------------------------------------------------------------
    // para confirmar que un paquete ya esta listo para salir
    case 'confirmarSalida':
        $respuesta = $paquete->confirmarSalida($_GET['idPaquete']);
        if($respuesta == 1){
            echo json_encode(['estado' => true, 'mensaje' => 'Paquete confirmado correctamente.']);
        }else{
            echo json_encode(['estado' => false, 'mensaje' => 'Error al confirmar el paquete.']);
        }
    break;
    //-----------------------------------------------------------------------------------------------------------------
    //listar los paquetes de un destino para que los veo el repartidor
    case 'listarPaquetesRutaRepartidor':
        $paquetes = $paquete->listarPaquetesRutaConfirmados($_GET['ruta'], $_GET['destino'], $_GET['fecha']);
        $data = array();
        foreach($paquetes as $paq){
            $data[] = array(
                "0"=>$paq['identificador'],
                "1"=>$paq['vendedor'],
                "2"=>$paq['nombre_cliente'],
                "3"=>$paq['estado'],
                "4"=>(($paq['estado'] == 'Listo para entregar')? '<button class="btn btn-success" onclick="confirmarEntrega('. $paq['paqueteID'] .')"><i data-feather="check" class="me-2 mb-1"></i>Confirmar entrega</button>' : '') .
                '<button class="btn btn-primary btnVerPaqueteRepartidor" paqueteid="' . $paq['paqueteID'] . '" onclick="verInfoCompleta('. $paq['paqueteID'] .', \'' . $paq['identificador'] . '\', \'0\')"><i data-feather="eye" class="me-2 mb-1"></i>Ver</button>'
            );
        }
        $results = array(
            "sEcho"=>1,//info para datatables
            "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
            "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;
    //-----------------------------------------------------------------------------------------------------------------
    // para actualizar el estado de los paquetes de una ruta
    case 'cambiarEstadoPaq':
        $data = json_decode(file_get_contents("php://input"), true);
        $paquetesAactualizar = $data['paquetes']; $estado = $data['estado'];
        foreach($paquetesAactualizar as $paq){
            $paquete->escribirEstado($paq, $estado, true);
        }
        echo json_encode(['estado' => true, 'mensaje' => 'Paquetes actualizados correctamente.']);
    break;
    //-----------------------------------------------------------------------------------------------------------------
    // para confirmar que un paquete ya se ha entregado
    case 'confirmarEntrega':
        $respuesta = $paquete->confirmarEntrega($_GET['idPaquete']);
        $respuesta = $paquete->escribirEstado($_GET['idPaquete'], 'Entregado');
        if($respuesta == 1){
            echo json_encode(['estado' => true, 'mensaje' => 'Paquete confirmado correctamente.']);
        }else{
            echo json_encode(['estado' => false, 'mensaje' => 'Error al confirmar el paquete.']);
        }
    break;
    //-----------------------------------------------------------------------------------------------------------------
    // para listar los paquetes de envio personalizado en la vista paquetesPersonalizado del repartidor
    case 'listarPaquetesPersonalizadosHoy':
        $paquetes = $paquete->listarPaquetesPersonalizadosHoy();
        $data = array();
        foreach($paquetes as $paq){
            $data[] = array(
                "0"=>$paq['identificador'],
                "1"=>$paq['nombre_cliente'],
                "2"=>$paq['fecha'],
                "3"=>$paq['estado'],
                "4"=>'<button class="btn btn-primary btnVerPaqueteRepartidor" paqueteid="' . $paq['paqueteID'] . '" onclick="verDetalle('. $paq['paqueteID'] .')"><i data-feather="eye" class="me-2 mb-1"></i>Ver</button>'
            );
        }
        $results = array(
            "sEcho"=>1,//info para datatables
            "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
            "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;
    //-----------------------------------------------------------------------------------------------------------------
    // para listar los paquetes de envio personalizado de los próximos días en la vista paquetesPersonalizado del repartidor
    case 'listarPaquetesPersonalizadosT':
        $paquetes = $paquete->listarPaquetesPersonalizadosT();
        $data = array();
        foreach($paquetes as $paq){
            $data[] = array(
                "0"=>$paq['identificador'],
                "1"=>$paq['nombre_cliente'],
                "2"=>$paq['fecha'],
                "3"=>$paq['estado'],
                "4"=>'<button class="btn btn-primary btnVerPaqueteRepartidor" paqueteid="' . $paq['paqueteID'] . '" onclick="verDetallePersonalizado('. $paq['paqueteID'] .')"><i data-feather="eye" class="me-2 mb-1"></i>Ver</button>'
            );
        }
        $results = array(
            "sEcho"=>1,//info para datatables
            "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
            "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;
    //-----------------------------------------------------------------------------------------------------------------
    // para listar los paquetes que no fueron retirados por los clientes
    case 'noRetirados':
        $paquetes = $paquete->listarNoRetirados();
        $data = array();
        foreach($paquetes as $paq){
            $data[] = array(
                "0"=>$paq['identificador'],
                "1"=>$paq['vendedor'],
                "2"=>$paq['telefono'],
                "3"=>$paq['nombre_cliente'],
                "4"=>$paq['fecha'],
                "5"=>$paq['estado'],
                "6"=>'<button class="btn btn-primary" onclick="verPaquete('. $paq['paqueteID'] .', \'' . $paq['identificador'] . '\')"><i data-feather="eye" class="me-2 mb-1"></i>Ver</button>'
            );
        }
        $results = array(
            "sEcho"=>1,//info para datatables
            "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
            "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;
    //-----------------------------------------------------------------------------------------------------------------
    // para devolver un paquete que no fue retirado por el cliente a su vendedor
    case 'devolver':
        $respuesta = $paquete->devolverPaquete($_GET['idPaquete']);
        if($respuesta == 1){
            echo json_encode(['estado' => true, 'mensaje' => 'Paquete devuelto correctamente.']);   
        }else{
            echo json_encode(['estado' => false, 'mensaje' => 'Error al devolver el paquete.']);   
        }
        break;
        //-----------------------------------------------------------------------------------------------------------------
    // para reprogramar un paquete que no fue retirado por el cliente
    case 'reprogramar':
        $data = json_decode(file_get_contents("php://input"), true);
        $respuesta = $paquete->reprogramarPaquete($data['ruta'], $data['destino'], $data['fecha'], $data['costoEnvio'], $data['idPaquete']);
        if($respuesta == 1){
            echo json_encode(['estado' => true, 'mensaje' => 'Paquete reprogramado correctamente.']);
        }else{
            echo json_encode(['estado' => false, 'mensaje' => 'Error al reprogramar el paquete.']);
        }
    break;        
}

function nuevoCorrelativoPaquete($paquete){
    $ultimoCorrelativo = $paquete->ultimoCorrelativo();
    if(!$ultimoCorrelativo || $ultimoCorrelativo['identificador'] == ''){ $serie = '001'; $correlativo = '000001'; }
    else{
        $arrayInfo = explode('-', $ultimoCorrelativo['identificador']);
        $correlativo = $arrayInfo[1]; $serie = $arrayInfo[0];
        if($correlativo == '999999'){
            if($serie == '999'){
                $serie = '001'; $correlativo = '000001';
            }else{
                $serie = intval($serie) + 1; $correlativo = '000001';
            }
        }else{
            $correlativo = intval($correlativo) + 1;
        }
    }
    $correlativo = str_pad($correlativo, 6, "0", STR_PAD_LEFT);
    $serie = str_pad($serie, 3, "0", STR_PAD_LEFT);
    return $serie . '-' . $correlativo;
}

function obtenerFechaParaNormal($rutaid, $destinoid, $ruta, $fecha = '', $verMas = false){
    $infoDestino = $ruta->obtenerFechaHora($rutaid, $destinoid);
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
    if(!$verMas){
        return date('Y-m-d', strtotime('next '.$dia));
    }else{
        return $infoDestino['dia'] . ' ' . $fecha .' desde las ' . $infoDestino['hora_desde'] . ' hasta las ' . $infoDestino['hora_hasta'];
    }   
}
?>