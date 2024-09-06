<?php
class Componentes{
    public function __construct()
    {}

    //para mostrar el historial de paquetes de un cliente en la vista historialOrdenes
    public function vistaDetallePaquete($estado, $tipo, $vendedor, $descripcion, $precio, $costoEnvio, $destino, $fecha, $idPaquete, $identificador, $masDetalle = 0, $telCli = '', $telVen = ''){
        $fechaArray = explode('-', $fecha);
        $fecha = $fechaArray[2] . '-' . $fechaArray[1] . '-' . $fechaArray[0];
        $masInfo = ''; $boton = '<a class="btn btn-primary" href="detallePaquete" role="button" onclick="verDetalle('.$idPaquete.',\''.$tipo.'\')">Ver detalles</a>';
        if($masDetalle == 1){
            $masInfo = '
            <p>Telefono cliente: '.$telCli.'</p>
            <p>Telefono vendedor: '.$telVen.'</p>
            ';
            $boton = '';
        }
        return '
        <div class="col">
            <div class="card h-100 ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <small class="text-body-secondary">Estado: '.$estado.'</small>
                        </div>
                        <div class="col-6 text-end">
                            <small class="text-body-secondary">'.$tipo.'</small>    
                        </div>                                
                    </div>
                </div>
                <div class="card-body">
                    <small class="text-body-secondary">Identificador de paquete: '.$identificador.'</small>
                    <h5 class="card-title">Vendedor: '.$vendedor.'</h5>
                    <p class="">'.$descripcion.'</p>
                    <div class="row">
                        <div class="col-6">
                            <p>Precio: $'.$precio.'</p>
                        </div>
                        <div class="col-6">
                            <p id="costoDeEnvioDetalle">Costo Envío: $'.$costoEnvio.'</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p>Total: $'.number_format(($precio+$costoEnvio), 2, '.', ',').'</p>
                        </div>
                    </div>
                    <p>'. (($tipo == 'Envio normal')? 'Destino' : 'Dirección') .': '.$destino.'</p>
                    <p>Fecha envío: '.$fecha.'</p>'. $masInfo .''.$boton.'
                </div>
            </div>
        </div>
        ';
    }

    //para mostrar las fechas de los estados de un paquete en detallePaquete
    public function tablaEstadosPaquete($estados){
        $filasEstado = '';
        foreach($estados as $estado){
            $filasEstado .= '
            <tr>
                <td>'.$estado['estado'].'</td>
                <td>'.$estado['fecha_estado'].'</td>
            </tr>
            ';
        }
        return '
        <h5>Historial del paquete</h5>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Estado</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                '.$filasEstado.'
            </tbody>
        </table>
        ';
    }

    //para mostrar las categorias de productos agregadas para poder hacer estimacion del costo de envío
    public function selectProductosCategoria($productosCat){
        $productos = '<option value="">Seleccione una categoria</option>';
        foreach($productosCat as $cat){
            $productos .= '<option value="'.$cat['categoriaID'].'">'.$cat['nombre_categoria'].'</option>';
        }
        return $productos;
    }
    
    //para mostrar los productos agregados en una categoria específica para poder hacer estimacion del costo de envío
    public function opcionesProductosCat($productos){        
        $opciones = '<option value="" costoEstimado="0.00">Seleccione producto</option>';
        foreach($productos as $pro){
            $opciones .= '<option value="'.$pro['producto_categoriaID'].'-'.$pro['costo_estimado_envio'].'">'.$pro['nombre_producto'].'</option>';
        }
        return '
        <label for="producto" class="col-form-label me-1" id="labelProducto">Producto:</label>
        <select name="producto" id="producto" class="form-select">
            '.$opciones.'
        </select>';
    }

    //para mostrar las rutas al momento de estar agregando un paquete de envio normal por parte de un vendedor
    public function rutas($rutas, $paraRepartidor = false){
        $opRutas = '';
        foreach($rutas as $ruta){
            $opRutas .= '<li class="list-group-item rutas" rutaid="'.$ruta['rutaID'].'">'.$ruta['dia'].'</li>';
        }
        return '
        <div class="card mx-1 my-2 col-sm-4 p-0">
            <div class="card-header">Seleccione ruta '. (($paraRepartidor == false)? '(*)' : '') . '</div>
            <div style="max-height: ' . (($paraRepartidor == false)? '250px;' : '500px') . '; overflow-y: auto;">
                <ul class="list-group list-group-flush">
                    '.$opRutas.'
                </ul>
            </div>
        </div>
        <div class="card mx-1 my-2 col-sm-7 p-0">
            <div class="card-header">Seleccione destino '. (($paraRepartidor == false)? '(*)' : '') . '</div>
            <div style="max-height:' . (($paraRepartidor == false)? '250px;' : '500px') . '; overflow-y: auto;" id="destinosDeRuta">
                <p class="text-center mt-3">Seleccione una ruta</p>
            </div>
        </div>
        ';
    }

