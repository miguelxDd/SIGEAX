elementoID('seccion2').style.display = 'none'
ejecutarTablaNumPorCliente();
function ejecutarTablaNumPorCliente() {
    $('#numporCliente').dataTable({
        ajax: {
            url: "Controladores/paquete.php?accion=clienteNUM",
            dataSrc: (respuesta) => {
                numeroTotalClientes(respuesta.iTotalRecords);
                return respuesta.aaData;
            }
        },
        destroy: true,
        iDisplayLength: 10, //paginacion
        order: [[1, "desc"]], //ordenar (columna, orden)
        lengthChange: false,
        language: {
            // lengthMenu: "Mostrar _MENU_ paquetes por página", // Personaliza el mensaje para seleccionar paginación
            search: "Buscar:",
            info: "Mostrando _START_ a _END_ de _TOTAL_ clientes", // Personaliza el mensaje de información
            info: "Mostrando _END_ de un total de _TOTAL_ clientes", // Personaliza el mensaje de información
            paginate: {
                first: "Primero", // Personaliza el control para ir a la primera página
                last: "Último", // Personaliza el control para ir a la última página
                next: "Siguiente", // Personaliza el control para ir a la siguiente página
                previous: "Anterior" // Personaliza el control para ir a la página anterior
            },
            zeroRecords: "Aún no tienes paquetes registrados"
        }
    }).on('draw.dt', function () { feather.replace(); });
}

function numeroTotalClientes(total) {
    elementoID('totalClientes').innerText = total;
}

function verPaquetesCliente(idcliente, nombre){
    elementoID('nombreCliente').innerText = nombre
    obtenerPaqDeCliente(idcliente)
    cambiarASeccion2()
}

function obtenerPaqDeCliente(idcliente){
    $('#paquetesCliente').dataTable({
        ajax: "Controladores/paquete.php?accion=paqCliente&cliente="+idcliente,
        destroy: true,
        iDisplayLength: 10, //paginacion
        order: [[0, "desc"]], //ordenar (columna, orden)
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
            zeroRecords: "Aún no tienes paquetes registrados"
        }
    }).on('draw.dt', function () { feather.replace(); });
}

function verDetalle(idPaquete, tipo){
    localStorage.setItem('idPaquete', idPaquete); localStorage.setItem('personalizado', tipo);
}