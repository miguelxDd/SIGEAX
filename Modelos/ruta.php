<?php 
//incluimos la conexion a la base de datos
require_once "conexion.php";
class Ruta{
    //Conexion a la base para el modelo usuario
    private $conexion;
	//implementamos nuestro constructor e iniciamos la conexion
	public function __construct(){
		$this->conexion = new Conexion();
	}
// -----------------------------------------------------------------------------------------------------------
// --------------------------------- DEFINICION DE METODOS PARA ESTE MODELO ----------------------------------
// -----------------------------------------------------------------------------------------------------------
    //para listar las rutas en la vista agregarPaquete para un vendedor
    public function listarRutas($paraRepartidor = false){
        if($paraRepartidor){
            $sql = "SELECT r.rutaID, r.dia, h.fecha FROM ruta r INNER JOIN historial_destinos h ON r.rutaID = h.rutaID WHERE h.fecha >= CURDATE() AND r.estado = 1 GROUP BY r.rutaID";
            return $this->conexion->getDataAll($sql, []);
        }else{
            $sql = "SELECT * FROM ruta WHERE estado = 1";
            return $this->conexion->getDataAll($sql, []);
        }
    }

    //1.para listar los destinos de una ruta específica en la vista agrearPaquete para un vendedor
    //2.para mostrar la info de un destino especifico desde la vista rutas de recepcion
    public function listarDestinos($rutaID, $destinoID = ''){
        if($destinoID == ''){
            $sql = "SELECT * FROM destino d INNER JOIN departamento dep on d.departamentoID = dep.departamentoID INNER JOIN municipio m ON d.municipioID = m.municipioID WHERE d.rutaID = ? AND d.estado = 1";
            return $this->conexion->getDataAll($sql, [$rutaID]);
        }else{
            $sql = "SELECT * FROM destino d INNER JOIN departamento dep on d.departamentoID = dep.departamentoID INNER JOIN municipio m ON d.municipioID = m.municipioID WHERE d.rutaID = ? AND d.destinoID = ? AND d.estado = 1";
            return $this->conexion->getData($sql, [$rutaID, $destinoID]);
        }
    }
    //--------------------------------------------------------------------
    // para listar los destinos de una ruta específica en la vista paquetesNormal del repartidor
    public function listarDestinoRepartidor($rutaID, $fecha){
        $sql = "SELECT d.destinoID, d.lugar_destino, d.descripcion_destino, d.hora_desde, d.hora_hasta, m.nombre_municipio, dep.nombre_departamento, h.finalizada FROM destino d INNER JOIN departamento dep on d.departamentoID = dep.departamentoID INNER JOIN municipio m ON d.municipioID = m.municipioID INNER JOIN historial_destinos h ON d.destinoID = h.destinoID WHERE h.rutaID = ? AND h.fecha = ? AND d.estado = 1 GROUP BY d.destinoID";
        return $this->conexion->getDataAll($sql, [$rutaID, $fecha]);
    }
    //--------------------------------------------------------------------
    // para obtener el número de paquetes enviados a los 10 principales destinos (mayor número de paquetes)
    // se llama en la vista estadisticasDestinos
    public function destMasPaqVendedor($vendedor){
        $sql = "SELECT d.lugar_destino as destino, COUNT(p.paqueteID) as paquetes FROM paquerte p INNER JOIN destino d ON p.destinoID = d.destinoID WHERE p.vendedorID = ? GROUP BY p.destinoID ORDER BY paquetes DESC LIMIT 10";
        return $this->conexion->getDataAll($sql, [$vendedor]);
    }
    //--------------------------------------------------------------------
    // para obtener la fecha y hora de envío de un paquete a un destino específico,  se llama para guardar un paquete y para
    // mostrar la fecha y hora de envío en la vista de historial de ordenes de un cliente, se llamada desde Controladores/paquete.php
    public function obtenerFechaHora($ritaid, $destinoid){
        $sql = "SELECT r.dia, d.hora_desde, d.hora_hasta FROM destino d INNER JOIN ruta r ON d.rutaID = r.rutaID WHERE r.rutaID = ? AND d.destinoID = ?";
        return $this->conexion->getData($sql, [$ritaid, $destinoid]);
    }
    //--------------------------------------------------------------------
    // para obtener la fecha de una ruta específica
    public function obtenerFechaRuta($rutaID){
        $sql = "SELECT dia FROM ruta WHERE rutaID = ?";
        return $this->conexion->getData($sql, [$rutaID]);
    }
    //--------------------------------------------------------------------
    // para finalizar un destino, se llama desde la vista destino del repartidor al momento de que este
    // da click en el boton de finalizar destino
    public function finalizarDestino($rutaID, $destinoID, $fecha){
        $sql = "UPDATE historial_destinos SET finalizada = 1 WHERE rutaID = ? AND destinoID = ? AND fecha = ?";
        return $this->conexion->setData($sql, [$rutaID, $destinoID, $fecha]);
    }
    //--------------------------------------------------------------------
    // para guardar una nueva ruta, se llama desde la vista gestionarRutas del admin
    public function guardarNuevaRuta($dia){
        $sql = "INSERT INTO ruta (dia) VALUES (?)";
        return $this->conexion->setData($sql, [$dia]);
    }
    //--------------------------------------------------------------------
    // para eliminar una ruta específica, se llama desde la vista gestionarRutas del admin
    public function eliminarRuta($rutaID){
        $sql = "UPDATE ruta SET estado = 0 WHERE rutaID = ?";
        $sql2 = "UPDATE destino SET estado = 0 WHERE rutaID = ?";
        $this->conexion->setData($sql, [$rutaID]);
        return $this->conexion->setData($sql2, [$rutaID]);
    }
    //--------------------------------------------------------------------
    // para obtener el día de una ruta específica, se llama desde la vista gestionarRutas del admin
    public function obtenerDiaRuta($rutaID){
        $sql = "SELECT dia FROM ruta WHERE rutaID = ? AND estado = 1";
        return $this->conexion->getDataAll($sql, [$rutaID]);
    }
    //--------------------------------------------------------------------
    // para editar el día de una ruta específica, se llama desde la vista gestionarRutas del admin
    public function guardarNuevoDiaRuta($rutaID, $dia){
        $sql = "UPDATE ruta SET dia = ? WHERE rutaID = ?";
        return $this->conexion->setData($sql, [$dia, $rutaID]);
    }
    //--------------------------------------------------------------------
    // para eliminar un destino específico, se llama desde la vista gestionarRutas del admin
    public function eliminarDestino($destinoID){
        $sql = "UPDATE destino SET estado = 0 WHERE destinoID = ?";
        return $this->conexion->setData($sql, [$destinoID]);
    }
    //--------------------------------------------------------------------
    // para editar un destino
    public function guardarEditarDestino($destinoid, $lugar_destino, $descripcion_destino, $departamento, $municipio, $hora_inicio, $hora_fin){
        $sql = "UPDATE destino SET lugar_destino = ?, descripcion_destino = ?, departamentoID = ?, municipioID = ?, hora_desde = ?, hora_hasta = ? WHERE destinoID = ?";
        return $this->conexion->setData($sql, [$lugar_destino, $descripcion_destino, $departamento, $municipio, $hora_inicio, $hora_fin, $destinoid]);
    }
    //--------------------------------------------------------------------
    // para agregar un nuevo destino
    public function guardarNuevoDestino($rutaID, $lugar_destino, $descripcion_destino, $departamento, $municipio, $hora_inicio, $hora_fin){
        $sql = "INSERT INTO destino (rutaID, lugar_destino, descripcion_destino, departamentoID, municipioID, hora_desde, hora_hasta) VALUES (?, ?, ?, ?, ?, ?, ?)";
        return $this->conexion->setData($sql, [$rutaID, $lugar_destino, $descripcion_destino, $departamento, $municipio, $hora_inicio, $hora_fin]);
    }
// -----------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------
}