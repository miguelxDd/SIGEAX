<?php
date_default_timezone_set('America/El_Salvador');
//incluimos la conexion a la base de datos
require_once "conexion.php";
class Consulta{
    //Conexion a la base para el modelo usuario
    private $conexion;
	//implementamos nuestro constructor e iniciamos la conexion
	public function __construct(){
		$this->conexion = new Conexion();
	}
// -----------------------------------------------------------------------------------------------------------
// --------------------------------- DEFINICION DE METODOS PARA ESTE MODELO ----------------------------------
// -----------------------------------------------------------------------------------------------------------
    //para mostrar el número de paquetes no completados en inicio del cliente
    public function numPaquetesPendientes($usuario){
		$sql="SELECT COUNT(paqueteID) as numero FROM paquerte WHERE estado NOT LIKE 'Entregado' AND usuarioID = ?";
		return  $this->conexion->getData($sql,[$usuario]); 
	}

    //para mostrar el número de paquetes completados en inicio del cliente
    public function numPaquetesCompletados($usuario){
        $sql = "SELECT COUNT(paqueteID) as numero FROM paquerte WHERE estado LIKE 'Entregado' AND usuarioID = ?";
        return $this->conexion->getData($sql, [$usuario]);
    }

    //para mostrar los negocios en el inicio de cliente.
    public function negocioVendedores(){
        $sql = "SELECT nombre_negocio, link FROM negocio WHERE estado_negocio = 1 AND promocionar = 1";
        return $this->conexion->getDataAll($sql, []) ;
    }

    //para obtener la lista de departamentos
    public function listarDepartamentos(){
        $sql = "SELECT * FROM departamento";
        return $this->conexion->getDataAll($sql, []);
    }

    //para listar los municipios de un departamento
    public function listarMunicipios($departamento){
        $sql = "SELECT * FROM municipio WHERE departamentoID = ?";
        return $this->conexion->getDataAll($sql, [$departamento]);
    }
    //////////////////////////////////////////////////////////////////////////////////////
    //////////////// PARA LOS GRAFICOS DE LA VISTA INFOFINANCIERA ////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////
    //para mostrar los ingresos DIARIOS y SEMANALES de los envios normal
    public function ingresosEnvNormal($sem = false){
        if($sem){
            $sql = "SELECT fecha_envio as time, SUM(costo_envio) as value FROM paquerte WHERE es_personalizado = 0 AND estado = 'Entregado' GROUP BY WEEK(fecha_envio) ORDER BY fecha_envio";
        }else{
            $sql = "SELECT fecha_envio as time, SUM(costo_envio) as value FROM paquerte WHERE es_personalizado = 0 AND estado = 'Entregado' GROUP BY fecha_envio ORDER BY fecha_envio";
        }
        return $this->conexion->getDataAll($sql, []);
    }
    //para mostrar los ingresos DIARIOS y SEMANALES de los envios personalizados
    public function ingresosEnvPerson($sem = false){
        if($sem){
            $sql = "SELECT fecha_envio as time, SUM(costo_envio) as value FROM paquerte WHERE es_personalizado = 1 AND estado = 'Entregado' GROUP BY WEEK(fecha_envio) ORDER BY fecha_envio";
        }else{
            $sql = "SELECT fecha_envio as time, SUM(costo_envio) as value FROM paquerte WHERE es_personalizado = 1 AND estado = 'Entregado' GROUP BY fecha_envio ORDER BY fecha_envio";
        }
        return $this->conexion->getDataAll($sql, []);
    }
    //para mostrar el numero de envios DIARIOS y SEMANALES de los envios normales
    public function numeroEnvNormal($sem = false){
        if($sem){
            $sql = "SELECT fecha_envio as time, COUNT(paqueteID) as value FROM paquerte WHERE es_personalizado = 0 AND estado = 'Entregado' GROUP BY WEEK(fecha_envio) ORDER BY fecha_envio";
        }else{
            $sql = "SELECT fecha_envio as time, COUNT(paqueteID) as value FROM paquerte WHERE es_personalizado = 0 AND estado = 'Entregado' GROUP BY fecha_envio ORDER BY fecha_envio";
        }
        return $this->conexion->getDataAll($sql, []);
    }
    //para mostrar el numero de envios DIARIOS y SEMANALES de los envios personalizados
    public function numeroEnvPerson($sem = false){
        if($sem){
            $sql = "SELECT fecha_envio as time, COUNT(paqueteID) as value FROM paquerte WHERE es_personalizado = 1 AND estado = 'Entregado' GROUP BY WEEK(fecha_envio) ORDER BY fecha_envio";
        }else{
            $sql = "SELECT fecha_envio as time, COUNT(paqueteID) as value FROM paquerte WHERE es_personalizado = 1 AND estado = 'Entregado' GROUP BY fecha_envio ORDER BY fecha_envio";
        }
        return $this->conexion->getDataAll($sql, []);
    }
    // para listar las remuneraciones pendientes de un vendedor
    public function listarRemuPendientes($vendedorID){
        $sql = "SELECT identificador, fecha_envio, precio, costo_envio, total as remuneracion FROM paquerte WHERE estado = 'Entregado' AND vendedorID = ? AND remuneracionID IS NULL";
        return $this->conexion->getDataAll($sql, [$vendedorID]);
    }
    /////////////////////////////////////////////////////////////////////////////
    //////////////// PARA LA VISTA REPORTES /////////////////////
    /////////////////////////////////////////////////////////////////////////////
    public function destinosInfo($fechaInicio, $fechaFin){
        if($fechaFin == ''){
            $sql = "SELECT d.lugar_destino, COUNT(p.paqueteID) as numero, SUM(p.costo_envio) as valor FROM paquerte p INNER JOIN destino d ON p.destinoID = d.destinoID WHERE p.estado = 'Entregado' AND p.fecha_envio BETWEEN DATE(DATE_SUB(NOW(), INTERVAL 3 MONTH)) AND DATE(NOW()) GROUP BY d.lugar_destino ORDER BY valor DESC";
            return $this->conexion->getDataAll($sql, []);
        }else{
            $sql = "SELECT d.lugar_destino, COUNT(p.paqueteID) as numero, SUM(p.costo_envio) as valor FROM paquerte p INNER JOIN destino d ON p.destinoID = d.destinoID WHERE p.estado = 'Entregado' AND p.fecha_envio >= ? AND p.fecha_envio <= ? GROUP BY d.lugar_destino ORDER BY valor DESC";
            return $this->conexion->getDataAll($sql, [$fechaInicio, $fechaFin]);
        }
    }
// -----------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------
}