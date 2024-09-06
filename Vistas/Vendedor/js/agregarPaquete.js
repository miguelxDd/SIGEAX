//para cuando sea envio normal guardamos la ruta y destino
let rutaDestino = {};
//llenar el select de las categorias de productos por si quiere hacer la estimación del costo de envío
fetch('Controladores/paquete.php?accion=categoriasProd').then(respuesta => respuesta.text()).then(categorias => {
    elementoID('categoria_producto').innerHTML = categorias;
});
//para la accion de ocultar inputs 
document.querySelectorAll('.infoFormularios').forEach((formulario, indice) => {
    //obtenemos la cabeza de las tarjetas 
    let cabezaTarjeta = formulario.querySelector('.card-header');
    //escuchamos el evento click solo en la cabeza de la tarjeta 
    cabezaTarjeta.addEventListener('click', evento => { 
        //vemos si el icono esta con el de ocultar, es decir, se esta mostrando, entonces lo ocultamos
        if(cabezaTarjeta.querySelector('.feather').classList[1] == 'feather-chevron-up'){
            switch(indice){
                //ocultamos el cuerpo de la tarjeta que corresponda
                case 0: animarSalidaID('formCliente'); break;
                case 1: animarSalidaID('formEntrega'); break;
                case 2: animarSalidaID('formPaquete'); break;
            }
            cabezaTarjeta.querySelector('svg').remove();
            cabezaTarjeta.insertAdjacentHTML('beforeend', '<i data-feather="chevron-down" class="ms-2 mb-1"></i>');
        }else{
            //si el icono esta con el de mostrar quiere decir que está oculto entonces lo mostramos
            switch(indice){
                //mostramos el cuerpo de la tarjeta que corresponda
                case 0: animarEntradaID('formCliente'); break;
                case 1: animarEntradaID('formEntrega'); break;
                case 2: animarEntradaID('formPaquete'); break;
            }                
            cabezaTarjeta.querySelector('svg').remove();
            cabezaTarjeta.insertAdjacentHTML('beforeend', '<i data-feather="chevron-up" class="ms-2 mb-1"></i>');
        }
        //Para insertar los iconos Father
        feather.replace();
    });
});

//insertamos lo necesario a la hora de seleccionar el tipo de envio
elementoID('tipo_envio').onchange = (seleccion) => {
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
            <div class="row">
                <label for="fecha_envio" class="col-md-2 col-form-label my-1">Fecha de envío (*):</label>
                <div class="col-md-5 my-1">
                    <input type="date" class="form-control" id="fecha_envio" name="fecha_envio" required>
                </div>
            </div>
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
}

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

elementoID('formAgregarPaquete').onsubmit = (e) => {
    e.preventDefault();
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
                    fetch('Controladores/paquete.php?accion=guardarPaqVendedor', {method: 'POST', body: formPaquete})
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
                fetch('Controladores/paquete.php?accion=guardarPaqVendedor', {method: 'POST', body: formPaquete})
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
            title: 'Paquete agregado correctamente',
            text: 'Acercate a entregar el paquete',
            icon: 'success',
            button: 'Aceptar'
        });
        elementoID('formAgregarPaquete').reset();
    }else{
        swal({
            title: 'Ha ocurrido un error',
            text: 'Hemos tenido un error inisperado, intenta de nuevo o más tarde',
            icon: 'warning',
            button: 'Aceptar'
        });
    }
}