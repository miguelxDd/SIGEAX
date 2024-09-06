//obtenemos el id del paquete que será visto su detalle
let idPaquete = localStorage.getItem('idPaquete');
let esPersonalizado = localStorage.getItem('personalizado');
let paraHoy = localStorage.getItem('hoy');
iniciar();
// Obtener la barra de progreso y los puntos
const barraDeEstados = document.querySelector('.progress-bar');
const barraAvanzado = document.querySelector('.barraLLenado');
const btnEnCamino = elementoID('btnEnCamino'), btnListoEntregar = elementoID('btnListoEntregar'), paraFinalizar = elementoID('paraFinalizar');
btnEnCamino.style.display = 'none'; btnListoEntregar.style.display = 'none'; paraFinalizar.style.display = 'none';
//obtenemos los elementos donde se mostrará informacion
const iconoEstado = elementoID('estado');
const tituloEstado = elementoID('titulo');
const mensajeEstado = elementoID('mensaje');
const infoPaqueteVista = elementoID('infoPaquete');
const tablaEstados = elementoID('tablaEstados');
const textoParaEstados = {
    'En bodega': {
        'titulo': 'Recibido en bodega el ',
        'mensaje': 'Cuando empieces el camino a la entrega del paquete presiona el botón "Voy en camino".'
    },
    'En ruta': {
        'titulo': 'Rumbo a su lugar de entrega el ',
        'mensaje': 'Cuando llegues al punto de entrega presiona el botón "Listo para entregar".'
    },
    'Listo para entregar': {
        'titulo': 'Paquete listo para ser retirado desde ',
        'mensaje': 'Cuando entregues el paquete presiona el botón "Entregado".'
    },
    'Entregado': {
        'titulo': 'Paquete entregado el ',
        'mensaje': '¡Excelente trabajo!. Ya has entregado este paquete, puedes ir por otro paquete.'
    },
    'No retirado': {
        'titulo': 'Paquete no retirado el ',
        'mensaje': 'El paquete no ha sido retirado por el cliente. Puedes ir por otro paquete.'
    }
};

function iniciar() {
    fetch("Controladores/paquete.php?accion=infoPaquete&idPaquete=" + idPaquete + '&personalizado=' + esPersonalizado, { method: 'GET' }).then(respuesta => respuesta.json())
        .then(datos => {
            let icono = '', titulo = '', mensaje = '', estado = 0;
            switch (datos.estado) {
                case 'En bodega':
                    icono = 'archive'; titulo = textoParaEstados["En bodega"].titulo + datos.fechaUltimo;
                    mensaje = textoParaEstados["En bodega"].mensaje; estado = 0;
                    break;
                case 'En ruta':
                    icono = 'truck'; titulo = textoParaEstados["En ruta"].titulo + datos.fechaUltimo;
                    mensaje = textoParaEstados["En ruta"].mensaje; estado = 1;
                    break;
                case 'Listo para entregar':
                    icono = 'disc'; titulo = textoParaEstados["Listo para entregar"].titulo + datos.fechaUltimo;
                    mensaje = textoParaEstados["Listo para entregar"].mensaje; estado = 2;
                    break;
                case 'Entregado':
                    icono = 'check-circle'; titulo = textoParaEstados["Entregado"].titulo + datos.fechaUltimo;
                    mensaje = textoParaEstados["Entregado"].mensaje; estado = 3;
                    break;
                case 'No retirado':
                    icono = 'x-circle'; titulo = textoParaEstados["No retirado"].titulo + datos.fechaUltimo;
                    mensaje = textoParaEstados["No retirado"].mensaje; estado = 3;
                    break;
            }
            if (paraHoy == 1) { verificarEstado(datos.estado); mensajeEstado.innerText = mensaje; }
            if(datos.estado == 'No retirado'){
                const puntoFinal = document.querySelectorAll('.puntoProgreso')[3];
                puntoFinal.querySelector('svg').remove();
                puntoFinal.insertAdjacentHTML('afterbegin', '<i data-feather="x-circle" style="transform: translateY(5px);"></i>');
                puntoFinal.querySelector('span').innerText = 'No retirado';
            }
            //para llenar la barra en el punto de estado correspondiente a este paquete
            const anchoBarra = barraDeEstados.offsetWidth / 3; // 3 es el número de puntos de estado en la barra contando el 0, es decir, 4
            const lineAvance = anchoBarra * estado;
            barraAvanzado.style.width = `${lineAvance}px`;
            iconoEstado.innerHTML = `<i data-feather="${icono}" class="mx-2"></i>` + datos.estado; //icono se inserta
            tituloEstado.innerText = titulo;
            infoPaqueteVista.innerHTML = datos.detalles;
            tablaEstados.innerHTML = datos.estados;
            //Para insertar los iconos Father
            feather.replace();
        });
}

