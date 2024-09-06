<?php
//Iniciamos o retomamos la sesion
session_start();
//Incluimos los modelos a usar
require_once "../Modelos/negocio.php";
//Creamos los objetos para acceder a los metodos del modelo que se conecta a la base de datos
$negocio = new Negocio();
//Definimos el switch para realizar las diversas acciones segun sea el caso
switch ($_GET['accion']) {
        //------------------------------------------------------------------------------------------------------------
        // para registrar un negocio de un cliente, se llama desde la vista de registro de vendedor paso 2
    case 'registrar':
        // $data = json_decode(file_get_contents("php://input"), true);
        if ($_POST['logo_negocio'] != 'negocioDefecto.png') {
            move_uploaded_file($_FILES['logo_imagen']['tmp_name'], '../Imagenes/negocios/' . $_POST['logo_negocio']);
        }
        $negocioID = $negocio->registrar($_POST['nombre_negocio'], $_POST['direccion_negocio'], $_POST['departamento_negocio'], $_POST['municipio_negocio'], $_POST['telefono_negocio'], $_POST['documento_negocio'], $_POST['num_documento_negocio'], $_POST['logo_negocio'], $_POST['correo_negocio'], $_POST['link'], $_POST['idCliente']);
        if ($negocioID != false) {
            echo json_encode(['estado' => true, 'negocioID' => $negocioID]);
        } else {
            echo json_encode(['estado' => false, 'negocioID' => null]);
        }
        break;
    //------------------------------------------------------------------------------------------------------------
    // para eliminar un negocio de un cliente, se llama desde la vista de registro de vendedor a partir del paso 3 si se cancela o retrocede
    case 'eliminarNegocio':
        $negocio->eliminarNegocio($_GET['idNegocio']);
        break;
        //------------------------------------------------------------------------------------------------------------
        // para listar los negocios de un vendedor. Se llama desde la vista de agregar paquete para el recepcionista
    case 'listarNegociosVendedor':
        $negocios = $negocio->listarNegociosVendedor($_GET['vendedorID']);
        if (count($negocios) > 0) {
            $negociosOpciones = '';
            foreach ($negocios as $negocio) {
                $negociosOpciones .= '<option value="' . $negocio['negocioID'] . '">' . $negocio['nombre_negocio'] . '</option>';
            }
            echo json_encode(['estado' => true, 'negocios' => $negociosOpciones]);
        } else {
            echo json_encode(['estado' => false, 'negocios' => null]);
        }
        break;
    //------------------------------------------------------------------------------------------------------------
    //para obtener la información de un negocio.
    case 'obtenerInfoNegocio':
        $infor = $negocio->obtenerInfoNegocio($_GET['usuarioid']);
        if($infor != false){
            echo json_encode(['estado' => true, 'info' => $infor]);
        }else{
            echo json_encode(['estado' => false, 'info' => null]);
        }
        break;
    //------------------------------------------------------------------------------------------------------------
    //para actualizar la información de un negocio.
    case 'actualizar':
        // $data = json_decode(file_get_contents("php://input"), true);
        if ($_POST['logo_negocio'] != 'negocioDefecto.png') {
            move_uploaded_file($_FILES['logo_imagen']['tmp_name'], '../Imagenes/negocios/' . $_POST['logo_negocio']);
        }
        $negocioID = $negocio->actualizar($_POST['nombre_negocio'], $_POST['direccion_negocio'], $_POST['departamento_negocio'], $_POST['municipio_negocio'], $_POST['telefono_negocio'], $_POST['documento_negocio'], $_POST['num_documento_negocio'], $_POST['logo_negocio'], $_POST['correo_negocio'], $_POST['link'], $_POST['promocionar'], $_POST['idNegocio']);
        if ($negocioID != false) {
            echo json_encode(['estado' => true, 'negocioID' => $negocioID]);
        } else {
            echo json_encode(['estado' => false, 'negocioID' => null]);
        }
        break;
}
