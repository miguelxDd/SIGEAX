//para cuando sea envio normal guardamos la ruta y destino en caso edite la información
let rutaDestino = {};
ocultarID('btnConfEditar'); camposSoloLectura(true);
//ocultamos el contenido que se habilitará solo si decide editar
ocultarID('envioNormal1'); ocultarID('envioPersonalizado1');
ocultarID('estimarCostoEnvio');
//traemos la información del paquete y la mostramos donde corresponde
fetch('Controladores/paquete.php?accion=verPaquete&paquete=' + localStorage.getItem('verPaqID')).then(respuesta => respuesta.json()).then(infoPaq => {
    elementoID('nombre_cliente').value = infoPaq.nombre_cliente; 
    elementoID('telefono_cliente').value = infoPaq.telefono_cliente; 
    elementoID('fecha_envio').value = infoPaq.fecha_envio;
    elementoID('tipo_envio').value = (infoPaq.es_personalizado == 0)? 'Envio normal' : 'Envio personalizado';
    if(infoPaq.es_personalizado == 0){
        fetch('Controladores/paquete.php?accion=infoDestino&paquete=' + localStorage.getItem('verPaqID')).then(respuesta => respuesta.json()).then(informac => {
            animarEntradaID('envioNormal1');
            elementoID('ruta').value = informac.dia;
            elementoID('destino').value = informac.lugar_destino + ': ' + informac.descripcion_destino + '. Desde las '
            + informac.hora_desde + 'horas a las ' + informac.hora_hasta + 'horas';
        });
    }else{
        animarEntradaID('envioPersonalizado1');
        elementoID('direccion').value = infoPaq.direccion_cliente;
    }
    elementoID('descripcion_paquete').value = infoPaq.descripcion;
    elementoID('precio_paquete').value = infoPaq.precio;
    elementoID('labelEstimacionVer').innerText = '$' + infoPaq.costo_envio;
});

elementoID('editarInform').onclick = () => {
    camposSoloLectura(false); ocultarID('btnEditar'); mostrarID('btnConfEditar');
    elementoID('inputTipo_envio').innerHTML = `
    <select name="tipo_envio" id="tipo_envio" class="form-select">
        <option value="" selected>Seleccione</option>
        <option value="normal">Normal</option>
        <option value="personalizado">Personalizado</option>
    </select>
    `;
    //ocultamos los que eran para visualizar la información
    ocultarID('envioNormal1'); ocultarID('envioPersonalizado1');
    ocultarID('verEstimacionCostoEnvio');
    //mostramos para que pueda hacer la estimacion de costo de envio
    animarEntradaID('estimarCostoEnvio');
    //eschuchamos que destino va seleccionar en caso de envio normal o habilitamos para la direccion en casi envio personalizado
    elementoID('tipo_envio').addEventListener('change', (seleccion) =>{
        if(seleccion.target.value == 'normal'){
            //si es envio normal mostramos primero las rutas para que seleccione
            elementoID('envioPersonalizado').innerHTML = '';
            fetch('Controladores/ruta.php?accion=listarRutas').then(respuesta => respuesta.text()).then(rutas => {
                elementoID('envioNormal').innerHTML = rutas;
                ocultarID('envioNormal'); animarEntradaID('envioNormal');
                //escuchamos cual selecciona y mostramos los destinos de la seleccionada
                document.querySelectorAll('.rutas').forEach((selec) => {
                    selec.addEventListener('click', () => {
                        document.querySelectorAll('.rutas').forEach((desac) => { desac.classList.remove('active'); });
                        selec.classList.add('active');
                        //guardamos la ruta que se ha seleccionado
                        if(selec.classList.contains('active')){ rutaDestino.ruta = selec.getAttribute('rutaid'); }
                        fetch('Controladores/ruta.php?accion=listarDestinos&ruta=' + selec.getAttribute('rutaid')).then(respuesta => respuesta.text()).then(destinos => {
                            elementoID('destinosDeRuta').innerHTML = destinos;
                            //escuchamos que destino selecciona y lo colocamos como selección
                            document.querySelectorAll('.destinos').forEach((desti) => {
                                desti.addEventListener('click', () => {
                                    document.querySelectorAll('.destinos').forEach((des) => { des.classList.remove('active'); });
                                    desti.classList.add('active');
                                    //guardamos el destino que se ha seleccionado
                                    if(desti.classList.contains('active')){ rutaDestino.destino = desti.getAttribute('destinoid'); }
                                    document.querySelector('.toast').classList.add('show');
                                    setTimeout(() => { document.querySelector('.toast').classList.remove('show'); }, 3500);
                                });
                            });
                        });
                    });
                });
            });
        }else{
            if(seleccion.target.value == 'personalizado'){
                //si es envio personalizado mostramos para que ingrese una dirección especifica
                elementoID('envioNormal').innerHTML = '';
                elementoID('envioPersonalizado').innerHTML = `
                <label for="direccion_paquete" class="col-md-2 col-form-label my-1">Dirección (*):</label>
                <div class="col-md-5 my-1">
                <input type="text" class="form-control" id="direccion_paquete" name="direccion_paquete" required>
                </div>
                <label class="col-md-4 col-form-label text-secondary ms-2">Escriba una dirección detallada</label>
                `;
                ocultarID('envioPersonalizado'); animarEntradaID('envioPersonalizado');
            }else{
                //si regresa a "Seleccione" quitamos todo de nuevo
                animarSalidaID('envioPersonalizado'); animarSalidaID('envioNormal');
                elementoID('envioNormal').innerHTML = '';            
                elementoID('envioPersonalizado').innerHTML = '';
            }
        }
    });
    //mostramos las categorias para poder hacer la estimacion del costo de envio
    fetch('Controladores/paquete.php?accion=categoriasProd').then(respuesta => respuesta.text()).then(categorias => {
        elementoID('categoria_producto').innerHTML = categorias;
    });
    //para listar los productos de la categoria seleccionada
    elementoID('categoria_producto').onchange = (seleccion) => {
        fetch('Controladores/paquete.php?accion=listarProductosCat&categoria=' + seleccion.target.value).then(respuesta => respuesta.text()).then(productos => {
            elementoID('colProductosCat').innerHTML = productos;
            //para poner el costo estimado de envio al seleccionar un producto
            elementoID('producto').addEventListener('change', (seleccion) => {
                elementoID('labelEstimacion').innerText = '$' + seleccion.target.value.split('-')[1];
            })
        });
    }
}

