const destino = JSON.parse(localStorage.getItem('rutaCompleta'));
let paquetesDeRuta = [];
fetch(`Controladores/ruta.php?accion=infoDestino&ruta=${destino.ruta}&destino=${destino.destino}`)
    .then(respuesta => respuesta.text()).then(info => {
        elementoID('parainfodestino').innerHTML = info;
        listarPaquetesDeRuta();
    })

function listarPaquetesDeRuta() {
    $('#paquetesDeRuta').dataTable({
        ajax: {
            url: `Controladores/paquete.php?accion=listarPaquetesRutaRepartidor&ruta=${destino.ruta}&destino=${destino.destino}&fecha=${destino.fecha}`,
            dataSrc: function (json) {
                paquetesDeRuta = json.aaData;
                return json.aaData;
            }
        },
        destroy: true,
        iDisplayLength: 20, //paginacion
        order: [[0, 'desc']], //ordenar (columna, orden)
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
            zeroRecords: "No se agregaron paquetes a esta ruta"
        },
    }).on('draw.dt', function () {
        feather.replace();
        comprobarEstadoDePaquetes();
    });
}

function comprobarEstadoDePaquetes() {
    const btnEmpezarRuta = elementoID('btnEmpezarRuta'), btnEnLugar = elementoID('btnEnLugar'), btnFinDestino = elementoID('btnFinDestino'), alertaDestinoFinalizado = elementoID('alertaDestinoFinalizado');
    if(paquetesDeRuta.length != 0){
        switch (paquetesDeRuta[0][3]) {
            case 'En bodega':
                btnEmpezarRuta.style.display = 'block'; btnEnLugar.style.display = 'none'; btnFinDestino.style.display = 'none'; alertaDestinoFinalizado.style.display = 'none';
                break;
            case 'En ruta':
                btnEmpezarRuta.style.display = 'none'; btnEnLugar.style.display = 'block'; btnFinDestino.style.display = 'none'; alertaDestinoFinalizado.style.display = 'none';
                break;
            case 'Listo para entregar':
                btnEmpezarRuta.style.display = 'none'; btnEnLugar.style.display = 'none'; btnFinDestino.style.display = 'block'; alertaDestinoFinalizado.style.display = 'none';
                break;
            default:
                //primero vemos si en todo los demás paquetes hay otro 'Listo para entregar' porque si hay otro
                //significa que no se ha terminado la ruta así que debemos seguir manteniendo el botón para finalizar el destino
                let hayListoParaEntregar = false;
                paquetesDeRuta.forEach(paquete => { if(paquete[3] == 'Listo para entregar'){ hayListoParaEntregar = true; } })
                if(hayListoParaEntregar){
                    btnEmpezarRuta.style.display = 'none'; btnEnLugar.style.display = 'none'; btnFinDestino.style.display = 'block'; alertaDestinoFinalizado.style.display = 'none';
                }else{
                    //si no es ninguno de los tres estados anteriores, se ha terminado la ruta
                    // y el estado puede ser ya sea 'Entregado' o 'No retirado'
                    btnEmpezarRuta.style.display = 'none'; btnEnLugar.style.display = 'none'; btnFinDestino.style.display = 'none'; alertaDestinoFinalizado.style.display = 'block';
                }
                break;
        }
    }else{
        btnEmpezarRuta.style.display = 'none'; btnEnLugar.style.display = 'none'; btnFinDestino.style.display = 'none';
    }
}

document.querySelectorAll('.btnEstadoRuta').forEach(btn => {
    btn.addEventListener('click', (e) => {
        switch (e.target.id) {
            case 'btnEmpezarRuta': paraEmpezarRuta(); break;
            case 'btnEnLugar': paraEnLugar(); break;
            case 'btnFinDestino': paraFinDestino(); break;
        }
    })
})

function paraEmpezarRuta() {
    swal({
        title: "¿Empezar viaje hacia el destino?",
        text: "El estado de todos los paquetes de esta ruta cambiará a 'En ruta'.",
        icon: "warning",
        buttons: ['Cancelar', 'Aceptar'],
    })
        .then((willDelete) => {
            if (willDelete) {
                let identificadores = document.querySelectorAll('.btnVerPaqueteRepartidor')
                let ids = []
                identificadores.forEach(btn => { ids.push(btn.getAttribute('paqueteid')) })
                fetch('Controladores/paquete.php?accion=cambiarEstadoPaq', {
                    method: 'POST',
                    body: JSON.stringify({ paquetes: ids, estado: 'En ruta' })
                }).then(res => res.json())
                    .then(respuesta => {
                        if (respuesta.estado) {
                            swal({
                                title: respuesta.mensaje,
                                icon: 'success',
                                button: 'Aceptar'
                            });
                            listarPaquetesDeRuta();
                        } else { alertaErrorCambiarEstado() }
                    })
            }
        });
}

