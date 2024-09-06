(async () => await listarDepartamentos())();
const tipoUsuario = localStorage.getItem('tipoUsuario'), usuarioid = localStorage.getItem('usuarioid'); localStorage.removeItem('tipoUsuario'); localStorage.removeItem('usuarioid');
(tipoUsuario === 'cliente' || tipoUsuario === 'vendedor')? elementoID('paraClientes').style.display = 'block' : elementoID('paraClientes').style.display = 'none';
(tipoUsuario === 'vendedor')? elementoID('informacionNegocio').style.display = 'block' : elementoID('informacionNegocio').style.display = 'none';

if(usuarioid !== null && tipoUsuario !== null){
    obtenerInfoPersonal(); if(tipoUsuario === 'vendedor') obtenerInfoNegocio();
    obtenerInfoUsuario();
}
else {
    swal({
        title: "No se ha seleccionado un usuario",
        text: "Vuele a la pagina gestionar usuarios y seleccione un usuario",
        icon: "warning",
        button: "Aceptar",
    })
}
async function listarDepartamentos() {
    fetch('Controladores/consultas.php?accion=selectDepartamentos').then(res => res.text())
    .then(data => {
        elementoID('departamento').innerHTML = data
        elementoID('departamento_negocio').innerHTML = data
    })
}
async function listarMunicipios(idDepartamento, inputNegocio = false) {
    const respuesta = await fetch(`Controladores/consultas.php?accion=selectMunicipios&departamentoid=${idDepartamento}`)
    const opciones = await respuesta.text();
    (!inputNegocio)? document.getElementById('municipio').innerHTML = opciones : document.getElementById('municipio_negocio').innerHTML = opciones
}
////////////////////////////////////////////////////////////////////////////////////////
/////////////////////// para la parte 1 de informacion personal ///////////////////////
///////////////////////////////////////////////////////////////////////////////////////
let idCliente = 0;
const inputsInfoPersonal = document.querySelector('#informacionCliente').querySelectorAll('input');
const selectsInfoPersonal = document.querySelector('#informacionCliente').querySelectorAll('select');
const btnEditarInfoPersonal = document.querySelector('#btnEditarInfoPersonal');
const btnGuardarInfoPersonal = document.querySelector('#btnGuardarInfoPersonal'); btnGuardarInfoPersonal.style.display = 'none';
const btnCancelarInfoPersonal = document.querySelector('#btnCancelarInfoPersonal'); btnCancelarInfoPersonal.style.display = 'none';
inputsInfoPersonal.forEach(input => { input.disabled = true; }); selectsInfoPersonal.forEach(select => { select.disabled = true; });

async function obtenerInfoPersonal(){
    const respuesta = await fetch(`Controladores/usuario.php?accion=obtenerInfoPersonal&usuarioid=${usuarioid}&tipoUsuario=${tipoUsuario}`)
    const infoPersonal = await respuesta.json()
    if(infoPersonal.estado){
        inputsInfoPersonal[0].value = infoPersonal.info.nombre; inputsInfoPersonal[1].value = infoPersonal.info.telefono;
        if(tipoUsuario === 'cliente' || tipoUsuario === 'vendedor'){
            selectsInfoPersonal[0].querySelector(`option[value="${infoPersonal.info.departamentoID}"]`).selected = true;
            await listarMunicipios(infoPersonal.info.departamentoID)
            selectsInfoPersonal[1].querySelector(`option[value="${infoPersonal.info.municipioID}"]`).selected = true;
            idCliente = infoPersonal.info.clienteID;
        }else { idCliente = infoPersonal.info.empleadoID; }
        inputsInfoPersonal[2].value = infoPersonal.info.direccion; selectsInfoPersonal[2].querySelector(`option[value="${infoPersonal.info.tipoDocumento}"]`).selected = true;
        inputsInfoPersonal[3].value = infoPersonal.info.documento;
}
}

btnEditarInfoPersonal.addEventListener('click', () => {
    inputsInfoPersonal.forEach(input => { input.disabled = false; }); selectsInfoPersonal.forEach(select => { select.disabled = false; });
    btnEditarInfoPersonal.style.display = 'none'; btnGuardarInfoPersonal.style.display = 'block'; btnCancelarInfoPersonal.style.display = 'block';
})

