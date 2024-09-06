listarRutas();
let rutaCompleta = {};
function listarRutas(){
    fetch('Controladores/ruta.php?accion=listarRutas&paraRepartidor=true').then(respuesta => respuesta.text()).then(rutas => {
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
    fetch(`Controladores/ruta.php?accion=listarDestinos&ruta=${ruta}&paraRepartidor=true&fecha=${rutaCompleta.fecha}`)
    .then(respuesta => respuesta.text())
    .then(destinos => {
        elementoID('destinosDeRuta').innerHTML = destinos;
        document.querySelectorAll('.destinos').forEach((destino, i, destinos) => {
            destino.addEventListener('click', () => { irAdestino(destinos, i) })
        })
    })
}

function irAdestino(destinos, i){
    rutaCompleta.destino = destinos[i].getAttribute('destinoid');
    localStorage.setItem('rutaCompleta', JSON.stringify(rutaCompleta)); window.location.href = 'destino';
}