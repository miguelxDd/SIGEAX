//obtenemos el div que contendrá la tabla
const vTabla = elementoID('contenedorTabla');
//obtenemos el div que contendrá la vista de detalle
const vDetalle = elementoID('contenedorDetalles');
//obtenemos donde estara ubicado el control de paginacion para la vista detalle
const controlPaginacion = elementoID('controlPaginacion');
//establecemos los valores para tipo envio y tipo vista
let tipoEnvio = elementoID('tipoEnvio').value; let tipoVista = elementoID('tipoVista').value;
//para la paginacion de la vista detalle
let paginasPaquete = [];
// mostramos animación de carga mientras recibe los datos
// vDetalle.insertAdjacentHTML("beforebegin", cargando());
//llamamos a que liste los paquetes de envio normal
// ejecutarVistaDetalle('listarNormales');
mostrarVista();

//vemos cuando se cambie la seleccion de mostrar paquetes del tipo
elementoID('tipoEnvio').onchange = (select) => {
    tipoEnvio = select.target.value; mostrarVista();
}

elementoID('tipoVista').onchange = (select) => {
    tipoVista = select.target.value; mostrarVista();
}

function mostrarVista(){
    if(tipoVista == 'detalles'){
        vTabla.innerHTML = ''; vDetalle.insertAdjacentHTML("beforebegin", cargando()); vDetalle.innerHTML = ''; controlPaginacion.innerHTML = '';
        if(tipoEnvio == 'personalizado'){
            ejecutarVistaDetalle('listarPersonalizado');            
        }else{
            ejecutarVistaDetalle('listarNormales');
        }
    }else{
        vDetalle.innerHTML = ''; vTabla.style.display = 'none'; vTabla.innerHTML = ''; vTabla.insertAdjacentHTML("beforebegin", cargando()); controlPaginacion.innerHTML = '';
        if(tipoEnvio == 'personalizado'){
            //insertamos a la vista la tabla para paquetes PERSONALIZADOS
            vTabla.innerHTML = tablaPaquete('personalizado');
            //llamamos a la tabla diciendole que liste los paquetes de envio personalizado
            ejecutarTabla('listarPersonalizado');
        }else{
            //insertamos a la vista la tabla para paquetes de envio normal
            vTabla.innerHTML = tablaPaquete('normal');
            //llamamos a la tabla diciendole que liste los paquetes de envio normal
            ejecutarTabla('listarNormales');
        }        
    }
}

function bloquearSinPaquetes(){
    elementoID('tipoVista').disabled = true;
    elementoID('tipoEnvio').disabled = true;
}

function ejecutarVistaDetalle(accion){
    fetch("Controladores/paquete.php?accion=" + accion + "&vista=detalles", {method: 'GET'}).then( respuesta => respuesta.json()).then(info => {
        elementoID('cargaContenedor').remove();
        if(info.length == 0){
            vDetalle.innerHTML = '<div></div><div class="alert alert-warning text-center">Aún no tienes ningún paquete.</div>';
            bloquearSinPaquetes();
            return;
        }
        ejeutarPaginacionVistaDetalle(info);
    });
}

//-----------------------------------------------------------------------------------------------------------------
//------------------------------ CONTROL DE LA PAGINACION VISTA DETALLE -------------------------------------------
function ejeutarPaginacionVistaDetalle(info){
    let paginacion = 9; //definimos el número de paquetes por pagina
    paginasPaquete = []; //reiniciamos las paginas
        for(let i = 0; i < info.length; i += paginacion){
            let pagina = info.slice(i, i + paginacion);
            paginasPaquete.push(pagina);
        }
        escribirPagina(1);
}
function escribirPagina(nuMPagina){
    let contPagina = '';
    for(let i = 0; i < paginasPaquete[nuMPagina - 1].length; i++){
        contPagina += paginasPaquete[nuMPagina - 1][i];
    }
    ocultarID('contenedorDetalles');
    vDetalle.innerHTML = contPagina;
    animarEntradaID('contenedorDetalles');
    controlPaginacion.innerHTML = paginacionDetallePaquete(nuMPagina, paginasPaquete.length);
}
function cambiarPagina(direccion){
    let paginaActual = parseInt(elementoID('numeroDePagina').text);
    controlPaginacion.innerHTML = '';
    escribirPagina((direccion == 'siguiente')? (paginaActual + 1) : (paginaActual - 1));
}
//-----------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------
function ejecutarTabla(accion){
    $('#tabla').dataTable({
        ajax: "Controladores/paquete.php?accion=" + accion + "&vista=tabla",
        destroy: true,
        iDisplayLength: 5, //paginacion
        order: [[2, "desc"]], //ordenar (columna, orden)
        lengthChange: false,
        language: {
            // lengthMenu: "Mostrar _MENU_ paquetes por página", // Personaliza el mensaje para seleccionar paginación
            search: "Buscar:",
            // info: "Mostrando _START_ a _END_ de _TOTAL_ paquetes", // Personaliza el mensaje de información
            info: "Mostrando _END_ de un total de _TOTAL_ paquetes", // Personaliza el mensaje de información
            paginate: {
                first: "Primero", // Personaliza el control para ir a la primera página
                last: "Último", // Personaliza el control para ir a la última página
                next: "Siguiente", // Personaliza el control para ir a la siguiente página
                previous: "Anterior" // Personaliza el control para ir a la página anterior
            },
        }
        //evento draw.dt nos sirve para saber cuando la tabla con datatables ya esta cargada con sus datos
    }).on('draw.dt', function () {
        //ya cargada la tabla quitamos animación de carga y mostramos la tabla
        elementoID('cargaContenedor').remove(); vTabla.style.display = '';
    });
}

function verDetalle(idPaquete, tipo){
    localStorage.setItem('idPaquete', idPaquete);
    localStorage.setItem('personalizado', ((tipo == 'Envio normal')? 0 : 1));
}