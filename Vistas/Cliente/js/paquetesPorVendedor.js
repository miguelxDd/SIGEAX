const tablaPaq = elementoID('contenedorTabla');
const tablanumPaqPorVendedor = elementoID('contenedorTabla2');
const tipoEnvio = elementoID('tipoEnvio');

//mostramos los vendedores y el número de paquetes que tiene con cada uno
retrocederAvendedores();

// mostramos los paquetes de un vendedor
function verPaquetesVendedor(idVendedor, nombre){
    tablanumPaqPorVendedor.innerHTML = '';
    ocultarID('contenedorTabla');
    tablaPaq.innerHTML = vendedorPaquetes(nombre);
    animarEntradaID('contenedorTabla');
    $('#vendedorPaquetes').dataTable({
        ajax: "Controladores/paquete.php?accion=paqVendedor&vendedor=" + idVendedor,
        destroy: true,
        iDisplayLength: 5, //paginacion
        order: [[1, "desc"]], //ordenar (columna, orden)
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
        }
    }).on('draw.dt', function(){ feather.replace(); });
}

function retrocederAvendedores(){
    tablaPaq.innerHTML = '';
    ocultarID('contenedorTabla2');
    tablanumPaqPorVendedor.innerHTML = tablaNumeroPaqPorVendedor();
    animarEntradaID('contenedorTabla2');
    ejecutarTablaNumPorVendedor();
}

function verDetalle(idPaquete, tipo){
    localStorage.setItem('idPaquete', idPaquete);
    localStorage.setItem('personalizado', tipo);
}

function ejecutarTablaNumPorVendedor(){
    $('#numporVendedor').dataTable({
        ajax: "Controladores/paquete.php?accion=vendedorNUM",
        destroy: true,
        iDisplayLength: 5, //paginacion
        order: [[1, "desc"]], //ordenar (columna, orden)
        lengthChange: false,
        language: {
            // lengthMenu: "Mostrar _MENU_ paquetes por página", // Personaliza el mensaje para seleccionar paginación
            search: "Buscar:",
            info: "Mostrando _START_ a _END_ de _TOTAL_ vendedores", // Personaliza el mensaje de información
            info: "Mostrando _END_ de un total de _TOTAL_ vendedores", // Personaliza el mensaje de información
            paginate: {
                first: "Primero", // Personaliza el control para ir a la primera página
                last: "Último", // Personaliza el control para ir a la última página
                next: "Siguiente", // Personaliza el control para ir a la siguiente página
                previous: "Anterior" // Personaliza el control para ir a la página anterior
            },
            zeroRecords: "Aún no tienes paquetes registrados"
        }
    }).on('draw.dt', function(){ feather.replace(); });
}