<?php
define('host', 'localhost'); define('puerto', 3306); define('nombreBase', 'siax'); define('usuarioBase', 'root'); define('contrasenaBase', '');

class Conexion{
	private $conect = null;

	public function __construct(){
		$connectionString = "mysql:host=".host.";port=".puerto.";dbname=".nombreBase.";charset=utf8";
		try{
			$this->conect = new PDO($connectionString, usuarioBase, contrasenaBase);
			$this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		} catch(PDOException $e){
			$this->conect = 'Error de conexion';
			echo "ERROR...!: ".$e->getMessage();
		}
	} 

	//INSERTAR, ACTUALIZAR Y ELIMINAR DATOS
	public	function setData($sql,$arrData){ 
		$query = $this->conect->prepare($sql);
		$restQuery = $query->execute($arrData);
		return $restQuery;
	}

	//RETORNAR EL ID DEL ULTIMO REGISTRO	
	public function getReturnId($sql,$arrData){
		$query = $this->conect->prepare($sql);
		$restQuery = $query->execute($arrData);
		$idInsert = $this->conect->lastinsertId();
		return $idInsert;
	}

	//LISTAR TODO LOS DATOS
	public function getDataAll($sql, $arrData){
		$query = $this->conect->prepare($sql);
		$query->execute($arrData);
		$restQuery = $query->fetchall(PDO::FETCH_ASSOC);
		return $restQuery;
	}

	//BUSCAR (devuelve solo uno)
	public function getData($sql,$arrData){
		$query = $this->conect->prepare($sql);
		$query->execute($arrData);
		$restQuery = $query->fetch(PDO::FETCH_ASSOC);
		return $restQuery;
	}

}