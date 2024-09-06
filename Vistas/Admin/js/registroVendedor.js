const urlPagina = window.location.href.split('/');
if(urlPagina[urlPagina.length - 1] === 'registroVendedor'){
insertarFormularioRegistro()
}
function insertarFormularioRegistro(){
    elementoID('insertarRegistroAqui').innerHTML = formularioRegistroVendedor(false);
}
// ------------- parte 1 del registro de información personal del vendedor -------------
// alertas: [0] seleccione departamento y municipio, [1] acepte términos y condiciones
// [2] número de teléfono no válido, [3] número de documento no válido, [4] error al registrar vendedor
// ------------- parte 2 del registro de información del negocio del vendedor -------------
// alertas: [5] seleccione departamento y municipio, [6] ingrese número de teléfono válido
// [7] ingrese número de documento válido, [8] ha ocurrido un error al registrar el negocio
// [9] sleccione un archivo tipo imagen
// ------------- parte 3 del registro de información de la cuenta del vendedor -------------
// [10] error al registrar , [11] éxito al registrar, [12] usuario no disponible
// [13] contraseñas no coinciden, [14] usuario muy corto
const alertas = document.querySelectorAll('.alert')
const btnCerrarAlertas = document.querySelectorAll('.btn-close')
const seccionPaso1 = document.querySelector('.paso1'), seccionPaso2 = document.querySelector('.paso2'), seccionPaso3 = document.querySelector('.paso3')
const indicarPaso1 = document.querySelector('.indicarPaso1'), indicarPaso2 = document.querySelector('.indicarPaso2'), indicarPaso3 = document.querySelector('.indicarPaso3')
seccionPaso2.style.display = 'none'; seccionPaso3.style.display = 'none'
let pasoDelRegistro = 1, pasandoDePaso = false, idCliente = 0, idNegocio = 0, nombreVendedor = ''
cerrarAlertas(); listarDepartamentos()
btnCerrarAlertas.forEach(btnCerrarAlerta => {
    btnCerrarAlerta.addEventListener('click', cerrarAlertas)
})

function listarDepartamentos() {
    fetch('Controladores/consultas.php?accion=selectDepartamentos').then(res => res.text())
    .then(data => {
        document.getElementById('departamento').innerHTML = data
        document.getElementById('departamento_negocio').innerHTML = data
    })
}

function listarMunicipios(idDepartamento, inputNegocio = false) {
    fetch(`Controladores/consultas.php?accion=selectMunicipios&departamentoid=${idDepartamento}`).then(res => res.text())
    .then(data => {
        (!inputNegocio)? document.getElementById('municipio').innerHTML = data : document.getElementById('municipio_negocio').innerHTML = data
    })
}

document.getElementById('departamento').addEventListener('change', function() {
    let idDepartamento = document.getElementById('departamento').value
    if(idDepartamento == 0){
        document.getElementById('municipio').innerHTML = '<option value="0">Seleccione un municipio</option>'
        return
    }
    listarMunicipios(idDepartamento)
})

document.getElementById('departamento_negocio').addEventListener('change', function() {
    let idDepartamento = document.getElementById('departamento_negocio').value
    if(idDepartamento == 0){
        document.getElementById('municipio_negocio').innerHTML = '<option value="0">Seleccione un municipio</option>'
        return
    }
    listarMunicipios(idDepartamento, true)
})

document.getElementById('bntContinuar').addEventListener('click', function() {
    // if(pasoDelRegistro == 1) document.getElementById('submitParte1').click()
    // else document.getElementById('submitParte2').click()
    switch (pasoDelRegistro) {
        case 1:
            document.getElementById('submitParte1').click()
            break;
        case 2:
            document.getElementById('submitParte2').click()
            break;
        case 3:
            document.getElementById('submitParte3').click()
            break;        
    }
})

document.getElementById('btnCancelar').addEventListener('click', () => retrocederCancelar(false))