function paraEnLugar(){
    swal({
        title: "¿Llegó al destino?",
        text: "El estado de todos los paquetes de esta ruta cambiará a 'Listo para entregar'.",
        icon: "warning",
        buttons: ['Cancelar', 'Aceptar'],
    })
        .then((willDelete) => {
            if (willDelete) {
                let identificadores = document.querySelectorAll('.btnVerPaqueteRepartidor')
                let ids = []
                identificadores.forEach(btn => { ids.push(btn.getAttribute('paqueteid')) })
                fetch('Controladores/paquete.php?accion=cambiarEstadoPaq', {
                    method: 'POST',
                    body: JSON.stringify({ paquetes: ids, estado: 'Listo para entregar' })
                }).then(res => res.json())
                    .then(respuesta => {
                        if (respuesta.estado) {
                            swal({
                                title: respuesta.mensaje,
                                icon: 'success',
                                button: 'Aceptar'
                            });
                            listarPaquetesDeRuta();
                        } else { alertaErrorCambiarEstado() }
                    })
            }
        });
}

function paraFinDestino(){
    swal({
        title: "¿Finalizar viaje?",
        text: "Si hay paquetes que no se haya confirmado su entrega, se cambiará su estado a 'No retirado'.",
        icon: "warning",
        buttons: ['Cancelar', 'Aceptar'],
    })
        .then((willDelete) => {
            if (willDelete) {
                let paquetesNoRetirados = []
                paquetesDeRuta.forEach(paquete => {
                    if(paquete[3] == 'Listo para entregar'){
                        const expresion = /confirmarEntrega\((\d+)\)/;
                        if(expresion.test(paquete[4])){
                            paquetesNoRetirados.push(paquete[4].match(expresion)[1]);
                        }
                    }
                })
                if(paquetesNoRetirados.length > 0){
                    fetch('Controladores/paquete.php?accion=cambiarEstadoPaq', {
                        method: 'POST',
                        body: JSON.stringify({ paquetes: paquetesNoRetirados, estado: 'No retirado' })
                    }).then(res => res.json())
                        .then(respuesta => {
                            if (respuesta.estado) {
                                swal({
                                    title: respuesta.mensaje,
                                    icon: 'success',
                                    button: 'Aceptar'
                                });
                                listarPaquetesDeRuta();
                            } else { alertaErrorCambiarEstado() }
                        })
                }
                fetch(`Controladores/ruta.php?accion=finalizarDestino&ruta=${destino.ruta}&destino=${destino.destino}&fecha=${destino.fecha}`)
                .then(res => res.json()).then(respuesta => {
                    if(respuesta.estado){
                        swal({
                            title: respuesta.mensaje,
                            icon: 'success',
                            button: 'Aceptar'
                        });
                        listarPaquetesDeRuta();
                    }else{
                        swal({
                            title: respuesta.mensaje,
                            icon: 'error',
                            button: 'Aceptar'
                        });
                    }
                })           
            }
        });
}

function alertaErrorCambiarEstado(){
    swal({
        title: 'Ocurrió un error',
        text: 'No se pudo cambiar el estado de los paquetes. Intente de nuevo o más tarde',
        icon: 'error',
        button: 'Aceptar'
    });
}

function confirmarEntrega(paqueteid){
    fetch(`Controladores/paquete.php?accion=confirmarEntrega&idPaquete=${paqueteid}`).then(res => res.json())
    .then(respuesta => {
        if(respuesta.estado){
            swal({
                title: respuesta.mensaje,
                icon: 'success',
                button: 'Aceptar'
            });
            listarPaquetesDeRuta();
        }else{
            swal({
                title: respuesta.mensaje,
                icon: 'error',
                button: 'Aceptar'
            });
        }
    }).catch(error => console.log(error));
}

function verInfoCompleta(paqueteid, identificador, espersonalizado){
    elementoID('abrirModal').click(); idPaqueteARecibir = paqueteid
    elementoID('identificadorDePaquete').innerText = identificador
    fetch(`Controladores/paquete.php?accion=infoPaquete&personalizado=${espersonalizado}&idPaquete=${paqueteid}`)
    .then(res => res.json())
    .then(informacionCompleta => {
        elementoID('infoPaqueteCompleta').innerHTML = informacionCompleta.detalles        
    })
}