ejecutarTabla();
function ejecutarTabla(){
    $('#tablaPerfilVendedores').dataTable({
        ajax: "Controladores/consultas.php?accion=perfilVendedores",
        destroy: true,
        iDisplayLength: 5, //paginacion
        order: [[0, "desc"]], //ordenar (columna, orden)
        lengthChange: false,
        searching: false, // Ocultar el buscador
        info: false, // Ocultar el mensaje de información
        language: {
            paginate: {
                first: "Primero", // Personaliza el control para ir a la primera página
                last: "Último", // Personaliza el control para ir a la última página
                next: "Siguiente", // Personaliza el control para ir a la siguiente página
                previous: "Anterior" // Personaliza el control para ir a la página anterior
            },
        }
        //evento draw.dt nos sirve para saber cuando la tabla con datatables ya esta cargada con sus datos
    }).on('draw.dt', function () {
        //Para insertar los iconos Father
        feather.replace();
    });
}