async function retrocederCancelar(seSeleccionoVendedor = false) {
    if(!seSeleccionoVendedor){  
        if(idNegocio != 0){ 
            await fetch(`Controladores/negocio.php?accion=eliminarNegocio&idNegocio=${idNegocio}`); 
            idNegocio = 0
        }
        if(pasoDelRegistro === 2){ 
            if(idCliente != 0){fetch(`Controladores/cliente.php?accion=eliminarCliente&idCliente=${idCliente}`); 
            idCliente = 0
        }}
    }
    switch (pasoDelRegistro) {
        case 1:
            if(urlPagina[urlPagina.length - 1] === 'agregarPaquete') cambiarABuscarVendedor()
            else{
                if(urlPagina[urlPagina.length - 1] === 'registrarVendedor') elementoID('cerrarModalRegistroVen').click()
                else window.history.back()
            }
            break;
        case 2:
            cambiarAPaso1()
            break;
        case 3:
            cambiarAPaso2()
            break;        
    }
}
//-------------------------------------------------------------------------------
/////// PARA PRIMERA PARTE DEL REGISTRO (INFORMACIÓN DEL VENDEDOR) ///////
//-------------------------------------------------------------------------------
document.getElementById('informacionVendedor').addEventListener('submit', (event) => submitFormularioInfo(event))

function submitFormularioInfo(e){
    e.preventDefault()
    const datosFormulario = Object.fromEntries(new FormData(e.target))
    // Validamos que en telefono solo se ingresen numeros
    if(isNaN(datosFormulario.telefono)){
        alertas[2].classList.remove('d-none')
        setTimeout(() => { alertas[2].classList.add('d-none') }, 4000); return
    }
    // Validamos que en documento solo se ingresen numeros
    if(isNaN(datosFormulario.num_documento)){
        alertas[3].classList.remove('d-none')
        setTimeout(() => { alertas[3].classList.add('d-none') }, 4000); return
    }
    if(datosFormulario.departamento === '0' || datosFormulario.municipio === '0'){
        alertas[0].classList.remove('d-none')
        setTimeout(() => { alertas[0].classList.add('d-none') }, 4000); return
    }
    fetch('Controladores/cliente.php?accion=registrarVendedor', {
        method: 'POST',
        body: JSON.stringify(datosFormulario)
    }).then(res => res.json()).then(data => {
        if(data.estado === undefined){
            alertas[4].classList.remove('d-none')
            return
        }
        if(data.estado === true){
            idCliente = data.vendedorID; nombreVendedor = datosFormulario.nombre
            cambiarAPaso2()
        }else{
            alertas[4].classList.remove('d-none') 
            return
        }
    })
}

//-------------------------------------------------------------------------------
//////// PARA SEGUNDA PARTE DEL REGISTRO (INFORMACIÓN DEL NEGOCIO DEL VENDEDOR) ///////
//-------------------------------------------------------------------------------
document.getElementById('informacionNegocio').addEventListener('submit', (event) => submitFormularioNegocio(event))
document.getElementById('logo_negocio').addEventListener('change', (event) => {
    const imagen = event.target.files[0]
    if(imagen === undefined) return
    if(imagen.type !== 'image/jpeg' && imagen.type !== 'image/png' && imagen.type !== 'image/jpg'){
        event.target.value = ''
        alertas[9].classList.remove('d-none')
        setTimeout(() => { alertas[9].classList.add('d-none') }, 4000); return
    }
    document.getElementById('logo').src = URL.createObjectURL(imagen)
})

function eliminarLogoNeg(){ document.getElementById('logo_negocio').value = ''; document.getElementById('logo').src = 'Imagenes/negocioDefecto.png' }

function submitFormularioNegocio(e){
    e.preventDefault()
    const datosFormulario = new FormData(e.target)
    // validamos que en telefono solo se ingresen numeros
    if(isNaN(datosFormulario.get('telefono_negocio'))){
        alertas[6].classList.remove('d-none')
        setTimeout(() => { alertas[6].classList.add('d-none') }, 4000); return
    }
    // validamos que en documento solo se ingresen numeros
    if(isNaN(datosFormulario.get('num_documento_negocio'))){
        alertas[7].classList.remove('d-none')
        setTimeout(() => { alertas[7].classList.add('d-none') }, 4000); return
    }
    if(datosFormulario.get('departamento_negocio') === '0' || datosFormulario.get('municipio_negocio') === '0'){
        alertas[5].classList.remove('d-none')
        setTimeout(() => { alertas[5].classList.add('d-none') }, 4000); return
    }
    if(document.getElementById('logo_negocio').files.length === 0){
        datosFormulario.append('logo_negocio', 'negocioDefecto.png')
    }else{
        datosFormulario.append('logo_negocio', 'logo_negocio_cliente_' + idCliente + '.' + datosFormulario.get('logo_negocio').name.split('.')[1])
        datosFormulario.append('logo_imagen', document.getElementById('logo_negocio').files[0])
    }
    datosFormulario.append('idCliente', idCliente)
    fetch('Controladores/negocio.php?accion=registrar', {
        method: 'POST',
        body: datosFormulario
    }).then(res => res.json()).then(data => {
        if(data.estado === undefined){
            alertas[8].classList.remove('d-none')
            return
        }
        if(data.estado === true){
            idNegocio = data.negocioID
            cambiarAPaso3()
        }else{
            alertas[8].classList.remove('d-none') 
            return
        }
    })
}

