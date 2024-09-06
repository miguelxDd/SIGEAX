<?php 
//incluimos la conexion a la base de datos
require_once "conexion.php";
class Negocio{
    //Conexion a la base para el modelo usuario
    private $conexion;
	//implementamos nuestro constructor e iniciamos la conexion
	public function __construct(){
		$this->conexion = new Conexion();
	}
// -----------------------------------------------------------------------------------------------------------
// --------------------------------- DEFINICION DE METODOS PARA ESTE MODELO ----------------------------------
// -----------------------------------------------------------------------------------------------------------
    public function registrar($nombre, $direccion, $departamento, $municipio, $telefono, $documento, $numDocumento, $nombreLogo, $correo, $link, $clienteID){
		$sql="INSERT INTO negocio(nombre_negocio, telefono_negocio, direccion_negocio, departamentoID, municipioID, tipo_documento_negocio, num_documento_negocio, logo_negocio, email_negocio, link, promocionar, clienteID) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
		return  $this->conexion->getReturnId($sql,[$nombre, $telefono, $direccion, $departamento, $municipio, $documento, $numDocumento, $nombreLogo, $correo, $link, 0, $clienteID]);
	}
	public function eliminarNegocio($negocioID){
		$sql="DELETE FROM negocio WHERE negocioID = ?";
		return $this->conexion->setData($sql, [$negocioID]);
	}
	public function listarNegociosVendedor($vendedorID){
		$sql="SELECT * FROM negocio WHERE clienteID = ?";
		return $this->conexion->getDataAll($sql, [$vendedorID]);
	}
	//para obtener la información de un negocio.
	public function obtenerInfoNegocio($usuarioID){
		$sql = "SELECT negocioID, nombre_negocio as nombre, telefono_negocio as telefono, direccion_negocio as direccion, departamentoID, municipioID, tipo_documento_negocio as tipoDocumento, num_documento_negocio as documento, logo_negocio as logo, email_negocio as email, link, promocionar FROM negocio WHERE clienteID = ?";
		return $this->conexion->getData($sql, [$usuarioID]);
	}
	//para actualizar la información de un negocio.
	public function actualizar($nombre, $direccion, $departamento, $municipio, $telefono, $documento, $numDocumento, $nombreLogo, $correo, $link, $promocionar, $negocioID){
		$sql="UPDATE negocio SET nombre_negocio = ?, telefono_negocio = ?, direccion_negocio = ?, departamentoID = ?, municipioID = ?, tipo_documento_negocio = ?, num_documento_negocio = ?, logo_negocio = ?, email_negocio = ?, link = ?, promocionar = ? WHERE negocioID = ?";
		return $this->conexion->setData($sql, [$nombre, $telefono, $direccion, $departamento, $municipio, $documento, $numDocumento, $nombreLogo, $correo, $link, $promocionar, $negocioID]);
	}
// -----------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------
}