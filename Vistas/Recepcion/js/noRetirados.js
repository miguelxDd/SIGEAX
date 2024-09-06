listarNoRetirados(); elementoID('btnCancelarReprogramacion').style.display = 'none'; elementoID('btnGuardarReprogramacion').style.display = 'none'
let idPaqueteViendo = 0, rutaDestino = {}
function listarNoRetirados(){
    $('#noRetirados').dataTable({
        ajax: 'Controladores/paquete.php?accion=noRetirados',
        destroy: true,
        iDisplayLength: 10,
        order: [[ 3, "desc" ]],
        lengthChange: false,
        language: {
            search: "Buscar:",
            info: "Mostrando _START_ a _END_ de _TOTAL_ paquetes", // Personaliza el mensaje de información
            info: "Mostrando _END_ de un total de _TOTAL_ paquetes", // Personaliza el mensaje de información
            paginate: {
                first: "Primero", // Personaliza el control para ir a la primera página
                last: "Último", // Personaliza el control para ir a la última página
                next: "Siguiente", // Personaliza el control para ir a la siguiente página
                previous: "Anterior" // Personaliza el control para ir a la página anterior
            },
            zeroRecords: "No hay paquetes no retirados"
        }
    }).on('draw.dt', function() { feather.replace(); });
}

function verPaquete(paqueteid, identificador){
    idPaqueteViendo = paqueteid
    elementoID('abrirModal').click(); idPaqueteARecibir = paqueteid
    elementoID('identificadorDePaquete').innerText = identificador
    fetch(`Controladores/paquete.php?accion=infoPaquete&personalizado=0&idPaquete=${paqueteid}`)
    .then(res => res.json())
    .then(informacionCompleta => {
        elementoID('infoPaqueteCompleta').innerHTML = informacionCompleta.detalles
    })
}

function reprogramar(){
    elementoID('btnDevolver').style.display = 'none'; elementoID('btnReprogramar').style.display = 'none'
    elementoID('btnCancelarReprogramacion').style.display = 'block'; elementoID('btnGuardarReprogramacion').style.display = 'block'
    elementoID('infoPaqueteCompleta').insertAdjacentHTML('beforeend', `
        <form class="card mt-3 p-3" id="formReprogramacion">
            <label class="col-form-label" for="costo_envio">Costo de envío (*):</label>
            <input type="number" step="0.01" class="form-control" id="costo_envio" name="costo_envio" required>
            <label class="col-form-label" for="fecha">Seleccionar nuevo destino:</label>
            <button type="button" class="btn btn-primary" onclick="abrirModalDestinos()">Seleccionar</button>
            <p class="mt-3">Destino seleccionado: <span id="destinoSeleccionado"></span></p>
        </form>
    `)
}

function cancelarReprogramacion(){
    elementoID('btnDevolver').style.display = 'block'; elementoID('btnReprogramar').style.display = 'block'
    elementoID('btnCancelarReprogramacion').style.display = 'none'; elementoID('btnGuardarReprogramacion').style.display = 'none'
    elementoID('infoPaqueteCompleta').lastElementChild.remove()
}

function abrirModalDestinos(){
    elementoID('cmodalRutas').classList.add('verModalNivel1'); elementoID('modalRutas').classList.add('entrarModalNivel1');
    fetch('Controladores/ruta.php?accion=listarRutas').then(respuesta => respuesta.text()).then(rutas => {
        elementoID('envioNormal').innerHTML = rutas;
        ocultarID('envioNormal'); animarEntradaID('envioNormal');
        //escuchamos cual selecciona y mostramos los destinos de la seleccionada
        document.querySelectorAll('.rutas').forEach((selec) => {
            selec.addEventListener('click', () => {
                document.querySelectorAll('.rutas').forEach((desac) => { desac.classList.remove('active'); });
                selec.classList.add('active');
                //guardamos la ruta que se ha seleccionado
                if(selec.classList.contains('active')){ rutaDestino.ruta = selec.getAttribute('rutaid'); rutaDestino.fecha = selec.innerText.split('(')[1].split(')')[0]; }
                fetch('Controladores/ruta.php?accion=listarDestinos&ruta=' + selec.getAttribute('rutaid')).then(respuesta => respuesta.text()).then(destinos => {
                    elementoID('destinosDeRuta').innerHTML = destinos;
                    //escuchamos que destino selecciona y lo colocamos como selección
                    document.querySelectorAll('.destinos').forEach((desti) => {
                        desti.addEventListener('click', () => {
                            document.querySelectorAll('.destinos').forEach((des) => { des.classList.remove('active'); });
                            desti.classList.add('active');
                            //guardamos el destino que se ha seleccionado
                            if(desti.classList.contains('active')){ rutaDestino.destino = desti.getAttribute('destinoid'); }
                            fetch(`Controladores/ruta.php?accion=infoDestino&ruta=${rutaDestino.ruta}&destino=${rutaDestino.destino}`).then(respuesta => respuesta.text())
                            .then(infoDestino => {
                                elementoID('cmodalRutas').classList.remove('verModalNivel1'); elementoID('modalRutas').classList.remove('entrarModalNivel1');
                                elementoID('formReprogramacion').lastElementChild.remove()
                                elementoID('formReprogramacion').insertAdjacentHTML('beforeend', infoDestino)
                            })
                        });
                    });
                });
            });
        });
    });
}

function devolverPaquete(){
    swal({
        title: '¿Devolver el paquete a su vendedor?',
        text: 'Si el paquete desea ser enviado nuevamente deberá de volver a registrarlo',
        icon: 'warning',
        buttons: ['Cancelar', 'Devolver'],
        dangerMode: true
    }).then(devolver => {
        if(devolver){
            fetch(`Controladores/paquete.php?accion=devolver&idPaquete=${idPaqueteViendo}`).then(res => res.json())
            .then(respuesta => {
                if(respuesta.estado){
                    swal('¡Éxito!', respuesta.mensaje, 'success')
                    listarNoRetirados(); elementoID('btnCerrarModalPaq').click()
                }
            })
        }
    })
}

function guardarReprogramacion(){
    const constoEnvio = elementoID('costo_envio').value
    if(rutaDestino.ruta == undefined || rutaDestino.destino == undefined){
        swal('¡Atención!', 'Debe de seleccionar una ruta y un destino', 'warning'); return
    }
    if(constoEnvio == ''){
        swal('¡Atención!', 'Debe de ingresar el costo de envío', 'warning'); return
    }
    fetch(`Controladores/paquete.php?accion=reprogramar`, {
        method: 'POST',
        body: JSON.stringify({ idPaquete: idPaqueteViendo, ruta: rutaDestino.ruta, destino: rutaDestino.destino, costoEnvio: constoEnvio, fecha: rutaDestino.fecha })
    }).then(res => res.json()).then(respuesta => {
        if(respuesta.estado){
            swal('¡Éxito!', respuesta.mensaje, 'success')
            listarNoRetirados(); elementoID('btnCerrarModalPaq').click(); rutaDestino = {}; idPaqueteViendo = 0
        }
    })
}