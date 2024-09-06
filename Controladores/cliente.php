<?php
//Iniciamos o retomamos la sesion
session_start();
//Incluimos los modelos a usar
require_once "../Modelos/cliente.php";
//Creamos los objetos para acceder a los metodos del modelo que se conecta a la base de datos
$cliente = new Cliente();
//Definimos el switch para realizar las diversas acciones segun sea el caso
switch($_GET['accion']){
    //------------------------------------------------------------------------------------------------------------
    // para registrar un cliente, se llama desde la vista de registro de cliente
    case 'registrarCliente':
        $data = json_decode(file_get_contents("php://input"), true);
        $clienteID = $cliente->registrarCliente($data['nombre'], $data['direccion'], $data['departamento'], $data['municipio'], $data['telefono'], $data['documento'], $data['num_documento']);
        if($clienteID != false){
            echo json_encode(['estado'=>true, 'clienteID'=>$clienteID]);
        }else{
            echo json_encode(['estado'=>false, 'clienteID'=>null]);
        }
    break;
    //------------------------------------------------------------------------------------------------------------
    // para registrar a un vendedor, se llama desde la vista de registro de vendedor
    case 'registrarVendedor':
        $data = json_decode(file_get_contents("php://input"), true);
        $vendedorID = $cliente->registrarVendedor($data['nombre'], $data['direccion'], $data['departamento'], $data['municipio'], $data['telefono'], $data['documento'], $data['num_documento']);
        if($vendedorID != false){
            echo json_encode(['estado'=>true, 'vendedorID'=>$vendedorID]);
        }else{
            echo json_encode(['estado'=>false, 'vendedorID'=>null]);
        }
    break;
    //para listar los vendedores en la vista de agregar paquete de la recepcion y en la vista de registro de vendedor
    // tambien de recepción
    case 'listarVendedores':
        $vendedores = $cliente->listarVendedores();
        $llamada = (isset($_GET['vistaVendedores']))? $_GET['vistaVendedores'] : '';
        $data = array();
        if($llamada == ''){
            foreach($vendedores as $vendedor){
                $data[] = array(
                    "0"=>$vendedor['nombre_cliente'],
                    "1"=>$vendedor['telefono_cliente'],
                    "2"=>'<button class="btn btn-primary" type="button" onclick="seleccionarVendedor('.$vendedor['clienteID'].',\''.$vendedor['nombre_cliente'].'\')"><i data-feather="plus" class="me-1"></i>Seleccionar</button>',
                );
            }
        }else{
            foreach($vendedores as $vendedor){
                $data[] = array(
                    "0"=>$vendedor['nombre_cliente'],
                    "1"=>$vendedor['telefono_cliente']
                );
            }
        }
        $results = array(
            "sEcho"=>1, //Informacion para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;
    //------------------------------------------------------------------------------------------------------------
    // para registrar el usuario y contraseña de un cliente, se llama desde la vista de registro de cliente
    case 'registrarSuUsuario':
        $data = json_decode(file_get_contents("php://input"), true);
        $disponibleUsuario = $cliente->verificarDisponibilidadUsuario($data['user']);
        if(count($disponibleUsuario) != 0){
            echo json_encode(['estado'=>true, 'usuarioDisponible'=>false]);
        }else{
            $usuarioID = $cliente->registrarSuUsuario($data['idCliente'], $data['user'], hash("SHA256", $data['pass']), (isset($data['esVendedor']) ? true : false));
            if($usuarioID != false){
                echo json_encode(['estado'=>true, 'usuarioID'=>$usuarioID]);
            }else{
                echo json_encode(['estado'=>false, 'usuarioID'=>null]);
            }
        }
    break;
    //------------------------------------------------------------------------------------------------------------
    // para eliminar un cliente, se llama desde la vista registro de cliente cuando no se completó el registro
    // del usuario y contraseña pero si el registro del cliente
    case 'eliminarCliente':
        $respuesta = $cliente->eliminarCliente($_GET['idCliente']);
        if($respuesta != false){
            echo json_encode(['estado'=>true]);
        }else{
            echo json_encode(['estado'=>false]);
        }
    break;
    //------------------------------------------------------------------------------------------------------------
    // para insertar el usuarioID al negocio del vendedor que se acaba de registrar, se llama desde la vista de registro de vendedor paso 3
    case 'insertarUsuarioAVendedor':
        $estado = $cliente->insertarUsuarioAVendedor($_GET['idCliente'], $_GET['idUsuario']);
        return $estado;
    break;
}
?>