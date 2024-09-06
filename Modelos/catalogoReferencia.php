<?php 
//incluimos la conexion a la base de datos
require_once "conexion.php";
class CatalogoReferencia{
    //Conexion a la base para el modelo usuario
    private $conexion;
	//implementamos nuestro constructor e iniciamos la conexion
	public function __construct(){
		$this->conexion = new Conexion();
	}
// -----------------------------------------------------------------------------------------------------------
// --------------------------------- DEFINICION DE METODOS PARA ESTE MODELO ----------------------------------
// -----------------------------------------------------------------------------------------------------------
    //para listar las categorias del catalogo de costos de envio de referencia en la vista gestionarCatalogoReferencia admin
    public function listarCategorias(){
        $sql = "SELECT * FROM categoria_producto";
        return $this->conexion->getDataAll($sql, []);
    }
    //para listar los productos de una categoria del catalogo de costos de envio de referencia en la vista gestionarCatalogoReferencia admin
    public function listarProductos($categoria){
        $sql = "SELECT * FROM producto_categoria WHERE categoriaID = ?";
        return $this->conexion->getDataAll($sql, [$categoria]);
    }
    //para obtener la info de una categoria
    public function infoDeCategoria($categoriaid){
        $sql = "SELECT * FROM categoria_producto WHERE categoriaID = ?";
        return $this->conexion->getData($sql, [$categoriaid]);
    }
    //para eliminar una categoria
    public function eliminarCategoria($categoriaid){
        $sql = "DELETE FROM categoria_producto WHERE categoriaID = ?";
        $sql2 = "DELETE FROM producto_categoria WHERE categoriaID = ?";
        $this->conexion->setData($sql2, [$categoriaid]);
        return $this->conexion->setData($sql, [$categoriaid]);
    }
    //para editar una categoria
    public function editarCategoria($categoriaid, $nombre_categoria){
        $sql = "UPDATE categoria_producto SET nombre_categoria = ? WHERE categoriaID = ?";
        return $this->conexion->setData($sql, [$nombre_categoria, $categoriaid]);
    }
    //para guardar una nueva categoria
    public function guardarCategoria($nombre_categoria){
        $sql = "INSERT INTO categoria_producto (nombre_categoria) VALUES (?)";
        return $this->conexion->setData($sql, [$nombre_categoria]);
    }
    //para obtener la informacion de un producto
    public function infoProducto($categoriaid, $productoid){
        $sql = "SELECT * FROM producto_categoria WHERE categoriaID = ? AND producto_categoriaID = ?";
        return $this->conexion->getData($sql, [$categoriaid, $productoid]);
    }
    //para eliminar un producto
    public function eliminarProducto($productoid){
        $sql = "DELETE FROM producto_categoria WHERE producto_categoriaID = ?";
        return $this->conexion->setData($sql, [$productoid]);
    }
    //para editar un producto
    public function editarProducto($productoid, $nombre_producto, $costo_envio){
        $sql = "UPDATE producto_categoria SET nombre_producto = ?, costo_estimado_envio = ? WHERE producto_categoriaID = ?";
        return $this->conexion->setData($sql, [$nombre_producto, $costo_envio, $productoid]);
    }
    //para guardar un nuevo producto
    public function guardarNuevoProducto($categoriaid, $nombre_producto, $costo_envio){
        $sql = "INSERT INTO producto_categoria (categoriaID, nombre_producto, costo_estimado_envio) VALUES (?, ?, ?)";
        return $this->conexion->setData($sql, [$categoriaid, $nombre_producto, $costo_envio]);
    }
// -----------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------
}