//para actualizar la informacion
elementoID('confeditarInform').onclick = () => {
    // e.preventDefault();
    if(elementoID('tipo_envio').value == ''){
        elementoID('tipo_envio').focus();
        elementoID('tipo_envio').classList.add('bordeError'); setInterval(() => { elementoID('tipo_envio').classList.remove('bordeError'); }, 3500);
    }else{
        let formPaquete = new FormData(elementoID('formAgregarPaquete'));
        if(elementoID('tipo_envio').value == 'normal'){
            if(rutaDestino.ruta != undefined && rutaDestino.destino != undefined){
                fetch('Controladores/paquete.php?accion=infoVendedor').then(respuesta => respuesta.json()).then(infoVendedor => {
                    formPaquete.append('vendedorID', infoVendedor.vendedorID); formPaquete.append('telefono_vendedor', infoVendedor.telefono);
                    formPaquete.append('rutaid', rutaDestino.ruta); formPaquete.append('destinoid', rutaDestino.destino);
                    formPaquete.append('estimacion_envio', elementoID('labelEstimacion').innerText.split('$')[1]);
                    formPaquete.append('paqueteID',  localStorage.getItem('verPaqID'));
                    fetch('Controladores/paquete.php?accion=editarPaqVendedor', {method: 'POST', body: formPaquete})
                    .then(respuesta => respuesta.text()).then(res => {
                        confirmacionAgregarPaquete(res);
                    });
                });
            }else{
                document.querySelector('.destinoCompleto').classList.add('show');
                setTimeout(() => { document.querySelector('.destinoCompleto').classList.remove('show'); }, 4500);
            }
        }else{
            fetch('Controladores/paquete.php?accion=infoVendedor').then(respuesta => respuesta.json()).then(infoVendedor => {
                formPaquete.append('vendedorID', infoVendedor.vendedorID); formPaquete.append('telefono_vendedor', infoVendedor.telefono);
                formPaquete.append('estimacion_envio', elementoID('labelEstimacion').innerText.split('$')[1]);
                formPaquete.append('paqueteID',  localStorage.getItem('verPaqID'));
                fetch('Controladores/paquete.php?accion=editarPaqVendedor&paquete=' + localStorage.getItem('verPaqID'), {method: 'POST', body: formPaquete})
                .then(respuesta => respuesta.text()).then(res => {
                    confirmacionAgregarPaquete(res);
                });
            });
        }
    }
}

function confirmacionAgregarPaquete(respuesta){
    if(respuesta == '1'){
        swal({
            title: 'Paquete actualizado correctamente',
            text: '',
            icon: 'success',
            buttons: false 
        });
        setTimeout( () => { window.location.href = 'paquetesVendedor'; }, 2000);
    }else{
        swal({
            title: 'Ha ocurrido un error',
            text: 'Hemos tenido un error inisperado, intenta de nuevo o más tarde',
            icon: 'warning',
            button: 'Aceptar'
        });
    }
}

function camposSoloLectura(activado){
    elementoID('nombre_cliente').readOnly = activado;
    elementoID('telefono_cliente').readOnly = activado;
    elementoID('fecha_envio').readOnly = activado;
    elementoID('tipo_envio').readOnly = activado;
    elementoID('ruta').readOnly = activado;
    elementoID('destino').readOnly = activado;
    elementoID('direccion').readOnly = activado;
    elementoID('descripcion_paquete').readOnly = activado;
    elementoID('precio_paquete').readOnly = activado;
    elementoID('labelEstimacionVer').readOnly = activado;
    //si es para habilitarlos para la lectura los ponemos required también
    if(!activado){
        elementoID('nombre_cliente').required = !activado;
        elementoID('telefono_cliente').required = !activado;
        elementoID('fecha_envio').required = !activado;
        elementoID('tipo_envio').required = !activado;
        elementoID('ruta').required = !activado;
        elementoID('destino').required = !activado;
        elementoID('direccion').required = !activado;
        elementoID('descripcion_paquete').required = !activado;
        elementoID('precio_paquete').required = !activado;
        elementoID('labelEstimacionVer').required = !activado;        
    }
}