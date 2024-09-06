insertarFormularioRegistro()
function insertarFormularioRegistro(){
    elementoID('seccionRegistrarVendedor').innerHTML = formularioRegistroVendedor(false);
}
//para cuando sea envio normal guardamos la ruta y destino
let rutaDestino = {};
let vendedorSeleccionado = false
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
                case 0: animarSalidaID('formVendedor'); break;
                case 1: animarSalidaID('formCliente'); break;
                case 2: animarSalidaID('formEntrega'); break;
                case 3: animarSalidaID('formPaquete'); break;
            }
            cabezaTarjeta.querySelector('svg').remove();
            cabezaTarjeta.insertAdjacentHTML('beforeend', '<i data-feather="chevron-down" class="ms-2 mb-1"></i>');
        }else{
            //si el icono esta con el de mostrar quiere decir que está oculto entonces lo mostramos
            switch(indice){
                //mostramos el cuerpo de la tarjeta que corresponda
                case 0: animarEntradaID('formVendedor'); break;
                case 1: animarEntradaID('formCliente'); break;
                case 2: animarEntradaID('formEntrega'); break;
                case 3: animarEntradaID('formPaquete'); break;
            }                
            cabezaTarjeta.querySelector('svg').remove();
            cabezaTarjeta.insertAdjacentHTML('beforeend', '<i data-feather="chevron-up" class="ms-2 mb-1"></i>');
        }
        //Para insertar los iconos Father
        feather.replace();
    });
});

//oculta la sección de registrar vendedor al principio
elementoID('seccionRegistrarVendedor').style.display = 'none';
//para cuando se seleccione la opción de registrar vendedor
function cambiarARegistrarVendedor(){
    animarSalidaID('seccionBuscarVendedor'); animarEntradaID('seccionRegistrarVendedor');
}

//parta mostrar los vendedores registrados en el modal
document.querySelector('button[data-bs-target="#modalVendedor"]').addEventListener('click', () => {
    listarVendedores();
})
function listarVendedores(){
    $('#tablaVendedores').dataTable({
        ajax: 'Controladores/cliente.php?accion=listarVendedores',
        destroy: true,
        iDisplayLength: 10, //paginacion
        order: [[0, 'desc']], //ordenar (columna, orden)
        lengthChange: false,
        language: {
            search: "Buscar:",
            info: "Mostrando _START_ a _END_ de _TOTAL_ vendedores", // Personaliza el mensaje de información
            info: "Mostrando _END_ de un total de _TOTAL_ vendedores", // Personaliza el mensaje de información
            paginate: {
                first: "Primero", // Personaliza el control para ir a la primera página
                last: "Último", // Personaliza el control para ir a la última página
                next: "Siguiente", // Personaliza el control para ir a la siguiente página
                previous: "Anterior" // Personaliza el control para ir a la página anterior
            },
            zeroRecords: "Aún no se han agregado vendedores"
        }
    }).on('draw.dt', () => { feather.replace(); });
}

//seleccionar vendedor
function seleccionarVendedor(vendedorID, nombre, directo = true){
    elementoID('vendedorID').value = vendedorID;
    elementoID('nombre_vendedor').value = nombre;
    listarNegociosVededor(vendedorID, directo);
}

function listarNegociosVededor(vendedorID, directo = true){
    fetch('Controladores/negocio.php?accion=listarNegociosVendedor&vendedorID=' + vendedorID).then(respuesta => respuesta.json())
    .then(negocios => {
        if(negocios.estado === true){
            elementoID('negocio_vendedor').innerHTML = negocios.negocios;
        }else{
            elementoID('negocio_vendedor').innerHTML = `<option value="0">No hay negocios registrados</option>`;
        }
        vendedorSeleccionado = true;
        document.querySelector('.cerrarModalSelecVendedor').click(); cambiarABuscarVendedor(true, directo);
    });
}



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
            <div class="col-md-6 my-1">
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

elementoID('formAgregarPaquete').onsubmit = (e) => {
    e.preventDefault();
    if(elementoID('tipo_envio').value == '' || !vendedorSeleccionado){
        if(!vendedorSeleccionado){
            document.querySelector('.seleccioneVendedor').classList.add('show');
            setTimeout(() => { document.querySelector('.seleccioneVendedor').classList.remove('show'); }, 4500);
        }
        else{
            elementoID('tipo_envio').focus();
            elementoID('tipo_envio').classList.add('bordeError'); setInterval(() => { elementoID('tipo_envio').classList.remove('bordeError'); }, 3500);
        }
    }else{
        let formPaquete = new FormData(elementoID('formAgregarPaquete'));
        if(elementoID('tipo_envio').value == 'normal'){
            if(rutaDestino.ruta != undefined && rutaDestino.destino != undefined){                
                fetch('Controladores/paquete.php?accion=infoVendedor&vendedorID='+elementoID('vendedorID').value).then(respuesta => respuesta.json()).then(infoVendedor => {
                    formPaquete.append('vendedorID', infoVendedor.vendedorID); formPaquete.append('telefono_vendedor', infoVendedor.telefono);
                    formPaquete.append('rutaid', rutaDestino.ruta); formPaquete.append('destinoid', rutaDestino.destino);
                    formPaquete.append('estimacion_envio', elementoID('costo_envio').value);
                    fetch('Controladores/paquete.php?accion=guardarPaqVendedor&recepcion=1', {method: 'POST', body: formPaquete})
                    .then(respuesta => respuesta.text()).then(res => {
                        confirmacionAgregarPaquete(res);
                    });
                });
            }else{
                document.querySelector('.destinoCompleto').classList.add('show');
                setTimeout(() => { document.querySelector('.destinoCompleto').classList.remove('show'); }, 4500);
            }
        }else{
            fetch('Controladores/paquete.php?accion=infoVendedor&vendedorID='+elementoID('vendedorID').value).then(respuesta => respuesta.json()).then(infoVendedor => {
                formPaquete.append('vendedorID', infoVendedor.vendedorID); formPaquete.append('telefono_vendedor', infoVendedor.telefono);
                formPaquete.append('estimacion_envio', elementoID('costo_envio').value);
                fetch('Controladores/paquete.php?accion=guardarPaqVendedor&recepcion=1', {method: 'POST', body: formPaquete})
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
            title: 'Paquete agregado correctamente CAMBIADO',
            text: 'Confirmación cambiada',
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