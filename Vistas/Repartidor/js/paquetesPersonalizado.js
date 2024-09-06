let paquetesHoy = [], paquetesT = []; listarPaquetesHoy(); listarPaquetesT();
function listarPaquetesHoy(){
    $("#tablaPaquetesPersonalizadosHoy").dataTable({
        "ajax":{
            url: "Controladores/paquete.php?accion=listarPaquetesPersonalizadosHoy",
            dataSrc: function(json){
                paquetesHoy = json.aaData;
                return json.aaData;
            }
        },
        destroy: true,
        iDisplayLength: 10,
        order: [[ 0, "desc" ]],
        lengthChange: false,
        language: {
            search: "Buscar:",
            info: "Mostrando _START_ a _END_ de _TOTAL_ paquetes", // Personaliza el mensaje de información
            info: "Mostrando _END_ de un total de _TOTAL_ paquetes", // Personaliza el mensaje de información
            paginate: {
                first: "Primero", // Personaliza el control para ir a la primera página
                last: "Último", // Personaliza el control para ir a la última página
                next: "Siguiente", // Personaliza el control para ir a la siguiente página
                previous: "Anterior" // Personaliza el control para ir a la página anterior
            },
            zeroRecords: "No se agregaron paquetes para hoy",
        },
    }).on('draw.dt', function(){
        feather.replace();
        elementoID('totalPaquetesHoy').innerText = paquetesHoy.length;
    });
}

function listarPaquetesT(){
    $("#tablaPaquetesPersonalizadosT").dataTable({
        "ajax":{
            url: "Controladores/paquete.php?accion=listarPaquetesPersonalizadosT",
            dataSrc: function(json){
                paquetesT = json.aaData;
                return json.aaData;
            }
        },
        destroy: true,
        iDisplayLength: 10,
        order: [[ 0, "desc" ]],
        lengthChange: false,
        language: {
            search: "Buscar:",
            info: "Mostrando _START_ a _END_ de _TOTAL_ paquetes", // Personaliza el mensaje de información
            info: "Mostrando _END_ de un total de _TOTAL_ paquetes", // Personaliza el mensaje de información
            paginate: {
                first: "Primero", // Personaliza el control para ir a la primera página
                last: "Último", // Personaliza el control para ir a la última página
                next: "Siguiente", // Personaliza el control para ir a la siguiente página
                previous: "Anterior" // Personaliza el control para ir a la página anterior
            },
            zeroRecords: "No se han agregado paquetes personalizados para los próximos días",
        },
    }).on('draw.dt', function(){
        feather.replace();
        elementoID('totalPaquetesT').innerText = paquetesT.length;
    });
}

function verDetalle(idPaquete){
    localStorage.setItem('idPaquete', idPaquete);
    localStorage.setItem('personalizado', 1);
    localStorage.setItem('hoy', 1);
    window.location.href = 'detallePaquete';
}

function verDetallePersonalizado(idPaquete){
    localStorage.setItem('idPaquete', idPaquete);
    localStorage.setItem('personalizado', 1);
    localStorage.setItem('hoy', 0);
    window.location.href = 'detallePaquete';
}