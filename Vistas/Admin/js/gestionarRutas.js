/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////// GESTIONAR RUTAS //////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
let yaSeSeleccionoRuta = false, rutaSeleccionada = 0, indiceDiaSeleccionado = 100, editandoRuta = false;
const tituloModalEditarRuta = elementoID('tituloModalEditarRuta'), mensajeModalEditarRuta = elementoID('mensajeModalEditarRuta');
const diasSemana = document.querySelectorAll('.semana');
listarRutas();
function listarRutas(){
    fetch('Controladores/ruta.php?accion=listarRutasAdmin').then(resp => resp.text()).then(rutas => {
        document.querySelector('.listaRutas').innerHTML = rutas; feather.replace();
    })
}

function abrirModalAgregarRuta(){
    editandoRuta = false;
    tituloModalEditarRuta.textContent = 'Agregar ruta'; mensajeModalEditarRuta.textContent = 'Seleccione el día de la semana para la nueva ruta';
    fetch('Controladores/ruta.php?accion=diasOcupados').then(resp => resp.json()).then(dias => {
        if(dias.estado){
            (dias.diasOcupados).forEach(dia => diasSemana[indiceDia(dia)].classList.add('noDisponible'));
            elementoID('modalEditarRuta').classList.add('activo');
        }
    })
}
function verRuta(rutaid){
    if(!yaSeSeleccionoRuta){
        elementoID('cuerpoDestinos').innerHTML = `
            <button class="btn btn-primary" id="btnAgregarDestino" onclick="abrirModalAgregarDestino()">
                <i data-feather="plus"></i> Agregar destino
            </button>
            <main class="listaDestinos"></main>
        `;
        yaSeSeleccionoRuta = true;
    }
    fetch(`Controladores/ruta.php?accion=verDestinosRuta&rutaid=${rutaid}`).then(resp => resp.text()).then(destinos => {
        document.querySelector('.listaDestinos').innerHTML = destinos; feather.replace();
        rutaSeleccionada = rutaid;
    })
}
function editarRuta(rutaid){
    editandoRuta = true;
    tituloModalEditarRuta.textContent = 'Editar ruta'; mensajeModalEditarRuta.textContent = 'Seleccione el nuevo día de la semana para la ruta';
    rutaSeleccionada = rutaid;
    fetch(`Controladores/ruta.php?accion=infoDeRuta&rutaid=${rutaid}`).then(resp => resp.json()).then(ruta => {
        if(ruta.estado){
            (ruta.diasOcupados).forEach(dia => diasSemana[indiceDia(dia)].classList.add('noDisponible'));
            diasSemana[indiceDia(ruta.dia)].classList.remove('noDisponible');
            diasSemana[indiceDia(ruta.dia)].classList.add('activo');
            elementoID('modalEditarRuta').classList.add('activo');
        }
    })
}
function eliminarRuta(rutaid){
    swal({
        title: '¿Está seguro de desactivar esta ruta?',
        text: 'La ruta pasará a estar inactiva junto con todos sus destinos. Puedes volver a activarla en cualquier momento',
        icon: 'warning',
        buttons: ['Cancelar', 'Aceptar'],
    }).then(resp => {
        if(resp){
            fetch(`Controladores/ruta.php?accion=eliminarRuta&rutaid=${rutaid}`).then(resp => resp.json()).then(resp => {
                if(resp.estado){
                    swal({
                        title: 'Ruta eliminada correctamente',
                        icon: 'success',
                        button: 'Aceptar'
                    });
                    listarRutas();
                }else{
                    swal({
                        title: 'Error al eliminar ruta',
                        text: 'No se pudo eliminar la ruta, intente nuevamente',
                        icon: 'error',
                        button: 'Aceptar'
                    });
                }
            });
        }
    });
}
function guardarNuevoDiaRuta(){
    if(editandoRuta){
        if(indiceDiaSeleccionado == 100){
            cerrarModalEditarRuta();
            return swal({ title: 'Ruta actualizada correctamente', icon: 'success', button: 'Aceptar' });   
        }
        fetch(`Controladores/ruta.php?accion=guardarNuevoDiaRuta&rutaid=${rutaSeleccionada}&dia=${diasSemana[indiceDiaSeleccionado].textContent}`)
        .then(resp => resp.json()).then(resp => {
            if(resp.estado){
                swal({
                    title: 'Ruta editada correctamente',
                    icon: 'success',
                    button: 'Aceptar'
                });
                cerrarModalEditarRuta(); listarRutas();
            }else{
                swal({
                    title: 'Error al editar ruta',
                    text: 'No se pudo editar la ruta, intente nuevamente',
                    icon: 'error',
                    button: 'Aceptar'
                });
            }
        })
    }else{
        if(indiceDiaSeleccionado == 100) return swal({ title: 'Seleccione un día', icon: 'warning', button: 'Aceptar' });
        fetch(`Controladores/ruta.php?accion=guardarNuevaRuta&dia=${diasSemana[indiceDiaSeleccionado].textContent}`)
        .then(resp => resp.json()).then(resp => {
            if(resp.estado){
                swal({
                    title: 'Ruta agregada correctamente',
                    icon: 'success',
                    button: 'Aceptar'
                });
                cerrarModalEditarRuta(); listarRutas();
            }else{
                swal({
                    title: 'Error al agregar ruta',
                    text: 'No se pudo agregar la ruta, intente nuevamente',
                    icon: 'error',
                    button: 'Aceptar'
                });
            }
        })
    }
    editandoRuta = false; rutaSeleccionada = 0; indiceDiaSeleccionado = 100;
}
function cerrarModalEditarRuta(){
    elementoID('modalEditarRuta').classList.remove('activo');
    diasSemana.forEach(dia => dia.classList.remove('activo'));
    diasSemana.forEach(dia => dia.classList.remove('noDisponible'));
}

