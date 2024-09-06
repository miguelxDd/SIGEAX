<?php
//Iniciamos o retomamos la sesion
session_start();
//Incluimos los modelos a usar
require_once "../Modelos/usuario.php";
require_once "../Modelos/cliente.php";
require_once "../Modelos/empleado.php";
//Creamos los objetos para acceder a los metodos del modelo que se conecta a la base de data
$user = new User();
$cliente = new Cliente();
$empleado = new Empleado();
//Definimos el switch para realizar las diversas acciones segun sea el caso
switch($_GET['accion']){
    case 'iniciarSesion':
        $login=isset($_POST['nombre'])? $_POST['nombre']:"";
		$clave=isset($_POST['clave'])? $_POST['clave']:"";
        $respuesta = $user->iniciarSesion($login, hash("SHA256", $clave));
        // establecemos las variables de sesion
        if($respuesta != false){
            $_SESSION['usuarioID'] = $respuesta['usuarioID'];
            $_SESSION['tipo_usuario'] = $respuesta['tipo_usuario'];
            if($respuesta['tipo_usuario'] == 'cliente' || $respuesta['tipo_usuario'] == 'vendedor'){
                $infoCliente = $cliente->obtenerInformacion($respuesta['clienteID']);
                $_SESSION['nombre'] = $infoCliente['nombre_cliente'];
                $_SESSION['idcliente'] = $respuesta['clienteID'];
            }else{
                if($respuesta['tipo_usuario'] != 'admin'){
                    $infoEmpleado = $empleado->obtenerInformacion($respuesta['empleadoID']);
                    $_SESSION['nombre'] = $infoEmpleado['nombre_empleado'];
                    $_SESSION['idempleado'] = $respuesta['empleadoID'];
                }
            }
            echo 1;
        }else{ echo 0; }
    break;
    //----------------------------------------------------------
    case 'listar':
        $respuesta = $user->listar();
        $data = array();
        foreach($respuesta as $usuario){
            $data[] = array(
                "0"=>$usuario['nombre_cliente'] != null ? $usuario['nombre_cliente'] : $usuario['nombre_empleado'],
                "1"=>$usuario['tipo_usuario'],
                "2"=>$usuario['fecha_creacion'],
                "3"=>'<button class="btn btn-primary" onclick="mostrar('.$usuario['usuarioID'].', \''.$usuario['tipo_usuario'].'\')"><i data-feather="eye"></i></button>
                    <button class="btn btn-danger" onclick="desactivar('.$usuario['usuarioID'].')"><i data-feather="user-x"></i></button>'
            );
        }
        $results = array(
            "sEcho"=>1,//info para datatables
            "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
            "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;
    //----------------------------------------------------------
    case 'desactivar':
        $respuesta = $user->desactivar($_GET['usuarioid']);
        if($respuesta == 1){
            echo json_encode(array("estado" => true, "mensaje" => "Usuario desactivado correctamente."));
        }else{
            echo json_encode(array("estado" => false, "mensaje" => "Error al desactivar usuario."));
        }
    break;
    //----------------------------------------------------------
    case 'listarDesactivados':
        $respuesta = $user->listarDesactivados();
        $data = array();
        foreach($respuesta as $usuario){
            $data[] = array(
                "0"=>$usuario['nombre_cliente'] != null ? $usuario['nombre_cliente'] : $usuario['nombre_empleado'],
                "1"=>$usuario['tipo_usuario'],
                "2"=>$usuario['fecha_creacion'],
                "3"=>'<button class="btn btn-primary" onclick="mostrar('.$usuario['usuarioID'].', \''.$usuario['tipo_usuario'].'\')"><i data-feather="eye"></i></button>
                    <button class="btn btn-success" onclick="activar('.$usuario['usuarioID'].')"><i data-feather="user-check"></i></button>'
            );
        }
        $results = array(
            "sEcho"=>1,//info para datatables
            "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
            "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;
    //----------------------------------------------------------
    case 'activar':
        $respuesta = $user->activar($_GET['usuarioid']);
        if($respuesta == 1){
            echo json_encode(array("estado" => true, "mensaje" => "Usuario activado correctamente."));
        }else{
            echo json_encode(array("estado" => false, "mensaje" => "Error al activar usuario."));
        }
    break;
    case 'eliminarEmpleado':
        $respuesta = $user->eliminarEmpleado($_GET['idEmpleado']);
        if($respuesta != false){
            echo json_encode(['estado'=>true]);
        }else{
            echo json_encode(['estado'=>false]);
        }
    break;
    case 'registrarEmpleado':
        $data = json_decode(file_get_contents("php://input"), true);
        $clienteID = $user->registrarEmpleado($data['nombre'], $data['direccion'], $data['telefono'], $data['documento'], $data['num_documento']);
        if($clienteID != false){
            echo json_encode(['estado'=>true, 'clienteID'=>$clienteID]);
        }else{
            echo json_encode(['estado'=>false, 'clienteID'=>null]);
        }
    break;
    case 'registrarSuUsuario':
        $data = json_decode(file_get_contents("php://input"), true);
        $disponibleUsuario = $cliente->verificarDisponibilidadUsuario($data['user']);
        if(count($disponibleUsuario) != 0){
            echo json_encode(['estado'=>true, 'usuarioDisponible'=>false]);
        }else{
            $usuarioID = $user->registrarSuUsuario($data['idCliente'], $data['user'], hash("SHA256", $data['pass']), $data['tipoUsuario']);
            if($usuarioID != false){
                echo json_encode(['estado'=>true, 'usuarioID'=>$usuarioID]);
            }else{
                echo json_encode(['estado'=>false, 'usuarioID'=>null]);
            }
        }
    break;
    case 'obtenerInfoPersonal':
        if($_GET['tipoUsuario'] == 'cliente' || $_GET['tipoUsuario'] == 'vendedor'){
            $respuesta = $user->obtenerInfoPersonal($_GET['usuarioid']);
        }else{
            $respuesta = $user->obtenerInfoPersonalEmpleado($_GET['usuarioid']);
        }
        if($respuesta != false){
            echo json_encode(['estado'=>true, 'info'=>$respuesta]);
        }else{
            echo json_encode(['estado'=>false]);
        }
    break;
    case 'editarInfoPersonal':
        $data = json_decode(file_get_contents("php://input"), true);
        if($_GET['tipoUsuario'] == 'cliente' || $_GET['tipoUsuario'] == 'vendedor'){
            $clienteID = $cliente->editarCliente($data['nombre'], $data['direccion'], $data['departamento'], $data['municipio'], $data['telefono'], $data['documento'], $data['num_documento'], $data['usuarioid']);
        }else{
            $clienteID = $empleado->editarEmpleado($data['nombre'], $data['direccion'], $data['telefono'], $data['documento'], $data['num_documento'], $data['usuarioid']);
        }
        if($clienteID != false){
            echo json_encode(['estado'=>true, 'clienteID'=>$clienteID]);
        }else{
            echo json_encode(['estado'=>false, 'clienteID'=>null]);
        }
    break;
    case 'editarInfoUsuario':
        $data = json_decode(file_get_contents("php://input"), true);
        $disponibleUsuario = $cliente->verificarDisponibilidadUsuario($data['user']);
        if(count($disponibleUsuario) != 0){
            echo json_encode(['estado'=>true, 'usuarioDisponible'=>false]);
        }else{
            $usuarioID = $user->editarInfoUsuario($data['user'], $_GET['usuarioid']);
            if($usuarioID == 1){
                echo json_encode(['estado'=>true]);
            }else{
                echo json_encode(['estado'=>false]);
            }
        }
    break;
    case 'obtenerInfoUsuario':
        $info = $user->obtenerInfoUsuario($_GET['usuarioid']);
        if($info != false){
            echo json_encode(['estado'=>true, 'info'=>$info]);
        }else{
            echo json_encode(['estado'=>false]);
        }
    break;
    case 'cambiarContrasena':
        $data = json_decode(file_get_contents("php://input"), true);
        $respuesta = $user->cambiarContrasena($_GET['usuarioid'], hash("SHA256", $data['contrasena']));
        if($respuesta == 1){
            echo json_encode(['estado'=>true]);
        }else{
            echo json_encode(['estado'=>false]);
        }
    break;
}
?>