btnCancelarInfoPersonal.addEventListener('click', () => {
    inputsInfoPersonal.forEach(input => { input.disabled = true; }); selectsInfoPersonal.forEach(select => { select.disabled = true; });
    btnEditarInfoPersonal.style.display = 'block'; btnGuardarInfoPersonal.style.display = 'none'; btnCancelarInfoPersonal.style.display = 'none';
})

btnGuardarInfoPersonal.addEventListener('click', () => { elementoID('submitParte1').click(); })

elementoID('informacionCliente').addEventListener('submit', (e) => {
    e.preventDefault();
    const datosFormulario = Object.fromEntries(new FormData(e.target))
    // Validamos que en telefono solo se ingresen numeros
    if(isNaN(datosFormulario.telefono)){
        swal({ title: "El telefono solo debe contener numeros", icon: "warning", button: "Aceptar", }); return
    }
    // Validamos que en documento solo se ingresen numeros
    if(isNaN(datosFormulario.num_documento)){
        swal({ title: "El documento solo debe contener numeros", icon: "warning", button: "Aceptar", }); return
    }
    if(tipoUsuario === 'cliente' || tipoUsuario === 'vendedor'){    
        if(datosFormulario.departamento === '0' || datosFormulario.municipio === '0'){
            swal({ title: "Seleccione un departamento y un municipio", icon: "warning", button: "Aceptar", }); return
        }
    }
    console.log(datosFormulario);
    datosFormulario.usuarioid = idCliente;
    fetch('Controladores/usuario.php?accion=editarInfoPersonal&tipoUsuario=' + tipoUsuario, {
        method: 'POST',
        body: JSON.stringify(datosFormulario)
    }).then(res => res.json()).then(data => {
        if(data.estado){
            swal({
                title: "Informacion personal actualizada correctamente",
                icon: "success",
                button: "Aceptar",
            })
            inputsInfoPersonal.forEach(input => { input.disabled = true; }); selectsInfoPersonal.forEach(select => { select.disabled = true; });
            btnEditarInfoPersonal.style.display = 'block'; btnGuardarInfoPersonal.style.display = 'none'; btnCancelarInfoPersonal.style.display = 'none';
        }else{
            swal({
                title: "Error al actualizar la informacion personal",
                icon: "error",
                button: "Aceptar",
            })
        }
    })
})

////////////////////////////////////////////////////////////////////////////////////////
/////////////////////// para la parte 2 de informacion de negocio ///////////////////////
///////////////////////////////////////////////////////////////////////////////////////
let idNegocio = 0;
const inputsInfoNegocio = document.querySelector('#informacionNegocio').querySelectorAll('input');
const selectsInfoNegocio = document.querySelector('#informacionNegocio').querySelectorAll('select');
const btnEditarInfoNegocio = document.querySelector('#btnEditarInfoNegocio');
const btnGuardarInfoNegocio = document.querySelector('#btnGuardarInfoNegocio'); btnGuardarInfoNegocio.style.display = 'none';
const btnCancelarInfoNegocio = document.querySelector('#btnCancelarInfoNegocio'); btnCancelarInfoNegocio.style.display = 'none';
inputsInfoNegocio.forEach(input => { input.disabled = true; }); selectsInfoNegocio.forEach(select => { select.disabled = true; });

async function obtenerInfoNegocio(){
    const respuesta = await fetch(`Controladores/negocio.php?accion=obtenerInfoNegocio&usuarioid=${usuarioid}`)
    const infoNegocio = await respuesta.json()
    if(infoNegocio.estado){
        if(infoNegocio.info.logo != 'negocioDefecto.png') elementoID('logoNegocio').src = `Imagenes/negocios/${infoNegocio.info.logo}`;
        inputsInfoNegocio[1].value = infoNegocio.info.nombre; inputsInfoNegocio[2].value = infoNegocio.info.telefono;
        selectsInfoNegocio[0].querySelector(`option[value="${infoNegocio.info.departamentoID}"]`).selected = true;
        await listarMunicipios(infoNegocio.info.departamentoID, true)
        selectsInfoNegocio[1].querySelector(`option[value="${infoNegocio.info.municipioID}"]`).selected = true;
        idNegocio = infoNegocio.info.negocioID;
        inputsInfoNegocio[3].value = infoNegocio.info.direccion; inputsInfoNegocio[4].value = infoNegocio.info.email;
        selectsInfoNegocio[2].querySelector(`option[value="${infoNegocio.info.tipoDocumento}"]`).selected = true;
        inputsInfoNegocio[5].value = infoNegocio.info.documento; inputsInfoNegocio[6].value = infoNegocio.info.link;
        inputsInfoNegocio[7].checked = (infoNegocio.info.promocionar == 1)? true : false;
    }
}

