insertarFormularioRegistro(); listarVendedores();
function insertarFormularioRegistro(){
    elementoID('insertarRegistroAqui').innerHTML = formularioRegistroVendedor(false);
}
function listarVendedores(){
    $('#tablaVendedores').dataTable({
        ajax: 'Controladores/cliente.php?accion=listarVendedores&vistaVendedores=true',
        destroy: true,
        iDisplayLength: 15, //paginacion
        order: [[0, 'desc']], //ordenar (columna, orden)
        lengthChange: false,
        language: {
            search: "Buscar:",
            info: "Mostrando _START_ a _END_ de _TOTAL_ vendedores", // Personaliza el mensaje de información
            info: "Mostrando _END_ de un total de _TOTAL_ vendedores", // Personaliza el mensaje de información
            paginate: {
                first: "Primero", // Personaliza el control para ir a la primera página
                last: "Último", // Personaliza el control para ir a la última página
                next: "Siguiente", // Personaliza el control para ir a la siguiente página
                previous: "Anterior" // Personaliza el control para ir a la página anterior
            },
            zeroRecords: "Aún no se han agregado vendedores"
        }
    }).on('draw.dt', () => { feather.replace(); });
}