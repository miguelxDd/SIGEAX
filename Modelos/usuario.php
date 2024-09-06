<?php 
//incluimos la conexion a la base de datos
require_once "conexion.php";
class User{
    //Conexion a la base para el modelo usuario
    private $conexion;
	//implementamos nuestro constructor e iniciamos la conexion
	public function __construct(){
		$this->conexion = new Conexion();
	}
// -----------------------------------------------------------------------------------------------------------
// --------------------------------- DEFINICION DE METODOS PARA ESTE MODELO ----------------------------------
// -----------------------------------------------------------------------------------------------------------
    public function iniciarSesion($login, $contra){
		$sql="SELECT usuarioID, user_login, contrasena, tipo_usuario, empleadoID, clienteID FROM usuario WHERE user_login= ? AND contrasena= ? AND estado_usuario=1";
		return  $this->conexion->getData($sql,[$login,$contra]); 
	} 
	
	//se usa para obtener el id del vendedor y el numero de telefono del vendedor al momento de guardar un paquete en la vista guardarPaquete
	public function infoVendedor($usuarioID){
		$sql = "SELECT c.clienteID as vendedorID, c.telefono_cliente as telefono FROM usuario u INNER JOIN cliente c ON u.clienteID = c.clienteID WHERE u.usuarioID = ?";
		return  $this->conexion->getData($sql,[$usuarioID]); 
	}
	// se usa para obtener el id del vendedor y el numero de telefono del vendedor al momento de guardar un paquete en la vista guardarPaquete de recepcion
	public function infoVendedor2($vendedorID){
		$sql = "SELECT c.clienteID as vendedorID, c.telefono_cliente as telefono FROM cliente c WHERE c.clienteID = ?";
		return  $this->conexion->getData($sql,[$vendedorID]);
	}
	//listar los usuarios registrados en el sistema
	public function listar(){
		$sql="SELECT u.usuarioID, u.tipo_usuario, u.fecha_creacion, c.nombre_cliente, e.nombre_empleado FROM usuario u LEFT JOIN cliente c ON u.clienteID = c.clienteID LEFT JOIN empleado e ON u.empleadoID = e.empleadoID WHERE u.estado_usuario = 1 AND u.tipo_usuario != 'admin'";
		return  $this->conexion->getDataAll($sql,[]);
	}
	//desactivar a un usuario
	public function desactivar($usuarioID){
		$sql="UPDATE usuario SET estado_usuario = 0 WHERE usuarioID = ?";
		return  $this->conexion->setData($sql,[$usuarioID]);
	}
	//listar usuarios desactivados
	public function listarDesactivados(){
		$sql="SELECT u.usuarioID, u.tipo_usuario, u.fecha_creacion, c.nombre_cliente, e.nombre_empleado FROM usuario u LEFT JOIN cliente c ON u.clienteID = c.clienteID LEFT JOIN empleado e ON u.empleadoID = e.empleadoID WHERE u.estado_usuario = 0 AND u.tipo_usuario != 'admin'";
		return  $this->conexion->getDataAll($sql,[]);
	}
	//para activar a un usuario
	public function activar($usuarioID){
		$sql="UPDATE usuario SET estado_usuario = 1 WHERE usuarioID = ?";
		return  $this->conexion->setData($sql,[$usuarioID]);
	}
	//para eliminar a un empleado
	public function eliminarEmpleado($empleadoID){
		$sql="DELETE FROM empleado WHERE empleadoID = ?";
		return  $this->conexion->setData($sql,[$empleadoID]);
	}
	//para registrar un empleado
	public function registrarEmpleado($nombre, $direccion, $telefono, $documento, $numDocumento){
		$sql="INSERT INTO empleado(nombre_empleado, direccion_empleado, telefono_empleado, tipo_documento_empleado, num_documento_empleado) VALUES (?,?,?,?,?)";
		return  $this->conexion->getReturnId($sql,[$nombre, $direccion, $telefono, $documento, $numDocumento]);
	}
	//para registrar el usuario y contraseña de un empleado
	public function registrarSuUsuario($idCliente, $user, $pass, $tipoUsuario){
		$sql = "INSERT INTO usuario(empleadoID, tipo_usuario, user_login, contrasena, estado_usuario) VALUES (?,?,?,?,?)";
		return  $this->conexion->getReturnId($sql,[$idCliente, $tipoUsuario, $user, $pass, 1]);
	}
	//para obtener la informacion personal de un cliente o vendendor
	public function obtenerInfoPersonal($usuarioID){
		$sql = "SELECT c.clienteID, c.nombre_cliente as nombre, c.direccion_cliente as direccion, c.telefono_cliente as telefono, c.tipo_documento_cliente as tipoDocumento, c.num_documento_cliente as documento, c.departamentoID, c.municipioID FROM cliente c INNER JOIN usuario u ON c.clienteID = u.clienteID WHERE u.usuarioID = ?";
		return  $this->conexion->getData($sql,[$usuarioID]);
	}
	//para obtener la informacion personal de un empleado
	public function obtenerInfoPersonalEmpleado($usuarioID){
		$sql = "SELECT e.empleadoID, e.nombre_empleado as nombre, e.direccion_empleado as direccion, e.telefono_empleado as telefono, e.tipo_documento_empleado as tipoDocumento, e.num_documento_empleado as documento FROM empleado e INNER JOIN usuario u ON e.empleadoID = u.empleadoID WHERE u.usuarioID = ?";
		return  $this->conexion->getData($sql,[$usuarioID]);
	}
	//para editar el nombre de usuario
	public function editarInfoUsuario($user, $usuarioID){
		$sql = "UPDATE usuario SET user_login = ? WHERE usuarioID = ?";
		return  $this->conexion->setData($sql,[$user, $usuarioID]);
	}
	//para obtener la informacion de un usuario
	public function obtenerInfoUsuario($usuarioID){
		$sql = "SELECT u.usuarioID, u.user_login as user FROM usuario u WHERE u.usuarioID = ?";
		return  $this->conexion->getData($sql,[$usuarioID]);
	}
	//para cambiar la contreseña de un usuario
	public function cambiarContrasena($usuarioID, $pass){
		$sql = "UPDATE usuario SET contrasena = ? WHERE usuarioID = ?";
		return  $this->conexion->setData($sql,[$pass, $usuarioID]);
	}
// -----------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------
}