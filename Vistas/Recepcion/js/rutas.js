listarRutas(); listarPaquetesPersonalizados();
let rutaCompleta = {};
function listarRutas(){
    fetch('Controladores/ruta.php?accion=listarRutas&recepcion=true').then(respuesta => respuesta.text()).then(rutas => {
        elementoID('rutasDestinos').innerHTML = rutas;
        document.querySelectorAll('.rutas').forEach((ruta, i, rutas) => {
            ruta.addEventListener('click', () => { listarDestinosRuta(i, rutas) })
        })
    })
}

function listarDestinosRuta(i, rutas){
    rutas.forEach(r => r.classList.remove('active'));
    rutas[i].classList.add('active'); const ruta = rutas[i].getAttribute('rutaid');
    rutaCompleta.ruta = ruta; rutaCompleta.fecha = rutas[i].innerText.split('(')[1].split(')')[0];
    fetch('Controladores/ruta.php?accion=listarDestinos&ruta=' + ruta).then(respuesta => respuesta.text())
    .then(destinos => {
        elementoID('destinosDeRuta').innerHTML = destinos;
        document.querySelectorAll('.destinos').forEach((destino, i, destinos) => {
            destino.addEventListener('click', () => { abrirInfoDestino(i, destinos) })
        })
    })
}

function abrirInfoDestino(i, destinos){
    destinos.forEach(d => d.classList.remove('active')); destinos[i].classList.add('active');
    const destino = destinos[i].getAttribute('destinoid'); rutaCompleta.destino = destino;
    fetch(`Controladores/ruta.php?accion=infoDestino&ruta=${rutaCompleta.ruta}&destino=${rutaCompleta.destino}`)
    .then(respuesta => respuesta.text()).then(info => {
        elementoID('parainfodestino').innerHTML = info;
        listarPaquetesDeRuta();
        elementoID('abrirModal').click();
    })
}

function listarPaquetesDeRuta(){
    $('#paquetesDeRuta').dataTable({
        ajax: `Controladores/paquete.php?accion=listarPaquetesRuta&ruta=${rutaCompleta.ruta}&destino=${rutaCompleta.destino}&fecha=${rutaCompleta.fecha}`,
        destroy: true,
        iDisplayLength: 10, //paginacion
        order: [[0, 'desc']], //ordenar (columna, orden)
        lengthChange: false,
        language: {
            // lengthMenu: "Mostrar _MENU_ paquetes por página", // Personaliza el mensaje para seleccionar paginación
            search: "Buscar:",
            info: "Mostrando _START_ a _END_ de _TOTAL_ paquetes", // Personaliza el mensaje de información
            info: "Mostrando _END_ de un total de _TOTAL_ paquetes", // Personaliza el mensaje de información
            paginate: {
                first: "Primero", // Personaliza el control para ir a la primera página
                last: "Último", // Personaliza el control para ir a la última página
                next: "Siguiente", // Personaliza el control para ir a la siguiente página
                previous: "Anterior" // Personaliza el control para ir a la página anterior
            },
            zeroRecords: "Aún no se han agregado paquetes a esta ruta"
        }
    }).on('draw.dt', function(){ feather.replace(); });
}

function listarPaquetesPersonalizados(){
    $('#tablaPaquetesPersonalizados').dataTable({
        ajax: `Controladores/paquete.php?accion=listarPaquetesPersonalizados`,
        destroy: true,
        iDisplayLength: 10, //paginacion
        order: [[0, 'desc']], //ordenar (columna, orden)
        lengthChange: false,
        language: {
            // lengthMenu: "Mostrar _MENU_ paquetes por página", // Personaliza el mensaje para seleccionar paginación
            search: "Buscar:",
            info: "Mostrando _START_ a _END_ de _TOTAL_ paquetes", // Personaliza el mensaje de información
            info: "Mostrando _END_ de un total de _TOTAL_ paquetes", // Personaliza el mensaje de información
            paginate: {
                first: "Primero", // Personaliza el control para ir a la primera página
                last: "Último", // Personaliza el control para ir a la última página
                next: "Siguiente", // Personaliza el control para ir a la siguiente página
                previous: "Anterior" // Personaliza el control para ir a la página anterior
            },
            zeroRecords: "Aún no se han agregado paquetes personalizados"
        }
    }).on('draw.dt', function(){ feather.replace(); });
}

function verInfoCompleta(paqueteid, identificador, espersonalizado){
    elementoID('modalPaqueteInfo').style.display = 'flex'
    elementoID('identificadorDePaquete').innerText = identificador
    fetch(`Controladores/paquete.php?accion=infoPaquete&personalizado=${espersonalizado}&idPaquete=${paqueteid}`)
    .then(res => res.json())
    .then(informacionCompleta => {
        elementoID('infoPaqueteCompleta').innerHTML = informacionCompleta.detalles
    })
}

function cerrarModalPaqInfo(){
    elementoID('modalPaqueteInfo').style.display = 'none'
    elementoID('infoPaqueteCompleta').innerHTML = ''
}

function confirmarSalida(paqueteid){
    fetch(`Controladores/paquete.php?accion=confirmarSalida&idPaquete=${paqueteid}`).then(res => res.json())
    .then(respuesta => confirmacionDeSalida(respuesta))
}

function confirmacionDeSalida(respuesta){
    if(respuesta.estado){
        swal({
            title: respuesta.mensaje,
            icon: 'success',
            button: 'Aceptar'
        });
        listarPaquetesDeRuta(rutaCompleta); listarPaquetesPersonalizados();
    }else{
        swal({
            title: respuesta.mensaje,
            text: 'Hemos tenido un error inisperado, intenta de nuevo o más tarde',
            icon: 'warning',
            button: 'Aceptar'
        });
    }
}