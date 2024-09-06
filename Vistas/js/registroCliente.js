// alertas: [0] seleccione departamento y municipio, [1] acepte términos y condiciones
// [2] número de teléfono no válido, [3] número de documento no válido, [4] error al registrar cliente parte 1
// [5] error al registrar cliente en parte 2, [6] éxito al registrar cliente, [7] usuario no disponible
//  [8] contraseñas no coinciden, [9] usuario muy corto
const alertas = document.querySelectorAll('.alert')
const btnCerrarAlertas = document.querySelectorAll('.btn-close')
const seccionPaso1 = document.querySelector('.paso1'), seccionPaso2 = document.querySelector('.paso2')
const indicarPaso1 = document.querySelector('.indicarPaso1'), indicarPaso2 = document.querySelector('.indicarPaso2')
seccionPaso2.style.display = 'none'
let pasoDelRegistro = 1, pasandoDePaso = false, idCliente = 0
cerrarAlertas(); listarDepartamentos()
btnCerrarAlertas.forEach(btnCerrarAlerta => {
    btnCerrarAlerta.addEventListener('click', cerrarAlertas)
})

function listarDepartamentos() {
    fetch('Controladores/consultas.php?accion=selectDepartamentos').then(res => res.text())
    .then(data => {
        document.getElementById('departamento').innerHTML = data
    })
}

function listarMunicipios(idDepartamento) {
    fetch(`Controladores/consultas.php?accion=selectMunicipios&departamentoid=${idDepartamento}`).then(res => res.text())
    .then(data => {
        document.getElementById('municipio').innerHTML = data
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

document.getElementById('bntContinuar').addEventListener('click', function() {
    if(pasoDelRegistro == 1) document.getElementById('submitParte1').click()
    else document.getElementById('submitParte2').click()
})

document.getElementById('btnCancelar').addEventListener('click', function() {    
    if(idCliente != 0){
        fetch(`Controladores/cliente.php?accion=eliminarCliente&idCliente=${idCliente}`)
        idCliente = 0
    }
    (pasoDelRegistro === 1)? window.history.back() : cambiarAPaso1()
})

//-------------------------------------------------------------------------------
/////// PARA PRIMERA PARTE DEL REGISTRO (INFORMACIÓN DEL CLIENTE) ///////
//-------------------------------------------------------------------------------
document.getElementById('informacionCliente').addEventListener('submit', (event) => submitFormularioInfo(event))

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
    if(datosFormulario.terminosCondiciones === undefined){
        alertas[1].classList.remove('d-none')
        setTimeout(() => { alertas[1].classList.add('d-none') }, 4000); return
    }
    fetch('Controladores/cliente.php?accion=registrarCliente', {
        method: 'POST',
        body: JSON.stringify(datosFormulario)
    }).then(res => res.json()).then(data => {
        if(data.estado === undefined){
            alertas[4].classList.remove('d-none')
            return
        }
        if(data.estado === true){
            idCliente = data.clienteID
            cambiarAPaso2()
        }else{
            alertas[4].classList.remove('d-none') 
            return
        }
    })
}
//-------------------------------------------------------------------------------
//////// PARA SEGUNDA PARTE DEL REGISTRO (INFORMACIÓN DE LA CUENTA) ///////
//-------------------------------------------------------------------------------
document.getElementById('infoUsuario').addEventListener('submit', (event) => submitFormularioUsuario(event))

function submitFormularioUsuario(e){
    e.preventDefault()
    const datosFormulario = Object.fromEntries(new FormData(e.target))
    if(datosFormulario.user.length <= 5){
        alertas[9].classList.remove('d-none')
        setTimeout(() => { alertas[9].classList.add('d-none') }, 4000); return
    }
    if(datosFormulario.pass !== datosFormulario.pass2){
        alertas[8].classList.remove('d-none')
        setTimeout(() => { alertas[8].classList.add('d-none') }, 4000); return
    }
    datosFormulario.idCliente = idCliente
    fetch('Controladores/cliente.php?accion=registrarSuUsuario', {
        method: 'POST',
        body: JSON.stringify(datosFormulario)
    }).then(res => res.json()).then(data => {
        if(data.estado === undefined){
            alertas[5].classList.remove('d-none')
            return
        }
        if(data.estado === true){
            if(data.usuarioDisponible === false){
                alertas[7].classList.remove('d-none')
                setTimeout(() => { alertas[7].classList.add('d-none') }, 4000); return
            }
            alertas[6].classList.remove('d-none')
            e.target.reset()
            setTimeout(() => { window.location.href = 'login' }, 3000); return
        }else{
            alertas[5].classList.remove('d-none')
            return
        }
    })
}

////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////

function cerrarAlertas() {
    alertas.forEach(alerta => {
        alerta.classList.add('d-none')
    })
}

function cambiarAPaso2(){
    if(pasandoDePaso) return
    pasandoDePaso = true
    seccionPaso2.removeEventListener('animationend', terminarOcultarPaso2)
    seccionPaso1.style.position = 'absolute'
    seccionPaso1.classList.add('animate__slideOutLeft')
    seccionPaso1.addEventListener('animationend', terminarOcultarPaso1)
    seccionPaso2.style.display = 'block'
    seccionPaso2.classList.add('animate__slideInRight')
    seccionPaso2.addEventListener('animationend', () => {
        seccionPaso2.classList.remove('animate__slideInRight')
    })
    indicarPaso1.classList.remove('activo')
    indicarPaso2.classList.add('activo')
    document.getElementById('pasoActual').innerHTML = 'Paso 2 de 2'
    document.getElementById('btnCancelar').innerHTML = `<i data-feather="arrow-left" class="me-1 mb-1"></i>Regresar`
    document.getElementById('bntContinuar').innerHTML = `Registrarse<i data-feather="save" class="ms-1 mb-1"></i>`
    pasoDelRegistro = 2
    feather.replace()
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
    })
    indicarPaso2.classList.remove('activo')
    indicarPaso1.classList.add('activo')
    document.getElementById('pasoActual').innerHTML = 'Paso 1 de 2'
    document.getElementById('btnCancelar').innerHTML = `<i data-feather="x" class="me-1 mb-1"></i>Cancelar`
    document.getElementById('bntContinuar').innerHTML = `Siguiente<i data-feather="arrow-right" class="ms-1 mb-1"></i>`
    pasoDelRegistro = 1
    feather.replace()
}

function terminarOcultarPaso1(){
    seccionPaso1.style.position = 'relative'
    seccionPaso1.style.display = 'none'
    seccionPaso1.classList.remove('animate__slideOutLeft')
    pasandoDePaso = false
}

function terminarOcultarPaso2(){
    seccionPaso2.style.position = 'relative'
    seccionPaso2.style.display = 'none'
    seccionPaso2.classList.remove('slideOutRight')
    pasandoDePaso = false
}