diasSemana.forEach((dia, i, dias) => {
    dia.addEventListener('click', () => { clickDia(dia, i, dias) })
})

function clickDia(dia, i, dias){
    if(dia.classList.contains('noDisponible')) return;
    dias.forEach(d => d.classList.remove('activo'));
    indiceDiaSeleccionado = i;
    dia.classList.add('activo');
}

function indiceDia(dia){
    switch(dia){
        case 'Lunes': return 0;
        case 'Martes': return 1;
        case 'Miércoles': return 2;
        case 'Jueves': return 3;
        case 'Viernes': return 4;
        case 'Sábado': return 5;
        case 'Domingo': return 6;
        default:
            if(dia == 'Miercoles') return 2;
            if(dia == 'Sabado') return 5;
    }
}

/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////// GESTIONAR DESTINOS ///////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
let editandoDestino = false, destinoSeleccionado = 0;
listarDepartamentos();
function listarDepartamentos() {
    fetch('Controladores/consultas.php?accion=selectDepartamentos').then(res => res.text())
    .then(data => {
        document.getElementById('departamento').innerHTML = data
    })
}
elementoID('departamento').addEventListener('change', (e) => { listarMunicipios(e.target.value) })
function listarMunicipios(idDepartamento, idMunicipio = 0) {
    fetch(`Controladores/consultas.php?accion=selectMunicipios&departamentoid=${idDepartamento}`).then(res => res.text())
    .then(data => {
        document.getElementById('municipio').innerHTML = data
        if(idMunicipio != 0) document.querySelector(`#municipio option[value="${idMunicipio}"]`).selected = true;
    })
}