btnEditarInfoNegocio.addEventListener('click', () => {
    inputsInfoNegocio.forEach(input => { input.disabled = false; }); selectsInfoNegocio.forEach(select => { select.disabled = false; });
    btnEditarInfoNegocio.style.display = 'none'; btnGuardarInfoNegocio.style.display = 'block'; btnCancelarInfoNegocio.style.display = 'block';
})

btnCancelarInfoNegocio.addEventListener('click', () => {
    inputsInfoNegocio.forEach(input => { input.disabled = true; }); selectsInfoNegocio.forEach(select => { select.disabled = true; });
    btnEditarInfoNegocio.style.display = 'block'; btnGuardarInfoNegocio.style.display = 'none'; btnCancelarInfoNegocio.style.display = 'none';
})

btnGuardarInfoNegocio.addEventListener('click', () => { elementoID('submitParte2').click(); })

elementoID('informacionNegocio').addEventListener('submit', (e) => {
    e.preventDefault()
    const datosFormulario = new FormData(e.target)
    // validamos que en telefono solo se ingresen numeros
    if(isNaN(datosFormulario.get('telefono_negocio'))){
        swal({ title: "El telefono solo debe contener numeros", icon: "warning", button: "Aceptar", }); return
    }
    // validamos que en documento solo se ingresen numeros
    if(isNaN(datosFormulario.get('num_documento_negocio'))){
        swal({ title: "El documento solo debe contener numeros", icon: "warning", button: "Aceptar", }); return
    }
    if(datosFormulario.get('departamento_negocio') === '0' || datosFormulario.get('municipio_negocio') === '0'){
        swal({ title: "Seleccione un departamento y un municipio", icon: "warning", button: "Aceptar", }); return
    }
    if(document.getElementById('logo_negocio').files.length === 0){
        datosFormulario.append('logo_negocio', 'negocioDefecto.png')
    }else{
        datosFormulario.append('logo_negocio', 'logo_negocio_cliente_' + idCliente + '.' + datosFormulario.get('logo_negocio').name.split('.')[1])
        datosFormulario.append('logo_imagen', document.getElementById('logo_negocio').files[0])
    }
    datosFormulario.append('idNegocio', idNegocio)
    datosFormulario.append('promocionar', (elementoID('promocionar').checked) ? 1 : 0)
    fetch('Controladores/negocio.php?accion=actualizar', {
        method: 'POST',
        body: datosFormulario
    }).then(res => res.json()).then(data => {
        if(data.estado){
            swal({
                title: "Informacion de negocio actualizada correctamente",
                icon: "success",
                button: "Aceptar",
            })
            inputsInfoNegocio.forEach(input => { input.disabled = true; }); selectsInfoNegocio.forEach(select => { select.disabled = true; });
            btnEditarInfoNegocio.style.display = 'block'; btnGuardarInfoNegocio.style.display = 'none'; btnCancelarInfoNegocio.style.display = 'none';
        }else{
            swal({
                title: "Error al actualizar la informacion de negocio",
                icon: "error",
                button: "Aceptar",
            })
        }
    })
})

////////////////////////////////////////////////////////////////////////////////////////
/////////////////////// para la parte 3 de informacion de usuario ///////////////////////
///////////////////////////////////////////////////////////////////////////////////////
const inputsInfoUsuario = document.querySelector('#infoUsuario').querySelectorAll('input');
const btnEditarInfoUsuario = document.querySelector('#btnEditarInfoUsuario');
const btnGuardarInfoUsuario = document.querySelector('#btnGuardarInfoUsuario'); btnGuardarInfoUsuario.style.display = 'none';
const btnCancelarInfoUsuario = document.querySelector('#btnCancelarInfoUsuario'); btnCancelarInfoUsuario.style.display = 'none';
const btnCambiarContrasena = document.querySelector('#btnCambiarContrasena'), seccionCambiarContrasena = elementoID('cambiarContra'); seccionCambiarContrasena.style.display = 'none';
const btnGuardarContrasena = document.querySelector('#btnGuardarContrasena'); btnGuardarContrasena.style.display = 'none';
const btnCancelarContrasena = document.querySelector('#btnCancelarContrasena'); btnCancelarContrasena.style.display = 'none';
inputsInfoUsuario.forEach(input => { input.disabled = true; });

