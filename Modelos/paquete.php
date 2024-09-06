<?php
//incluimos la conexion a la base de datos
require_once "conexion.php";
class Paquete
{
    //Conexion a la base para el modelo usuario
    private $conexion;
    //implementamos nuestro constructor e iniciamos la conexion
    public function __construct()
    {
        $this->conexion = new Conexion();
    }
    // -----------------------------------------------------------------------------------------------------------
    // --------------------------------- DEFINICION DE METODOS PARA ESTE MODELO ----------------------------------
    // -----------------------------------------------------------------------------------------------------------
    //1. Se llamada desde controlador paquete.php case listar. -para listar los paquetes de envio normal de un clienteen la vista historialOrdenes.
    public function listar($idusuario)
    {
        $sql = "SELECT p.paqueteID, p.identificador, p.rutaID, p.destinoID, c.nombre_cliente as vendedor, p.descripcion, DATE(p.fecha_envio) as fecha, p.precio, p.costo_envio, p.total, CONCAT(d.nombre_departamento, ', ', m.nombre_municipio, ', ', des.lugar_destino) as destino, p.estado FROM paquerte p INNER JOIN cliente c ON p.vendedorID = c.clienteID INNER JOIN destino des ON p.destinoID = des.destinoID INNER JOIN departamento d ON des.departamentoID = d.departamentoID INNER JOIN municipio m ON des.municipioID = m.municipioID WHERE p.usuarioID = ? AND p.es_personalizado = ? AND p.devuelto = 0";
        return  $this->conexion->getDataAll($sql, [$idusuario, 0]);
    }
    //1. Se llamada desde controlador paquete.php case paquetesNormalesVendedor. -para listar los paquetes de envio normal de un vendedor en la vista paquetesVendedor.
    public function listarNormalesVendedor($vendedorID){
        $sql = "SELECT p.paqueteID, p.identificador, p.descripcion, DATE(p.fecha_envio) as fecha, p.total, CONCAT(d.nombre_departamento, ', ', m.nombre_municipio, ', ', des.lugar_destino) as destino, p.estado FROM paquerte p INNER JOIN cliente c ON p.vendedorID = c.clienteID INNER JOIN destino des ON p.destinoID = des.destinoID INNER JOIN departamento d ON des.departamentoID = d.departamentoID INNER JOIN municipio m ON des.municipioID = m.municipioID WHERE p.vendedorID = ? AND p.es_personalizado = ? AND p.recibido_recepcion = ? AND p.devuelto = 0";
        return $this->conexion->getDataAll($sql, [$vendedorID, 0, 1]);
    }
    //1. Se llamada desde controlador paquete.php case listar. -para listar los paquetes de envio normal de un clienteen la vista historialOrdenes.
    public function listarPersonalizados($idusuario)
    {
        $sql = "SELECT p.paqueteID, p.identificador, c.nombre_cliente as vendedor, p.descripcion, DATE(p.fecha_envio) as fecha, p.precio, p.costo_envio, p.total, p.direccion_cliente, p.estado FROM paquerte p INNER JOIN cliente c ON p.vendedorID = c.clienteID WHERE p.usuarioID = ? AND p.es_personalizado = ? AND p.devuelto = 0";
        return  $this->conexion->getDataAll($sql, [$idusuario, 1]);
    }
    //1. Se llamada desde controlador paquete.php case paquetesPersonalizadosVendedor. -para listar los paquetes de envio personalizado de un vendedor en la vista paquetesVendedor.
    public function listarPersonalizadosVendedor($vendedorID){
        $sql = "SELECT p.paqueteID, p.identificador, p.descripcion, DATE(p.fecha_envio) as fecha, p.total, p.direccion_cliente, p.estado FROM paquerte p INNER JOIN cliente c ON p.vendedorID = c.clienteID WHERE p.vendedorID = ? AND p.es_personalizado = ? AND p.recibido_recepcion = ? AND p.devuelto = 0";
        return $this->conexion->getDataAll($sql, [$vendedorID, 1, 1]);
    }
    //1. se llama para obtener la informacion de un paquete para la vista detallePaquete de un cliente
    public function infoPaquete($paquete, $esPersonalizado){
        if($esPersonalizado == 0){
            $sql = "SELECT p.paqueteID, p.identificador, p.rutaID, p.destinoID, c.nombre_cliente as vendedor, p.descripcion, DATE(p.fecha_envio) as fecha, p.precio, p.costo_envio, p.total, CONCAT(d.nombre_departamento, ', ', m.nombre_municipio, ', ', des.lugar_destino) as destino, p.estado, p.telefono_cliente, p.telefono_vendedor FROM paquerte p INNER JOIN cliente c ON p.vendedorID = c.clienteID INNER JOIN destino des ON p.destinoID = des.destinoID INNER JOIN departamento d ON des.departamentoID = d.departamentoID INNER JOIN municipio m ON des.municipioID = m.municipioID WHERE p.paqueteID = ? AND p.es_personalizado = ?";
        }else{
            $sql = "SELECT p.paqueteID, p.identificador, c.nombre_cliente as vendedor, p.descripcion, DATE(p.fecha_envio) as fecha, p.precio, p.costo_envio, p.total, p.direccion_cliente, p.estado, p.telefono_cliente, p.telefono_vendedor FROM paquerte p INNER JOIN cliente c ON p.vendedorID = c.clienteID WHERE p.paqueteID = ? AND p.es_personalizado = ?";
        }
        return $this->conexion->getData($sql, [$paquete, $esPersonalizado]);
    }
    //1. se llama para obtener la informacion de los estados de un paquete para la vista detallePaquete de un cliente
    public function infoEstados($paquete){
        $sql = "SELECT estado, fecha_estado FROM paquete_estados_fecha WHERE paqueteID = ?";
        return $this->conexion->getDataAll($sql, [$paquete]);
    }
    //-------------------------------------------------------------
    //--------se llama en la vista paquetesPorVendedor para listar los vendedores a los que un cliente a comprado y el número de 
    //------------------------------------------- paquetes que ha comprado con cada uno ----------------------------------------------
    public function listarNUM($idusuario){
        $sql = "SELECT p.vendedorID, c.nombre_cliente as vendedor, COUNT(p.paqueteID) as numero FROM paquerte p INNER JOIN cliente c ON p.vendedorID = c.clienteID WHERE p.usuarioID = ? AND c.es_vendedor = 1 AND p.devuelto = 0 GROUP BY p.vendedorID";
        return $this->conexion->getDataAll($sql, [$idusuario]);
    }
    //-------------------------------------------------------------
    // se llama en la vista estadisticasVendedor para listar los clientes a los que un vendedor a vendido y el número de
    // paquetes que ha vendido a cada uno
    public function listarNUMClientes($idusuario){
        $sql = "SELECT p.usuarioID, c.nombre_cliente as cliente, COUNT(p.paqueteID) as numero FROM paquerte p INNER JOIN usuario u ON p.usuarioID = u.usuarioID INNER JOIN cliente c ON u.clienteID = c.clienteID WHERE p.vendedorID = ? AND p.devuelto = 0 GROUP BY c.clienteID";
        return $this->conexion->getDataAll($sql, [$idusuario]);
    }
    //-------------------------------------------------------------
    // se llama en la vista estadisticasVendedor para listar los paquetes que se han entregado a un cliente en particular
    public function listarPaqCli($cliente, $idusuario){
        $sql = "SELECT p.paqueteID, p.identificador, p.descripcion, DATE(p.fecha_envio) as fecha, p.total, p.es_personalizado as tipo FROM paquerte p WHERE p.usuarioID = ? AND p.vendedorID = ? AND p.devuelto = 0";
        return $this->conexion->getDataAll($sql, [$cliente, $idusuario]);      
    }
    //-------------------------------------------------------------
    //----------se llama en la vista paquetesPorVendedor para listar los paquetes que tiene un cliente con un vendedor específico ----
    public function listarPaqVen($vendedor, $idusuario){
        $sql = "SELECT p.paqueteID, p.descripcion, DATE(p.fecha_envio) as fecha, p.total, p.es_personalizado as tipo FROM paquerte p INNER JOIN cliente c ON p.vendedorID = c.clienteID WHERE p.usuarioID = ? AND p.vendedorID = ? AND p.devuelto = 0";
        return $this->conexion->getDataAll($sql, [$idusuario, $vendedor]);
    }
    //-------------------------------------------------------------
    //----------se llama en la vista agregarPaquete para listar las categorias de posibles productos para hacer la estimación de costo de envio ----
    public function listarCategoriasProd(){
        $sql = "SELECT * FROM categoria_producto";
        return $this->conexion->getDataAll($sql, []);
    }
    //-------------------------------------------------------------
    //----------se llama en la vista agregarPaquete para listar los posibles productos de una categoria para hacer la estimación de costo de envio ----
    public function listarProductosCat($categoriaID){
        $sql = "SELECT * FROM producto_categoria WHERE categoriaID = ?";
        return $this->conexion->getDataAll($sql, [$categoriaID]);
    }
    //-------------------------------------------------------------
    //----------se llama en la vista agregarPaquete para agregar un paquete por un vendedor ----
    public function guardarPaq($infoPaquete){
        //si es envio normal, vemos si hay más paquetes con la misma fecha_envio de este paquete a guardar, si no hay creamos el historial del destino
        if($infoPaquete[4] == 0){
            $sql = "SELECT COUNT(paqueteID) as numero FROM paquerte WHERE fecha_envio = ? AND es_personalizado = ? AND rutaID = ? AND destinoID = ?";
            $numero = $this->conexion->getData($sql, [$infoPaquete[8], 0, $infoPaquete[1], $infoPaquete[2]]);
            if($numero['numero'] == 0){
                $sql = "INSERT INTO historial_destinos(rutaID, destinoID, fecha) VALUES(?, ?, ?)";
                $this->conexion->setData($sql, [$infoPaquete[1], $infoPaquete[2], $infoPaquete[8]]);
            }            
        }
        $sql = "INSERT INTO paquerte(vendedorID, rutaID, destinoID, descripcion, es_personalizado, nombre_cliente, telefono_cliente, telefono_vendedor, fecha_envio, precio, costo_envio, direccion_cliente, recibido_recepcion, estado, total, identificador) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        if($infoPaquete[12] == 0){
            return $this->conexion->setData($sql, [$infoPaquete[0], $infoPaquete[1], $infoPaquete[2], $infoPaquete[3], $infoPaquete[4], $infoPaquete[5], $infoPaquete[6], $infoPaquete[7], $infoPaquete[8], $infoPaquete[9], $infoPaquete[10], $infoPaquete[11], $infoPaquete[12], null, 0, $infoPaquete[13]]);
        }else{
            return $this->conexion->getReturnId($sql, [$infoPaquete[0], $infoPaquete[1], $infoPaquete[2], $infoPaquete[3], $infoPaquete[4], $infoPaquete[5], $infoPaquete[6], $infoPaquete[7], $infoPaquete[8], $infoPaquete[9], $infoPaquete[10], $infoPaquete[11], 1, 'En bodega', $infoPaquete[9] + $infoPaquete[10], $infoPaquete[13]]);
        }
    }
    //-------------------------------------------------------------
    // para escribir un nuevo estado de un paquete, se llama desde agregarPaquete de la vista de recepcion
    public function escribirEstado($paqueteID, $estado, $actualizarEstadoPaquete = false){
        if($actualizarEstadoPaquete){
            $sql = "UPDATE paquerte SET estado = ? WHERE paqueteID = ?";
            $this->conexion->setData($sql, [$estado, $paqueteID]);
        }
        $sql = "INSERT INTO paquete_estados_fecha(paqueteID, estado) VALUES(?, ?)";
        return $this->conexion->setData($sql, [$paqueteID, $estado]);
    }
    //-------------------------------------------------------------
    //----------se llama en la vista paquetesVendedor para listar los paquetes agregados por ese vendedor ----
    public function paquetesAgregados($idusuario){
        $sql = "SELECT p.paqueteID, p.identificador, p.nombre_cliente, p.descripcion, p.precio, p.es_personalizado FROM paquerte p INNER JOIN cliente c ON p.vendedorID = c.clienteID WHERE c.clienteID = ? AND p.recibido_recepcion = ? AND p.devuelto = 0";
        return $this->conexion->getDataAll($sql, [$idusuario, 0]);
    }
    //-------------------------------------------------------------
    //----------se llama en la vista verPaquete para visualizar la información de un paquete agregado por un cliente ----
    public function paqueteInform($paqueteid){
        $sql = "SELECT rutaID, destinoID, descripcion, es_personalizado, nombre_cliente, telefono_cliente, telefono_vendedor, DATE(fecha_envio) as fecha_envio, precio, costo_envio, direccion_cliente, recibido_recepcion FROM paquerte WHERE paqueteID = ?";
        return $this->conexion->getData($sql, [$paqueteid]);
    }
    public function paqueteInformDestino($paqueteid){
        $sql = "SELECT r.dia, d.lugar_destino, d.descripcion_destino, d.hora_desde, d.hora_hasta FROM paquerte p INNER JOIN ruta r ON p.rutaID = r.rutaID INNER JOIN destino d ON p.destinoID = d.destinoID WHERE paqueteID = ?";
        return $this->conexion->getData($sql, [$paqueteid]);
    }
    //-------------------------------------------------------------
    //----------se llama en la vista verPaquete para editar un paquete por un vendedor ----
    public function editarPaq($infoPaquete){
        $sql = "UPDATE paquerte SET vendedorID = ?, rutaID = ?, destinoID = ?, descripcion = ?, es_personalizado = ?, nombre_cliente = ?, telefono_cliente = ?, telefono_vendedor = ?, fecha_envio = ?, precio = ?, costo_envio = ?, direccion_cliente = ?, recibido_recepcion = ? WHERE paqueteID = ?";
        return $this->conexion->setData($sql, [$infoPaquete[0], $infoPaquete[1], $infoPaquete[2], $infoPaquete[3], $infoPaquete[4], $infoPaquete[5], $infoPaquete[6], $infoPaquete[7], $infoPaquete[8], $infoPaquete[9], $infoPaquete[10], $infoPaquete[11], $infoPaquete[12], $infoPaquete[13]]);
    }
    //-------------------------------------------------------------
    // para obetener el último correlativo de los paquetes, se llama desde agregarPaquete de la vista de recepcion
    public function ultimoCorrelativo(){
        $sql = "SELECT identificador FROM paquerte ORDER BY fecha_entrega DESC LIMIT 1";
        return $this->conexion->getData($sql, []);
    }
    //-------------------------------------------------------------
    // para listar los paquetes a confirmar por recepcion se llama desde la vista paquetesRecibir
    public function listarPaquetesAConfirmar(){
        $sql = "SELECT p.paqueteID, p.identificador, p.nombre_cliente, c.nombre_cliente as vendedor, DATE(p.fecha_envio) as fecha, p.es_personalizado FROM paquerte p INNER JOIN cliente c ON p.vendedorID = c.clienteID WHERE p.recibido_recepcion = ?";
        return $this->conexion->getDataAll($sql, [0]);
    }
    //-------------------------------------------------------------
    // para confirmar la recepcion de un paquete se llama desde la vista paquetesRecibir
    public function confirmarRecepcionPaquete($paqueteID, $costoEnvio){
        $sql = "UPDATE paquerte SET recibido_recepcion = ?, costo_envio = ?, estado = ?, total = (precio + ?) WHERE paqueteID = ?";
        return $this->conexion->setData($sql, [1, $costoEnvio, 'En bodega', $costoEnvio, $paqueteID]);
    }
    //-------------------------------------------------------------
    // para listar los paquetes de un destino para que sea confirmada su salida por el de recepcion se llama desde la vista rutas de recepcion
    public function listarPaquetesRuta($rutaID, $destinoID, $fecha){
        $sql = "SELECT p.paqueteID, p.identificador, c.nombre_cliente as vendedor, p.nombre_cliente, DATE(p.fecha_envio) as fecha, p.listoSalir FROM paquerte p INNER JOIN cliente c ON p.vendedorID = c.clienteID WHERE p.rutaID = ? AND p.destinoID = ? AND p.recibido_recepcion = ? AND p.fecha_envio = ?";
        return $this->conexion->getDataAll($sql, [$rutaID, $destinoID, 1, $fecha]);
    }
    //-------------------------------------------------------------
    // para listar los paquetes de envio personalizado para que sea confirmada su salida por el de recepcion se llama desde la vista rutas de recepcion
    public function listarPaquetesPersonalizados(){
        $sql = "SELECT p.paqueteID, p.identificador, c.nombre_cliente as vendedor, p.nombre_cliente, DATE(p.fecha_envio) as fecha, p.listoSalir FROM paquerte p INNER JOIN cliente c ON p.vendedorID = c.clienteID WHERE p.es_personalizado = ? AND p.recibido_recepcion = ? AND p.estado = 'En bodega'";
        return $this->conexion->getDataAll($sql, [1, 1]);
    }
    //-------------------------------------------------------------
    // para confirmar la salida de un paquete se llama desde la vista rutas de recepcion
    public function confirmarSalida($paqueteID){
        $sql = "UPDATE paquerte SET listoSalir = ? WHERE paqueteID = ?";
        return $this->conexion->setData($sql, [1, $paqueteID]);
    }
    //-------------------------------------------------------------
    // listar los paquetes ya confirmados para su salida se llama desde la vista rutas del repartidor
    public function listarPaquetesRutaConfirmados($rutaID, $destinoID, $fecha){
        $sql = "SELECT p.paqueteID, p.identificador, p.estado, p.nombre_cliente, c.nombre_cliente as vendedor, p.fecha_envio as fecha FROM paquerte p INNER JOIN cliente c ON p.vendedorID = c.clienteID WHERE p.rutaID = ? AND p.destinoID = ? AND p.listoSalir = ? AND p.fecha_envio = ?";
        return $this->conexion->getDataAll($sql, [$rutaID, $destinoID, 1, $fecha]);
    }
    //-------------------------------------------------------------
    // para confirmar la entrega de un paquete se llama desde la vista destino del repartidor
    public function confirmarEntrega($paqueteID){
        $sql = "UPDATE paquerte SET estado = ? WHERE paqueteID = ?";
        return $this->conexion->setData($sql, ['Entregado', $paqueteID]);
    }
    //-------------------------------------------------------------
    // para listar los paquetes de envio personalizado de hoy en la vista paquetesPersonalizado del repartidor
    public function listarPaquetesPersonalizadosHoy(){
        $sql = "SELECT p.paqueteID, p.identificador, p.nombre_cliente, DATE(p.fecha_envio) as fecha, p.estado FROM paquerte p WHERE p.es_personalizado = ? AND p.listoSalir = ? AND DATE(p.fecha_envio) = CURDATE()";
        return $this->conexion->getDataAll($sql, [1, 1]);
    }
    //-------------------------------------------------------------
    // para listar todos los paquetes de envio personalizado en la vista paquetesPersonalizado del repartidor
    public function listarPaquetesPersonalizadosT(){
        $sql = "SELECT p.paqueteID, p.identificador, p.nombre_cliente, DATE(p.fecha_envio) as fecha, p.estado FROM paquerte p WHERE p.es_personalizado = ? AND p.fecha_envio > CURDATE() AND p.recibido_recepcion = ?";
        return $this->conexion->getDataAll($sql, [1, 1]);
    }
    //-------------------------------------------------------------
    //para listar los paquetes que no fueron retirados por el cliente en la vista noRetirados de recepcion
    public function listarNoRetirados(){
        $sql = "SELECT p.paqueteID, p.identificador, c.nombre_cliente as vendedor, c.telefono_cliente as telefono, p.nombre_cliente, DATE(p.fecha_envio) as fecha, p.estado FROM paquerte p INNER JOIN cliente c ON p.vendedorID = c.clienteID WHERE p.recibido_recepcion = ? AND p.estado = ? AND p.devuelto = 0";
        return $this->conexion->getDataAll($sql, [1, 'No retirado']);
    }
    //-------------------------------------------------------------
    //para devolver un paquete que no fue retirado por el cliente en la vista noRetirados de recepcion
    public function devolverPaquete($paqueteID){
        $sql = "UPDATE paquerte SET devuelto = ? WHERE paqueteID = ?";
        return $this->conexion->setData($sql, [1, $paqueteID]);
    }
    //-------------------------------------------------------------
    // para reprogramar la entrega de un paquete se llama desde la vista noRetirados de recepcion
    public function reprogramarPaquete($ruta, $destinoID, $fecha, $costoEnvio, $paqueteID){
        $sql = "UPDATE paquerte SET rutaID = ?, destinoID = ?, fecha_envio = ?, costo_envio = ?, estado = ?, total = (precio + ?) WHERE paqueteID = ?";
        return $this->conexion->setData($sql, [$ruta, $destinoID, $fecha, $costoEnvio, 'En bodega', $costoEnvio, $paqueteID]);
    }
    //-------------------------------------------------------------
    //-------------------------------------------------------------
    // -----------------------------------------------------------------------------------------------------------
    // -----------------------------------------------------------------------------------------------------------
    // -----------------------------------------------------------------------------------------------------------
}