function abrirModalAgregarDestino(){
    editandoDestino = false;
    elementoID('tituloModalEditarDestino').textContent = 'Agregar destino'; elementoID('mensajeModalEditarDestino').textContent = 'Ingrese la información del nuevo destino';
    elementoID('modalEditarDestino').classList.add('activo');
}
function editarDestino(destinoid){
    editandoDestino = true;
    elementoID('tituloModalEditarDestino').textContent = 'Editar destino'; elementoID('mensajeModalEditarDestino').textContent = 'Ingrese la nueva información del destino';
    destinoSeleccionado = destinoid;
    fetch(`Controladores/ruta.php?accion=infoDestino&ruta=${rutaSeleccionada}&destino=${destinoid}&admin=true`).then(resp => resp.json()).then(destino => {
        if(destino.estado){
            elementoID('lugar_destino').value = destino.lugar_destino;
            elementoID('descripcion_destino').value = destino.descripcion_destino;
            document.querySelector(`#departamento option[value="${destino.departamentoID}"]`).selected = true;
            listarMunicipios(destino.departamentoID, destino.municipioID);
            elementoID('hora_inicio').value = destino.hora_desde;
            elementoID('hora_fin').value = destino.hora_hasta;
            elementoID('modalEditarDestino').classList.add('activo');
        }
    })
}
function eliminarDestino(destinoid){
    swal({
        title: '¿Está seguro de desactivar este destino?',
        text: 'El destino pasará a estar inactivo. Puedes volver a activarlo en cualquier momento',
        icon: 'warning',
        buttons: ['Cancelar', 'Aceptar'],
    }).then(resp => {
        if(resp){
            fetch(`Controladores/ruta.php?accion=eliminarDestino&destinoid=${destinoid}`).then(resp => resp.json()).then(resp => {
                if(resp.estado){
                    swal({
                        title: 'Destino eliminado correctamente',
                        icon: 'success',
                        button: 'Aceptar'
                    });
                    verRuta(rutaSeleccionada);
                }else{
                    swal({
                        title: 'Error al eliminar destino',
                        text: 'No se pudo eliminar el destino, intente nuevamente',
                        icon: 'error',
                        button: 'Aceptar'
                    });
                }
            });
        }
    })
}
function guardarNuevoDestino(){
    const datos = Object.fromEntries(new FormData(elementoID('formInfoDestino')));
    if(datos.lugar_destino.trim() == '' || datos.departamento == '0' || datos.municipio == '0' || datos.hora_inicio.trim() == '' || datos.hora_fin.trim() == ''){
        return swal({ title: 'Complete todos los campos obligatorios', icon: 'warning', button: 'Aceptar' });
    }
    if(editandoDestino){
        datos.destinoid = destinoSeleccionado;
        fetch('Controladores/ruta.php?accion=guardarEditarDestino', { 
            method: 'POST', ContentType: 'application/json',
            body: JSON.stringify(datos) })
            .then(resp => resp.json())
        .then(resp => {
            if(resp.estado){
                swal({
                    title: 'Destino editado correctamente',
                    icon: 'success',
                    button: 'Aceptar'
                });
                cerrarModalEditarDestino(); verRuta(rutaSeleccionada);
            }else{
                swal({
                    title: 'Error al editar destino',
                    text: 'No se pudo editar el destino, intente nuevamente',
                    icon: 'error',
                    button: 'Aceptar'
                });
            }
        })
    }else{
        datos.rutaid = rutaSeleccionada;
        fetch('Controladores/ruta.php?accion=guardarNuevoDestino', { 
            method: 'POST', ContentType: 'application/json',
            body: JSON.stringify(datos) }).then(resp => resp.json())
        .then(resp => {
            if(resp.estado){
                swal({
                    title: 'Destino agregado correctamente',
                    icon: 'success',
                    button: 'Aceptar'
                });
                cerrarModalEditarDestino(); verRuta(rutaSeleccionada);
            }else{
                swal({
                    title: 'Error al agregar destino',
                    text: 'No se pudo agregar el destino, intente nuevamente',
                    icon: 'error',
                    button: 'Aceptar'
                });
            }
        })
    }
    editandoDestino = false; destinoSeleccionado = 0;
}
function cerrarModalEditarDestino(){
    elementoID('modalEditarDestino').classList.remove('activo');
    elementoID('lugar_destino').value = '';
    elementoID('descripcion_destino').value = '';
    listarDepartamentos();
    elementoID('municipio').innerHTML = '<option value="0" selected disabled>Seleccione un municipio</option>';
    elementoID('hora_inicio').value = '';
    elementoID('hora_fin').value = '';
}