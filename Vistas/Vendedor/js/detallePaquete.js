//obtenemos el id del paquete que será visto su detalle
let idPaquete = localStorage.getItem('idPaquete');
let esPersonalizado = localStorage.getItem('personalizado');
// Obtener la barra de progreso y los puntos
const barraDeEstados = document.querySelector('.progress-bar');
const barraAvanzado = document.querySelector('.barraLLenado');
//obtenemos los elementos donde se mostrará informacion
const iconoEstado = elementoID('estado');
const tituloEstado = elementoID('titulo');
// const mensajeEstado = elementoID('mensaje');
const infoPaqueteVista = elementoID('infoPaquete');
const tablaEstados = elementoID('tablaEstados');
const textoParaEstados = {
    'En bodega': {
        'titulo': 'Recibido en bodega el ',
        'mensaje': 'El paquete ha sido recibido por nuestro equipo, pronto será enviado a su destino. ¡Espera solo un poco!.' 
    },
    'En ruta':{
        'titulo': 'Rumbo a su lugar de entrega el ',
        'mensaje': 'El paquete se encuentra rumbo a su destino. Espera un poco y preparate para ir a retirarlo. ¡Ya falta poco!.'
    },
    'Listo para entregar':{
        'titulo': 'Paquete listo para ser retirado desde ',
        'mensaje': 'El paquete se encuentra en el punto de entrega. Acercate a retirarlo ¡Te esperamos!.'
    },
    'Entregado':{
        'titulo': 'Paquete entregado el ',
        'mensaje': 'Se te ha entregado el paquete ¡Gracias por preferirnos!. Esperamos que hayas tenido una experiencia agradable.'
    },
    'No retirado':{
        'titulo': 'Paquete no retirado el ',
        'mensaje': 'El paquete no ha sido retirado por el cliente.'
    }
};

fetch("Controladores/paquete.php?accion=infoPaquete&idPaquete=" + idPaquete + '&personalizado=' + esPersonalizado, {method: 'GET'}).then(respuesta => respuesta.json())
.then(datos => {
    let icono = '', titulo = '', mensaje = '', estado = 0; 
    switch (datos.estado){
        case 'En bodega': 
            icono = 'archive'; titulo = textoParaEstados["En bodega"].titulo + datos.fechaUltimo;
            // mensaje = textoParaEstados["En bodega"].mensaje; 
            estado = 0;
        break;
        case 'En ruta': 
            icono = 'truck'; titulo = textoParaEstados["En ruta"].titulo + datos.fechaUltimo;
            // mensaje = textoParaEstados["En ruta"].mensaje; 
            estado = 1;
        break;
        case 'Listo para entregar': 
            icono = 'disc'; titulo = textoParaEstados["Listo para entregar"].titulo + datos.fechaUltimo; 
            // mensaje = textoParaEstados["Listo para entregar"].mensaje; 
            estado = 2;
        break;
        case 'Entregado': 
            icono = 'check-circle'; titulo = textoParaEstados["Entregado"].titulo + datos.fechaUltimo;
            // mensaje = textoParaEstados["Entregado"].mensaje; 
            estado = 3;
        break;
        case 'No retirado': 
            icono = 'x-circle'; titulo = textoParaEstados["No retirado"].titulo + datos.fechaUltimo;
            // mensaje = textoParaEstados["No retirado"].mensaje; 
            estado = 3;
        break;
    }
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
    // mensajeEstado.innerText = mensaje;
    infoPaqueteVista.innerHTML = datos.detalles;
    tablaEstados.innerHTML = datos.estados;
    //Para insertar los iconos Father
    feather.replace();
});