    //para mostrAR los destinos de una ruta específica para un vendedor al estar agregando paquete
    public function destinos($destinos, $paraRepartidor = false){
        $opDestinos = '';
        foreach($destinos as $dest){
            $mas = '';
            if($paraRepartidor != false){
                if(isset($dest['finalizada'])){
                    if($dest['finalizada'] == 1){
                        $mas = '<div class="bg-success text-white text-center mt-1 p-2" style="border-radius: 20px; width: 50%; margin: auto;">Finalizada</div>';
                    }
                }
            }
            $opDestinos .= '<li class="list-group-item destinos" destinoid="'.$dest['destinoID'].'" style="cursor: pointer;"><strong>'.$dest['lugar_destino'].': </strong>'.$dest['descripcion_destino'].'   ('.$dest['nombre_municipio'].', '.$dest['nombre_departamento'].').
            <div style="background-color: cadetblue; border-radius: 20px; text-align: center; padding: 5px 10px;"> Desde: '.$dest['hora_desde'].'h  Hasta: '.$dest['hora_hasta'].'h</div>
            ' . $mas . '
            </li>';
        }
        return '
        <ul class="list-group list-group-flush">
            '.$opDestinos.'
        </ul>
        ';
    }

    //para mostrar la info de un destino específico desde la vista rutas de recepcion
    public function infoDestino($info){
        return '
            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                <p><strong>'. $info['lugar_destino'] .'</strong></p>
                <p>'. $info['descripcion_destino'] .' ('. $info['nombre_municipio'] .', '. $info['nombre_departamento'] .')</p>
                <div style="background-color: rgb(130, 171, 172); border-radius: 20px; text-align: center; padding: 5px 10px;"> Desde: '. $info['hora_desde'] .'h  Hasta: '. $info['hora_hasta'] .'h</div>
            </div>
        ';
    }

    //para mostrar las rutas para el administrador en la vista gestionarRutas
    public function listarRutas($lista){
        $rutas = '';
        foreach($lista as $ruta){
            $rutas .= '
                <div class="itemRuta">
                    <div class="rutaDia"><h5>' . $ruta['dia'] . '</h5></div>
                    <section class="rutaBotones">
                        <button class="btn btn-primary" onclick="verRuta('. $ruta['rutaID'] . ')">
                            <i data-feather="eye"></i>
                        </button>
                        <button class="btn btn-warning" onclick="editarRuta('. $ruta['rutaID'] . ')">
                            <i data-feather="edit"></i>
                        </button>
                        <button class="btn btn-danger" onclick="eliminarRuta('. $ruta['rutaID'] . ')">
                            <i data-feather="trash"></i>
                        </button>
                    </section>
                </div>
            ';
        }
        return $rutas;
    }

    //para listar los destinos de una ruta específica Administrador en la vista gestionarRutas
    public function listarDestinosRuta($destinos){
        $destinosRuta = '';
        foreach($destinos as $dest){
            $destinosRuta .= '
            <li class="list-group-item itemDestino" destinoid="'.$dest['destinoID'].'">
                <strong>'.$dest['lugar_destino'].': </strong>'.$dest['descripcion_destino'].'   ('.$dest['nombre_municipio'].', '.$dest['nombre_departamento'].').
                <div style="background-color: rgb(130, 171, 172); border-radius: 20px; text-align: center; padding: 5px 10px;">
                    Desde: '.$dest['hora_desde'].'h  Hasta: '.$dest['hora_hasta'].'h
                </div>
                <section class="destinoBotones">
                    <button class="btn btn-warning" onclick="editarDestino('. $dest['destinoID'] . ')">
                        <i data-feather="edit"></i>
                    </button>
                    <button class="btn btn-danger" onclick="eliminarDestino('. $dest['destinoID'] . ')">
                        <i data-feather="trash"></i>
                    </button>
                </section>
            </li>
            ';
        }
        return $destinosRuta;
    }

    //para listar las categorias para el administrador en la vista gestionarCatalogoReferencia
    public function listarCategorias($lista){
        $categorias = '';
        foreach($lista as $categoria){
            $categorias .= '
                <div class="itemRuta">
                    <div class="rutaDia"><h5>' . $categoria['nombre_categoria'] . '</h5></div>
                    <section class="rutaBotones">
                        <button class="btn btn-primary" onclick="verCategoria('. $categoria['categoriaID'] . ')">
                            <i data-feather="eye"></i>
                        </button>
                        <button class="btn btn-warning" onclick="editarCategoria('. $categoria['categoriaID'] . ')">
                            <i data-feather="edit"></i>
                        </button>
                        <button class="btn btn-danger" onclick="eliminarCategoria('. $categoria['categoriaID'] . ')">
                            <i data-feather="trash"></i>
                        </button>
                    </section>
                </div>
            ';
        }
        return $categorias;
    }
    //para listar los productos de una categoria específica en la vista gestionarCatalogoReferencia
    public function listarProductos($productos){
        $listaProductos = '';
        foreach($productos as $producto){
            $listaProductos .= '
            <li class="list-group-item itemDestino">
                <strong>'.$producto['nombre_producto'].' </strong>
                <div style="background-color: rgb(130, 171, 172); border-radius: 20px; text-align: center; padding: 5px 10px;">
                    Costo estimado envío: $'.$producto['costo_estimado_envio'].'
                </div>
                <section class="destinoBotones">
                    <button class="btn btn-warning" onclick="editarProducto('. $producto['producto_categoriaID'] . ')">
                        <i data-feather="edit"></i>
                    </button>
                    <button class="btn btn-danger" onclick="eliminarProducto('. $producto['producto_categoriaID'] . ')">
                        <i data-feather="trash"></i>
                    </button>
                </section>
            </li>
            ';
        }
        return $listaProductos;
    }
}
?>