elementoID('formAcceso').onsubmit = (e) => {
    e.preventDefault();
    let datosIniciarSesion = new FormData(elementoID('formAcceso'));
    fetch('Controladores/usuario.php?accion=iniciarSesion', { method: 'POST', body: datosIniciarSesion })
    .then(response => response.text()).then(data => {
        if (data == 0) {
            swal({
                title: "Accceso denegado",
                text: "Usuario o contraseña incorrectos",
                icon: "warning",
                button: "Aceptar",
            });
        } else { window.location.replace('inicio'); }
    }).catch(error => console.error(error));
}