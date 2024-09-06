<?php 
//incluimos la conexion a la base de datos
require_once "conexion.php";
class Empleado{
    //Conexion a la base para el modelo usuario
    private $conexion;
	//implementamos nuestro constructor e iniciamos la conexion
	public function __construct(){
		$this->conexion = new Conexion();
	}
// -----------------------------------------------------------------------------------------------------------
// --------------------------------- DEFINICION DE METODOS PARA ESTE MODELO ----------------------------------
// -----------------------------------------------------------------------------------------------------------
    public function obtenerInformacion($idempleado){
		$sql="SELECT nombre_empleado FROM empleado WHERE empleadoID= ?";
		return  $this->conexion->getData($sql,[$idempleado]); 
	}
	public function editarEmpleado($nombre, $direccion, $telefono, $documento, $numDocumento, $idempleado){
		$sql="UPDATE empleado SET nombre_empleado = ?, direccion_empleado = ?, telefono_empleado = ?, tipo_documento_empleado = ?, num_documento_empleado = ? WHERE empleadoID = ?";
		return  $this->conexion->setData($sql,[$nombre, $direccion, $telefono, $documento, $numDocumento, $idempleado]);
	}
// -----------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------
}