<?php
//Iniciamos o retomamos la sesion
session_start();
//Incluimos los modelos a usar
require_once "../Modelos/consultas.php";
//Creamos los objetos para acceder a los metodos del modelo que se conecta a la base de datos
$consultas = new Consulta();
//Definimos el switch para realizar las diversas acciones segun sea el caso
switch($_GET['accion']){
    case 'perfilVendedores':
        $negocios = $consultas->negocioVendedores();
        foreach($negocios as $neg){
            $infoPerfil[]=array(
            "0"=>$neg['nombre_negocio'],
            "1"=>'<a class="btn btn-secondary" href="'.$neg['link'].'" target="_blank">Visitar Perfil<i data-feather="arrow-up-right"></i></a>',
            );
        }
        $results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($infoPerfil),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($infoPerfil),//enviamos el total de registros a visualizar
             "aaData"=>$infoPerfil);
        echo json_encode($results);
    break;
    //-----------------------------------------------------------------------------------------------------------
    //para listar los departamentos en un select en la vista registroCliente.php
    case 'selectDepartamentos':
        $departamentos = $consultas->listarDepartamentos();
        $opciones = '<option value="0" selected>Seleccione departamento...</option>';
        foreach($departamentos as $dep){
            $opciones .= '<option value="'.$dep['departamentoID'].'">'.$dep['nombre_departamento'].'</option>';
        }
        echo $opciones;
    break;
    //-----------------------------------------------------------------------------------------------------------
    //para listar los municios en un select de un departamento seleccionado en la vista registroCliente.php
    case 'selectMunicipios':
        $municipios = $consultas->listarMunicipios($_GET['departamentoid']);
        $opciones = '<option value="0" selected>Seleccione municipio...</option>';
        foreach($municipios as $mun){
            $opciones .= '<option value="'.$mun['municipioID'].'">'.$mun['nombre_municipio'].'</option>';
        }
        echo $opciones;
    break;
    //////////////////////////////////////////////////////////////////////////////////////
    //////////////// PARA LOS GRAFICOS DE LA VISTA INFOFINANCIERA ////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////
    case 'ingresosEnvNormal':
        $semanal = (isset($_GET['semanal'])) ? true : false;
        $ingresos = $consultas->ingresosEnvNormal($semanal);
        echo json_encode($ingresos);
        break;
    case 'ingresosEnvPerson':
        $semanal = (isset($_GET['semanal'])) ? true : false;
        $ingresos = $consultas->ingresosEnvPerson($semanal);
        echo json_encode($ingresos);
        break;
    case 'numeroEnvNormal':
        $semanal = (isset($_GET['semanal'])) ? true : false;
        $ingresos = $consultas->numeroEnvNormal($semanal);
        echo json_encode($ingresos);
        break;
    case 'numeroEnvPerson':
        $semanal = (isset($_GET['semanal'])) ? true : false;
        $ingresos = $consultas->numeroEnvPerson($semanal);
        echo json_encode($ingresos);
        break;
    ///////////////////////////////  ////////////////////////
    case 'destinosInfo':
        $informacion = $consultas->destinosInfo($_GET['fechaInicio'], $_GET['fechaFin']);
        $data = array();
        foreach($informacion as $info){
            $data[]=array(
                "0"=>$info['lugar_destino'],
                "1"=>$info['numero'],
                "2"=>"$" . $info['valor'],
            );
        }
        $results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data);
        echo json_encode($results);
    break;
    ///////////////////////////////  ////////////////////////
    case 'listarRemuPendientes':
        $remuneraciones = $consultas->listarRemuPendientes($_SESSION['idcliente']);
        $data = array();
        foreach($remuneraciones as $remu){
            $data[] = array(
                "0"=>$remu['identificador'],
                "1"=>$remu['fecha_envio'],
                "2"=>"$".$remu['precio'],
                "3"=>"$".$remu['costo_envio'],
                "4"=>"$".$remu['remuneracion'],
                "5"=>"$".number_format($remu['remuneracion'] - ($remu['remuneracion'] * 0.10), 2),
            );
        }
        $results = array(
            "sEcho"=>1,//info para datatables
            "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
            "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;
}