function obtenerInfoUsuario(){
    fetch(`Controladores/usuario.php?accion=obtenerInfoUsuario&usuarioid=${usuarioid}`).then(res => res.json())
    .then(data => {
        if(data.estado){
            inputsInfoUsuario[0].value = data.info.user;
        }
    })
}

btnEditarInfoUsuario.addEventListener('click', () => {
    inputsInfoUsuario[0].disabled = false; btnCambiarContrasena.style.display = 'none';
    btnEditarInfoUsuario.style.display = 'none'; btnGuardarInfoUsuario.style.display = 'block'; btnCancelarInfoUsuario.style.display = 'block';
})

btnCancelarInfoUsuario.addEventListener('click', () => {
    inputsInfoUsuario[0].disabled = true; btnCambiarContrasena.style.display = 'block';
    btnEditarInfoUsuario.style.display = 'block'; btnGuardarInfoUsuario.style.display = 'none'; btnCancelarInfoUsuario.style.display = 'none';
})

btnCambiarContrasena.addEventListener('click', () => {
    seccionCambiarContrasena.style.display = 'block'; btnEditarInfoUsuario.style.display = 'none';
    inputsInfoUsuario[1].disabled = false;
    btnCambiarContrasena.style.display = 'none'; btnGuardarContrasena.style.display = 'block'; btnCancelarContrasena.style.display = 'block';    
})

btnCancelarContrasena.addEventListener('click', () => {
    seccionCambiarContrasena.style.display = 'none'; btnEditarInfoUsuario.style.display = 'block';
    inputsInfoUsuario[1].disabled = true;
    btnCambiarContrasena.style.display = 'block'; btnGuardarContrasena.style.display = 'none'; btnCancelarContrasena.style.display = 'none';    
})

btnGuardarInfoUsuario.addEventListener('click', () => { elementoID('submitParte3').click(); })

elementoID('infoUsuario').addEventListener('submit', (e) => {
    e.preventDefault()
    if(inputsInfoUsuario[0].value.length < 5){
        swal({ title: "El nombre de usuario debe tener minimo 5 caracteres", icon: "warning", button: "Aceptar", }); return
    }
    if(inputsInfoUsuario[1].disabled){
        const datosFormulario = Object.fromEntries(new FormData(e.target))
        fetch('Controladores/usuario.php?accion=editarInfoUsuario&usuarioid=' + usuarioid, {
            method: 'POST',
            body: JSON.stringify(datosFormulario)
        }).then(res => res.json()).then(data => {
            if(data.estado){
                if(data.usuarioDisponible === false){
                    swal({
                        title: "El nombre de usuario ya esta en uso",
                        icon: "warning",
                        button: "Aceptar",
                    })
                    return
                }
                swal({
                    title: "Informacion de usuario actualizada correctamente",
                    icon: "success",
                    button: "Aceptar",
                })
                inputsInfoUsuario[0].disabled = true; btnCambiarContrasena.style.display = 'block';
                btnEditarInfoUsuario.style.display = 'block'; btnGuardarInfoUsuario.style.display = 'none'; btnCancelarInfoUsuario.style.display = 'none';
            }else{
                swal({
                    title: "Error al actualizar la informacion de usuario",
                    icon: "error",
                    button: "Aceptar",
                })
            }
        })
    }
});

btnGuardarContrasena.addEventListener('click', () => {
    if(inputsInfoUsuario[1].value.length == 0){
        swal({ title: "Ingrese una contraseña", icon: "warning", button: "Aceptar", }); return
    }
    fetch(`Controladores/usuario.php?accion=cambiarContrasena&usuarioid=${usuarioid}`, {
        method: 'POST',
        body: JSON.stringify({ contrasena: inputsInfoUsuario[1].value })
    }).then(res => res.json()).then(data => {
        if(data.estado){
            swal({
                title: "Contraseña actualizada correctamente",
                icon: "success",
                button: "Aceptar",
            })
            seccionCambiarContrasena.style.display = 'none'; btnEditarInfoUsuario.style.display = 'block';
            inputsInfoUsuario[1].disabled = true; inputsInfoUsuario[1].value = '';
            btnCambiarContrasena.style.display = 'block'; btnGuardarContrasena.style.display = 'none'; btnCancelarContrasena.style.display = 'none';    
        }else{
            swal({
                title: "Error al actualizar la contraseña",
                icon: "error",
                button: "Aceptar",
            })
        }
    })
});