//-------------------------------------------------------------------------------
//////// PARA TERCERA PARTE DEL REGISTRO (INFORMACIÓN DE LA CUENTA) ///////
//-------------------------------------------------------------------------------
document.getElementById('infoUsuario').addEventListener('submit', (event) => submitFormularioUsuario(event))

function submitFormularioUsuario(e){
    e.preventDefault()
    const datosFormulario = Object.fromEntries(new FormData(e.target))
    if(datosFormulario.user.length <= 5){
        alertas[14].classList.remove('d-none')
        setTimeout(() => { alertas[14].classList.add('d-none') }, 4000); return
    }
    if(datosFormulario.pass !== datosFormulario.pass2){
        alertas[13].classList.remove('d-none')
        setTimeout(() => { alertas[13].classList.add('d-none') }, 4000); return
    }
    datosFormulario.idCliente = idCliente
    datosFormulario.esVendedor = true
    fetch('Controladores/cliente.php?accion=registrarSuUsuario', {
        method: 'POST',
        body: JSON.stringify(datosFormulario)
    }).then(res => res.json()).then(data => {
        if(data.estado === undefined){
            alertas[10].classList.remove('d-none')
            return
        }
        if(data.estado === true){
            if(data.usuarioDisponible === false){
                alertas[12].classList.remove('d-none')
                setTimeout(() => { alertas[12].classList.add('d-none') }, 4000); return
            }
            alertas[11].classList.remove('d-none')
            fetch(`Controladores/cliente.php?accion=insertarUsuarioAVendedor&idCliente=${idCliente}&idUsuario=${data.usuarioID}`);
            e.target.reset()
            if(urlPagina[urlPagina.length - 1] === 'agregarPaquete'){
                seleccionarVendedor(idCliente, nombreVendedor, false)
            }
            else{
                if(urlPagina[urlPagina.length - 1] === 'registrarVendedor') registroCompletoRecepcion()
                else {setTimeout(() => { window.location.href = 'gestinarUsuarios' }, 2500); return}
            }
        }else{
            alertas[10].classList.remove('d-none')
            return
        }
    })
}

function cambiarABuscarVendedor(seSeleccionoVendedor = false, directo = true){
    animarSalidaID('seccionRegistrarVendedor'); animarEntradaID('seccionBuscarVendedor');
    elementoID('informacionVendedor').reset(); elementoID('informacionNegocio').reset(); elementoID('infoUsuario').reset();
    if(seSeleccionoVendedor){ idCliente = 0; idNegocio = 0; nombreVendedor = '' }
    if(!directo){
        if(pasoDelRegistro === 3) retrocederCancelar(seSeleccionoVendedor)
        retrocederCancelar(seSeleccionoVendedor)
    }
}

// en la vista registrarVendedor.php de recepcion
if(urlPagina[urlPagina.length - 1] === 'registrarVendedor'){
    elementoID('cerrarModalRegistroVen').addEventListener('click', () => cerrarModalRegistroVendedor())
}
async function cerrarModalRegistroVendedor(registroCompleto = false){
    if(!registroCompleto){
        if(idNegocio != 0){ 
            await fetch(`Controladores/negocio.php?accion=eliminarNegocio&idNegocio=${idNegocio}`); 
            idNegocio = 0
        }
        if(idCliente != 0){
            fetch(`Controladores/cliente.php?accion=eliminarCliente&idCliente=${idCliente}`); 
            idCliente = 0
        }
    }
    elementoID('informacionVendedor').reset(); elementoID('informacionNegocio').reset(); elementoID('infoUsuario').reset();
    if(pasoDelRegistro === 3) { cambiarAPaso2(true); pasoDelRegistro = 1; }
    else{ if(pasoDelRegistro === 2){ cambiarAPaso1(); pasoDelRegistro = 1;  }}
}
function registroCompletoRecepcion(){
    swal({
        title: 'Vendedor registrado',
        icon: 'success',
        button: 'Aceptar'
    });
    idCliente = 0; idNegocio = 0; cerrarModalRegistroVendedor(true); listarVendedores()
}

////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////

function cerrarAlertas() {
    alertas.forEach(alerta => {
        alerta.classList.add('d-none')
    })
}

