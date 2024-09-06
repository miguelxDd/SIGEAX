ejecutarTablaPaqPorConfirmar();
function ejecutarTablaPaqPorConfirmar(){
    $('#paqPorConfirmar').dataTable({
        ajax: "Controladores/paquete.php?accion=paquetesAgregados",
        destroy: true,        
        iDisplayLength: 10, //paginacion
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
            zeroRecords: "Aún no has agregado paquetes"
        }
    }).on('draw.dt', function(){ feather.replace(); });
}

function verPaquete(paqeteID){
    localStorage.setItem('verPaqID', paqeteID);
    window.location.href = 'verPaquete';
}

function verDetalle(paqeteID, tipoEnvio){
    localStorage.setItem('idPaquete', paqeteID);
    localStorage.setItem('personalizado', ((tipoEnvio == 'Envio normal')? 0 : 1));
}

const  tabla = elementoID('contenedorTabla'); mostrarTabla('normal'); listarNormales();
elementoID('tipoEnvio').onchange = (select) => {
    tipoEnvio = select.target.value; mostrarTabla(tipoEnvio);
}
 function mostrarTabla(tipoEnvio){
    if(tipoEnvio == 'normal'){
        tabla.innerHTML = tablaPaquete('normal'); listarNormales();
    }else{
        tabla.innerHTML = tablaPaquete('personalizado'); listarPersonalizados();
    }
}

function listarNormales(){
    $('#tabla').dataTable({    
        ajax: "Controladores/paquete.php?accion=paquetesNormalesVendedor",
        destroy: true,
        iDisplayLength: 15, //paginacion
        order: [[0, "desc"]], //ordenar (columna, orden)
        lengthChange: false,
        language: {
            search: "Buscar:",
            info: "Mostrando _END_ de un total de _TOTAL_ paquetes", // Personaliza el mensaje de información
            paginate: {
                first: "Primero", // Personaliza el control para ir a la primera página
                last: "Último", // Personaliza el control para ir a la última página
                next: "Siguiente", // Personaliza el control para ir a la siguiente página
                previous: "Anterior" // Personaliza el control para ir a la página anterior
            },
            zeroRecords: "Aún no has agregado paquetes de envio normal"
        }
    }).on('draw.dt', function () { feather.replace(); });
}

function listarPersonalizados(){
    $('#tabla').dataTable({
        ajax: 'Controladores/paquete.php?accion=paquetesPersonalizadosVendedor',
        destroy: true,
        iDisplayLength: 15, //paginacion
        order: [[0, "desc"]], //ordenar (columna, orden)
        lengthChange: false,
        language: {
            search: "Buscar:",
            info: "Mostrando _END_ de un total de _TOTAL_ paquetes", // Personaliza el mensaje de información
            paginate: {
                first: "Primero", // Personaliza el control para ir a la primera página
                last: "Último", // Personaliza el control para ir a la última página
                next: "Siguiente", // Personaliza el control para ir a la siguiente página
                previous: "Anterior" // Personaliza el control para ir a la página anterior
            },
            zeroRecords: "Aún no has agregado paquetes de envio personalizado"
        }
    }).on('draw.dt', function () { feather.replace(); });
}