function verificarEstado(estado) {
    switch (estado) {
        case 'En bodega':
            btnEnCamino.style.display = 'block'; btnListoEntregar.style.display = 'none'; paraFinalizar.style.display = 'none';
            break;
        case 'En ruta':
            btnEnCamino.style.display = 'none'; btnListoEntregar.style.display = 'block'; paraFinalizar.style.display = 'none';
            break;
        case 'Listo para entregar':
            btnEnCamino.style.display = 'none'; btnListoEntregar.style.display = 'none'; paraFinalizar.style.display = 'block';
            break;
        default:
            btnEnCamino.style.display = 'none'; btnListoEntregar.style.display = 'none'; paraFinalizar.style.display = 'none';
            break;
    }
}

function empezarRuta() {
    swal({
        title: "¿Empezar el camino para entregar el paquete?",
        text: "El estado de todos los paquetes de esta ruta cambiará a 'En ruta'.",
        icon: "warning",
        buttons: ['Cancelar', 'Aceptar'],
    })
        .then((willDelete) => {
            if (willDelete) {
                fetch('Controladores/paquete.php?accion=cambiarEstadoPaq', {
                    method: 'POST',
                    body: JSON.stringify({ paquetes: [idPaquete], estado: 'En ruta' })
                }).then(respuesta => respuesta.json()).then(datos => {
                    if (datos.estado) {
                        swal({
                            title: '¡Listo!',
                            text: 'Vamos en camino a entregar el paquete',
                            icon: 'success',
                            button: 'Aceptar'
                        }).then(() => iniciar() );
                    } else { alertaErrorCambiarEstado(); }
                });
            }
        });
}

function listoEntregar() {
    swal({
        title: "¿Llegó al destino?",
        text: "El estado de todos los paquetes de esta ruta cambiará a 'Listo para entregar'.",
        icon: "warning",
        buttons: ['Cancelar', 'Aceptar'],
    })
        .then((willDelete) => {
            if (willDelete) {
                fetch('Controladores/paquete.php?accion=cambiarEstadoPaq', {
                    method: 'POST',
                    body: JSON.stringify({ paquetes: [idPaquete], estado: 'Listo para entregar' })
                }).then(respuesta => respuesta.json()).then(datos => {
                    if (datos.estado) {
                        swal({
                            title: '¡Listo!',
                            text: 'El paquete está listo para ser entregado',
                            icon: 'success',
                            button: 'Aceptar'
                        }).then(() => iniciar() );
                    } else { alertaErrorCambiarEstado(); }
                });
            }
        });
}

function entregado() {
    swal({
        title: "¿Paquete entregado?",
        text: "El estado de todos los paquetes de esta ruta cambiará a 'Entregado'.",
        icon: "warning",
        buttons: ['Cancelar', 'Aceptar'],
    })
        .then((willDelete) => {
            if (willDelete) {
                fetch('Controladores/paquete.php?accion=cambiarEstadoPaq', {
                    method: 'POST',
                    body: JSON.stringify({ paquetes: [idPaquete], estado: 'Entregado' })
                }).then(respuesta => respuesta.json()).then(datos => {
                    if (datos.estado) {
                        swal({
                            title: '¡Listo!',
                            text: 'El paquete ha sido entregado',
                            icon: 'success',
                            button: 'Aceptar'
                        }).then(() => iniciar() );
                    } else { alertaErrorCambiarEstado(); }
                });
            }
        });
}

function noEntregado(){
    swal({
        title: "¿Paquete no entregado?",
        text: "El estado de todos los paquetes de esta ruta cambiará a 'No retirado'.",
        icon: "warning",
        buttons: ['Cancelar', 'Aceptar'],
    })
        .then((willDelete) => {
            if (willDelete) {
                fetch('Controladores/paquete.php?accion=cambiarEstadoPaq', {
                    method: 'POST',
                    body: JSON.stringify({ paquetes: [idPaquete], estado: 'No retirado' })
                }).then(respuesta => respuesta.json()).then(datos => {
                    if (datos.estado) {
                        swal({
                            title: '¡Listo!',
                            text: 'El paquete no ha sido entregado',
                            icon: 'success',
                            button: 'Aceptar'
                        }).then(() => iniciar() );
                    } else { alertaErrorCambiarEstado(); }
                });
            }
        });
}

function alertaErrorCambiarEstado() {
    swal({
        title: 'Ocurrió un error',
        text: 'No se pudo cambiar el estado de los paquetes. Intente de nuevo o más tarde',
        icon: 'error',
        button: 'Aceptar'
    });
}