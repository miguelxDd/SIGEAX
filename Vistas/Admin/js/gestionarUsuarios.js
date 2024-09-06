listarUsuarios(); listarUsuariosDesactivados();
function listarUsuarios(){
    $('#usuarios').dataTable({
        ajax: "Controladores/usuario.php?accion=listar",
        destroy: true,
        iDisplayLength: 10, //paginacion
        order: [[0, "desc"]], //ordenar (columna, orden)
        lengthChange: false,
        language: {
            // lengthMenu: "Mostrar _MENU_ paquetes por página", // Personaliza el mensaje para seleccionar paginación
            search: "Buscar:",
            info: "Mostrando _START_ a _END_ de _TOTAL_ usuarios", // Personaliza el mensaje de información
            info: "Mostrando _END_ de un total de _TOTAL_ usuarios", // Personaliza el mensaje de información
            paginate: {
                first: "Primero", // Personaliza el control para ir a la primera página
                last: "Último", // Personaliza el control para ir a la última página
                next: "Siguiente", // Personaliza el control para ir a la siguiente página
                previous: "Anterior" // Personaliza el control para ir a la página anterior
            },
            zeroRecords: "Aún no has agregado usuarios"
        }
    }).on('draw.dt', function(){ feather.replace(); });
}

function listarUsuariosDesactivados(){
    $('#usuariosDesactivados').dataTable({
        ajax: "Controladores/usuario.php?accion=listarDesactivados",
        destroy: true,
        iDisplayLength: 10, //paginacion
        order: [[0, "desc"]], //ordenar (columna, orden)
        lengthChange: false,
        language: {
            // lengthMenu: "Mostrar _MENU_ paquetes por página", // Personaliza el mensaje para seleccionar paginación
            search: "Buscar:",
            info: "Mostrando _START_ a _END_ de _TOTAL_ usuarios", // Personaliza el mensaje de información
            info: "Mostrando _END_ de un total de _TOTAL_ usuarios", // Personaliza el mensaje de información
            paginate: {
                first: "Primero", // Personaliza el control para ir a la primera página
                last: "Último", // Personaliza el control para ir a la última página
                next: "Siguiente", // Personaliza el control para ir a la siguiente página
                previous: "Anterior" // Personaliza el control para ir a la página anterior
            },
            zeroRecords: "Aún no hay usuarios desactivados"
        }
    }).on('draw.dt', function(){ feather.replace(); });
}

function desactivar(usuarioid){
    swal({
        title: "¿Estás seguro de desactivar a este usuario?",
        text: "Una vez desactivado, no podrá acceder al sistema",
        icon: "warning",
        buttons: ["Cancelar", "Desactivar"],
    }).then((desactivar) => {
        if(desactivar){
            fetch(`Controladores/usuario.php?accion=desactivar&usuarioid=${usuarioid}`).then(response => response.json())
            .then(data => {
                console.log(data);
                if(data.estado){
                    swal("Usuario desactivado", data.mensaje, "success");
                    listarUsuarios(); listarUsuariosDesactivados();
                }else{
                    swal("Error", data.mensaje, "error");
                }
            });
        }
    })
}

function activar(usuarioid){
    swal({
        title: "¿Estás seguro de activar a este usuario?",
        text: "Una vez activado, podrá acceder al sistema",
        icon: "warning",
        buttons: ["Cancelar", "Activar"],
    }).then((activar) => {
        if(activar){
            fetch(`Controladores/usuario.php?accion=activar&usuarioid=${usuarioid}`).then(response => response.json())
            .then(data => {
                if(data.estado){
                    swal("Usuario activado", data.mensaje, "success");
                    listarUsuarios(); listarUsuariosDesactivados();
                }else{
                    swal("Error", data.mensaje, "error");
                }
            });
        }
    })
}

function agregarUsuario(){
    const tipoUsuario = elementoID('tipoUsuario').value;
    switch (tipoUsuario) {
        case 'cliente': window.location.href = 'registroCliente'; break;
        case 'vendedor': window.location.href = 'registroVendedor'; break;
        case 'recepcion': window.location.href = 'registroEmpleado'; localStorage.setItem('tipoUsuario', 'recepcion'); break;
        case 'repartidor': window.location.href = 'registroEmpleado'; localStorage.setItem('tipoUsuario', 'repartidor'); break;
    }
}

function mostrar(usuarioid, tipoUsuario){
    localStorage.setItem('usuarioid', usuarioid);
    localStorage.setItem('tipoUsuario', tipoUsuario);
    window.location.href = 'mostrarUsuario';
}