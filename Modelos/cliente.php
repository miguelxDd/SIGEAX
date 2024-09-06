<?php 
//incluimos la conexion a la base de datos
require_once "conexion.php";
class Cliente{
    //Conexion a la base para el modelo usuario
    private $conexion;
	//implementamos nuestro constructor e iniciamos la conexion
	public function __construct(){
		$this->conexion = new Conexion();
	}
// -----------------------------------------------------------------------------------------------------------
// --------------------------------- DEFINICION DE METODOS PARA ESTE MODELO ----------------------------------
// -----------------------------------------------------------------------------------------------------------
    public function obtenerInformacion($clienteID){
		$sql="SELECT nombre_cliente FROM cliente WHERE clienteID = ?";
		return  $this->conexion->getData($sql,[$clienteID]); 
	}

	//para registrar un cliente, llamada desde la vista de registro de cliente
	public function registrarCliente($nombre, $direccion, $departamento, $municipio, $telefono, $documento, $numDocumento){
		$sql="INSERT INTO cliente(nombre_cliente, direccion_cliente, departamentoID, municipioID, telefono_cliente, tipo_documento_cliente, num_documento_cliente, es_vendedor) VALUES (?,?,?,?,?,?,?,?)";
		return  $this->conexion->getReturnId($sql,[$nombre, $direccion, $departamento, $municipio, $telefono, $documento, $numDocumento, 0]);
	}

	// para registrar a un vendedor, llamada desde la vista de registro de vendedor
	public function registrarVendedor($nombre, $direccion, $departamento, $municipio, $telefono, $documento, $numDocumento){
		$sql = "INSERT INTO cliente(nombre_cliente, direccion_cliente, departamentoID, municipioID, telefono_cliente, tipo_documento_cliente, num_documento_cliente, es_vendedor) VALUES (?,?,?,?,?,?,?,?)";
		return  $this->conexion->getReturnId($sql,[$nombre, $direccion, $departamento, $municipio, $telefono, $documento, $numDocumento, 1]);
	}
		

	//para verificar la disponibilidad de un usuario, llamada desde la vista de registro de cliente
	public function verificarDisponibilidadUsuario($user){
		$sql="SELECT user_login FROM usuario WHERE user_login = ?";
		return  $this->conexion->getDataAll($sql,[$user]);
	}
	// para eliminar un cliente, llamada desde la vista registro de cliente cuando no se completó el registro
	// del usuario y contraseña pero si el registro del cliente
	public function eliminarCliente($idCliente){
		$sql="DELETE FROM cliente WHERE clienteID = ?";
		return  $this->conexion->setData($sql,[$idCliente]);
	}
	//para registrar el usuario y contraseña de un cliente, llamada desde la vista de registro de cliente
	public function registrarSuUsuario($idCliente, $user, $pass, $esVendedor){
		if(!$esVendedor){
			$sql="INSERT INTO usuario(clienteID, tipo_usuario, user_login, contrasena, estado_usuario) VALUES (?,?,?,?,?)";
			return  $this->conexion->getReturnId($sql,[$idCliente, 'cliente', $user, $pass, 1]);
		}else{
			$sql="INSERT INTO usuario(clienteID, tipo_usuario, user_login, contrasena, estado_usuario) VALUES (?,?,?,?,?)";
			return  $this->conexion->getReturnId($sql,[$idCliente, 'vendedor', $user, $pass, 1]);
		}
	}

	// para insertar el usuarioID al negocio del vendedor que se acaba de registrar, llamada desde la vista de registro de vendedor paso 3
	public function insertarUsuarioAVendedor($idcliente, $idusuario){
		$sql="UPDATE negocio SET usuarioID = ? WHERE clienteID = ?";
		return  $this->conexion->setData($sql,[$idusuario, $idcliente]);
	}
	//para listar vendedores al de recepcion en la vista de agregar paquete
	public function listarVendedores(){
		$sql="SELECT clienteID, nombre_cliente, telefono_cliente FROM cliente WHERE es_vendedor = 1";
		return  $this->conexion->getDataAll($sql,[]);
	}
	//para editar la informacion de un cliente
	public function editarCliente($nombre, $direccion, $departamento, $municipio, $telefono, $documento, $numDocumento, $clienteID){
		$sql="UPDATE cliente SET nombre_cliente = ?, direccion_cliente = ?, departamentoID = ?, municipioID = ?, telefono_cliente = ?, tipo_documento_cliente = ?, num_documento_cliente = ? WHERE clienteID = ?";
		return  $this->conexion->setData($sql,[$nombre, $direccion, $departamento, $municipio, $telefono, $documento, $numDocumento, $clienteID]);
	}
// -----------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------
}