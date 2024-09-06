let idPaqueteARecibir = 0
listarPaquetesAConfirmar();
function listarPaquetesAConfirmar(){
    $('#paquetesPorConfirmar').dataTable({
        ajax: 'Controladores/paquete.php?accion=listarPaquetesAConfirmar',
        destroy: true,
        iDisplayLength: 10, //paginacion
        order: [[0, 'desc']], //ordenar (columna, orden)
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
            zeroRecords: "Aún no se han agregado paquetes"
        }
    }).on('draw.dt', function(){ feather.replace(); });
}

function verInfoCompleta(paqueteid, identificador, espersonalizado){
    elementoID('abrirModal').click(); idPaqueteARecibir = paqueteid
    elementoID('identificadorDePaquete').innerText = identificador
    fetch(`Controladores/paquete.php?accion=infoPaquete&personalizado=${espersonalizado}&idPaquete=${paqueteid}`)
    .then(res => res.json())
    .then(informacionCompleta => {
        elementoID('infoPaqueteCompleta').innerHTML = informacionCompleta.detalles
        const estamcion = elementoID('costoDeEnvioDetalle').innerText.split('$')[1]
        elementoID('costoDeEnvioDetalle').innerText = `Estamación de costo de envío: $${estamcion}`
        elementoID('infoPaqueteCompleta').insertAdjacentHTML('beforeend', `
        <form class="card m-3 p-3">
            <label class="col-form-label" for="costo_envio">Costo de envío:</label>
            <input type="number" step="0.01" class="form-control" id="costo_envio" name="costo_envio" value="${estamcion}">
        </form>        
        `)
    })
}

function confirmarRecepcionPaquete(){
    if(elementoID('costo_envio').value == ''){
        elementoID('costo_envio').focus()
        return false
    }else{
        fetch(`Controladores/paquete.php?accion=confirmarRecepcionPaquete&idPaquete=${idPaqueteARecibir}&costo_envio=${elementoID('costo_envio').value}`)
        .then(res => res.json())
        .then(respuesta => {
            if(respuesta.estado == true){
                swal({
                    title: 'Paquete confirmado correctamente',
                    icon: 'success',
                    button: 'Aceptar'
                });
                listarPaquetesAConfirmar()
                elementoID('cerrarModalPaqInfo').click()
                elementoID('costo_envio').value = ''                
            }else{
                swal({
                    title: 'Error al confirmar paquete',
                    text: 'No se pudo confirmar el paquete, intente nuevamente',
                    icon: 'error',
                    button: 'Aceptar'
                });
            }
        })
    }
}
