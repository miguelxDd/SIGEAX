<?php
//Iniciamos o retomamos la sesion
session_start();
//Incluimos los modelos a usar
require_once "../Modelos/catalogoReferencia.php";
require_once "../Componentes/componentes.php";
//Creamos los objetos para acceder a los metodos del modelo que se conecta a la base de datos
$catalogo = new CatalogoReferencia();
$componentes = new Componentes();
//Definimos el switch para realizar las diversas acciones segun sea el caso
switch($_GET['accion']){
    //-----------------------------------------------------------------------------------------------------------
    // para listar las categorias del catalogo de costos de envio de referencia en la vista gestionarCatalogoReferencia admin
    case 'listarCategoriasAdmin':
        $categorias = $catalogo->listarCategorias();
        echo $componentes->listarCategorias($categorias);
    break;
    //-----------------------------------------------------------------------------------------------------------
    // para listar los productos de una categoria del catalogo de costos de envio de referencia en la vista gestionarCatalogoReferencia admin
    case 'verProductos':
        $productos = $catalogo->listarProductos($_GET['categoriaid']);
        echo $componentes->listarProductos($productos);
    break;
    //-----------------------------------------------------------------------------------------------------------
    // para obtener la info de una categoria del catalogo de costos de envio de referencia en la vista gestionarCatalogoReferencia admin
    case 'infoDeCategoria':
        $categoria = $catalogo->infoDeCategoria($_GET['categoriaid']);
        echo json_encode(["estado" => true, "categoriaInfo" => $categoria]);        
    break;
    //para eliminar una categoria
    case 'eliminarCategoria':
        $respuesta = $catalogo->eliminarCategoria($_GET['categoriaid']);
        if($respuesta == 1){
            echo json_encode(["estado" => true, "mensaje" => "La categoría se eliminó correctamente."]);
        }else{
            echo json_encode(["estado" => false, "mensaje" => "No se pudo eliminar la categoría."]);
        }        
    break;
    //para editar una categoria
    case 'editarCategoria':
        $datos = json_decode(file_get_contents("php://input"), true);
        $respuesta = $catalogo->editarCategoria($datos['categoriaid'], $datos['nombre_categoria']);
        if($respuesta == 1){
            echo json_encode(["estado" => true, "mensaje" => "La categoría se editó correctamente."]);
        }else{
            echo json_encode(["estado" => false, "mensaje" => "No se pudo editar la categoría."]);
        }
    break;
    //para guardar una nueva categoria
    case 'guardarCategoria':
        $datos = json_decode(file_get_contents("php://input"), true);
        $respuesta = $catalogo->guardarCategoria($datos['nombre_categoria']);
        if($respuesta == 1){
            echo json_encode(["estado" => true, "mensaje" => "La categoría se guardó correctamente."]);
        }else{
            echo json_encode(["estado" => false, "mensaje" => "No se pudo guardar la categoría."]);
        }
    break;
    //para obtener la informacion de un producto
    case 'infoProducto':
        $producto = $catalogo->infoProducto($_GET['categoriaid'], $_GET['productoid']);
        echo json_encode(["estado" => true, "productoInfo" => $producto]);
    break;
    //-----------------------------------------------------------------------------------------------------------
    //para eliminar un producto
    case 'eliminarProducto':
        $respuesta = $catalogo->eliminarProducto($_GET['productoid']);
        if($respuesta == 1){
            echo json_encode(["estado" => true, "mensaje" => "El producto se eliminó correctamente."]);
        }else{
            echo json_encode(["estado" => false, "mensaje" => "No se pudo eliminar el producto."]);
        }
    break;
    //-----------------------------------------------------------------------------------------------------------
    //para editar un producto
    case 'editarProducto':
        $datos = json_decode(file_get_contents("php://input"), true);
        $respuesta = $catalogo->editarProducto($datos['productoid'], $datos['nombre_producto'], $datos['costo_estimado']);
        if($respuesta == 1){
            echo json_encode(["estado" => true, "mensaje" => "El producto se editó correctamente."]);
        }else{
            echo json_encode(["estado" => false, "mensaje" => "No se pudo editar el producto."]);
        }
    break;
    //-----------------------------------------------------------------------------------------------------------
    // para guardar un nuevo producto
    case 'guardarNuevoProducto':
        $datos = json_decode(file_get_contents("php://input"), true);
        $respuesta = $catalogo->guardarNuevoProducto($datos['categoriaid'], $datos['nombre_producto'], $datos['costo_estimado']);
        if($respuesta == 1){
            echo json_encode(["estado" => true, "mensaje" => "El producto se guardó correctamente."]);
        }else{
            echo json_encode(["estado" => false, "mensaje" => "No se pudo guardar el producto."]);
        }
    break;
}
?>