function cambiarAPaso1(){
    if(pasandoDePaso) return
    pasandoDePaso = true
    seccionPaso1.removeEventListener('animationend', terminarOcultarPaso1)
    seccionPaso2.style.position = 'absolute'
    seccionPaso2.classList.add('slideOutRight')
    seccionPaso2.addEventListener('animationend', terminarOcultarPaso2)
    seccionPaso1.style.display = 'block'
    seccionPaso1.classList.add('animate__slideInLeft')
    seccionPaso1.addEventListener('animationend', () => {
        seccionPaso1.classList.remove('animate__slideInLeft')
    }, {once: true})
    indicarPaso2.classList.remove('activo')
    indicarPaso1.classList.add('activo')
    document.getElementById('pasoActual').innerHTML = 'Paso 1 de 3'
    document.getElementById('btnCancelar').innerHTML = `<i data-feather="x" class="me-1 mb-1"></i>Cancelar`
    document.getElementById('bntContinuar').innerHTML = `Siguiente<i data-feather="arrow-right" class="ms-1 mb-1"></i>`
    pasoDelRegistro = 1; feather.replace(); 
    // idCliente = 0; idNegocio = 0; nombreVendedor = ''
}

function cambiarAPaso2(cambiar1 = false){
    if(pasandoDePaso) return
    pasandoDePaso = true
    seccionPaso2.removeEventListener('animationend', terminarOcultarPaso2)
    if(pasoDelRegistro === 1){
        seccionPaso1.style.position = 'absolute'
        seccionPaso1.classList.add('animate__slideOutLeft')
        seccionPaso1.addEventListener('animationend', terminarOcultarPaso1)
    }else{
        seccionPaso3.style.position = 'absolute'
        seccionPaso3.classList.add('slideOutRight')
        seccionPaso3.addEventListener('animationend', terminarOcultarPaso3)
    }
    seccionPaso2.style.display = 'block'
    seccionPaso2.classList.add((pasoDelRegistro === 1)? 'animate__slideInRight' : 'animate__slideInLeft')
    seccionPaso2.addEventListener('animationend', () => {
        seccionPaso2.classList.remove('animate__slideInRight'); seccionPaso2.classList.remove('animate__slideInLeft')
        if(cambiar1) cambiarAPaso1()
    }, {once: true})
    indicarPaso1.classList.remove('activo'); indicarPaso3.classList.remove('activo')
    indicarPaso2.classList.add('activo')
    document.getElementById('pasoActual').innerHTML = 'Paso 2 de 3'
    document.getElementById('btnCancelar').innerHTML = `<i data-feather="arrow-left" class="me-1 mb-1"></i>Regresar`
    document.getElementById('bntContinuar').innerHTML = `Siguiente<i data-feather="arrow-right" class="ms-1 mb-1"></i>`
    pasoDelRegistro = 2; feather.replace()
}

function cambiarAPaso3(){
    if(pasandoDePaso) return
    pasandoDePaso = true
    seccionPaso3.removeEventListener('animationend', terminarOcultarPaso3)
    seccionPaso2.style.position = 'absolute'
    seccionPaso2.classList.add('animate__slideOutLeft')
    seccionPaso2.addEventListener('animationend', terminarOcultarPaso2)
    seccionPaso3.style.display = 'block'
    seccionPaso3.classList.add('animate__slideInRight')
    seccionPaso3.addEventListener('animationend', () => {
        seccionPaso3.classList.remove('animate__slideInRight')
    }, {once: true})
    indicarPaso2.classList.remove('activo')
    indicarPaso3.classList.add('activo')
    document.getElementById('pasoActual').innerHTML = 'Paso 3 de 3'
    document.getElementById('bntContinuar').innerHTML = `Registrarse<i data-feather="save" class="ms-1 mb-1"></i>`
    pasoDelRegistro = 3; feather.replace()
}

function terminarOcultarPaso1(){
    seccionPaso1.style.position = ''; seccionPaso1.style.display = 'none'; seccionPaso1.classList.remove('animate__slideOutLeft')
    pasandoDePaso = false
}

function terminarOcultarPaso2(){
    seccionPaso2.style.position = ''; seccionPaso2.style.display = 'none'; seccionPaso2.classList.remove('slideOutRight'); seccionPaso2.classList.remove('animate__slideOutLeft')
    pasandoDePaso = false
}

function terminarOcultarPaso3(){
    seccionPaso3.style.position = ''; seccionPaso3.style.display = 'none'; seccionPaso3.classList.remove('slideOutRight')
    pasandoDePaso = false
}