/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////// GESTIONAR CATEGORIAS ////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
let yaSeSeleccionoCategoria = false, categoriaSeleccionada = 0, editandoCategoria = false;
const tituloModalEditarCategoria = elementoID('tituloModalEditarCategoria'), mensajeModalEditarCategoria = elementoID('mensajeModalEditarCategoria');
const diasSemana = document.querySelectorAll('.semana');
listarCategorias();
function listarCategorias(){
    fetch('Controladores/catalogoReferencia.php?accion=listarCategoriasAdmin').then(resp => resp.text()).then(rutas => {
        document.querySelector('.listaRutas').innerHTML = rutas; feather.replace();
    })
}

function abrirModalAgregarCategoria(){
    editandoCategoria = false;
    tituloModalEditarCategoria.textContent = 'Agregar nueva categoría'; mensajeModalEditarCategoria.textContent = 'Ingrese la información de la nueva categoría';
    elementoID('modalEditarCategoria').classList.add('activo');
}
function verCategoria(categoriaid){
    if(!yaSeSeleccionoCategoria){
        elementoID('cuerpoDestinos').innerHTML = `
            <button class="btn btn-primary" id="btnAgregarProducto" onclick="abrirModalAgregarProducto()">
                <i data-feather="plus"></i> Agregar producto
            </button>
            <main class="listaDestinos"></main>
        `;
        yaSeSeleccionoCategoria = true;
    }
    fetch(`Controladores/catalogoReferencia.php?accion=verProductos&categoriaid=${categoriaid}`).then(resp => resp.text()).then(productos => {
        document.querySelector('.listaDestinos').innerHTML = productos; feather.replace();
        categoriaSeleccionada = categoriaid;
    })
}
function editarCategoria(categoriaid){
    editandoCategoria = true;
    tituloModalEditarCategoria.textContent = 'Editar categoria'; mensajeModalEditarCategoria.textContent = 'Ingrese la nueva información de la categoría';
    categoriaSeleccionada = categoriaid;
    fetch(`Controladores/catalogoReferencia.php?accion=infoDeCategoria&categoriaid=${categoriaid}`).then(resp => resp.json()).then(categoria => {
        if(categoria.estado){
            elementoID('nombre_categoria').value = categoria.categoriaInfo.nombre_categoria;
            elementoID('modalEditarCategoria').classList.add('activo');
        }
    })
}
function eliminarCategoria(categoriaid){
    swal({
        title: '¿Está seguro de eliminar esta categoría?',
        text: 'Se eliminarán todos los productos asociados a esta categoría',
        icon: 'warning',
        buttons: ['Cancelar', 'Aceptar'],
    }).then(resp => {
        if(resp){
            fetch(`Controladores/catalogoReferencia.php?accion=eliminarCategoria&categoriaid=${categoriaid}`).then(resp => resp.json()).then(resp => {
                if(resp.estado){
                    swal({
                        title: resp.mensaje,
                        icon: 'success',
                        button: 'Aceptar'
                    });
                    listarCategorias();
                }else{
                    swal({
                        title: resp.mensaje,
                        text: 'No se pudo eliminar la categoria, intente nuevamente',
                        icon: 'error',
                        button: 'Aceptar'
                    });
                }
            });
        }
    });
}
function guardarNuevaCategoria(){
    const nombre_categoria = elementoID('nombre_categoria').value;
    if(nombre_categoria.trim() == '') return swal({ title: 'Ingrese el nombre de la categoría', icon: 'warning', button: 'Aceptar' });
    if(editandoCategoria){
        fetch(`Controladores/catalogoReferencia.php?accion=editarCategoria`, {
            method: 'POST', ContentType: 'application/json',
            body: JSON.stringify({ categoriaid: categoriaSeleccionada, nombre_categoria: nombre_categoria })
        })
        .then(resp => resp.json()).then(resp => {
            if(resp.estado){
                swal({
                    title: resp.mensaje,
                    icon: 'success',
                    button: 'Aceptar'
                });
                cerrarModalEditarCategoria(); listarCategorias();
            }else{
                swal({
                    title: resp.mensaje,
                    text: 'No se pudo editar la categoría, intente nuevamente',
                    icon: 'error',
                    button: 'Aceptar'
                });
            }
        })
    }else{
        fetch(`Controladores/catalogoReferencia.php?accion=guardarCategoria`, {
            method: 'POST', ContentType: 'application/json',
            body: JSON.stringify({ nombre_categoria: nombre_categoria })
        })
        .then(resp => resp.json()).then(resp => {
            if(resp.estado){
                swal({
                    title: resp.mensaje,
                    icon: 'success',
                    button: 'Aceptar'
                });
                cerrarModalEditarCategoria(); listarCategorias();
            }else{
                swal({
                    title: resp.mensaje,
                    text: 'No se pudo agregar la categoría, intente nuevamente',
                    icon: 'error',
                    button: 'Aceptar'
                });
            }
        })
    }
    editandoCategoria = false; categoriaSeleccionada = 0;
}
function cerrarModalEditarCategoria(){ 
    elementoID('modalEditarCategoria').classList.remove('activo');
    elementoID('nombre_categoria').value = '';
}

/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////// GESTIONAR PRODUCTOS /////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
let editandoProducto = false, productoSeleccionado = 0;

function abrirModalAgregarProducto(){
    editandoProducto = false;
    elementoID('tituloModalEditarProducto').textContent = 'Agregar nuevo producto'; elementoID('mensajeModalEditarProducto').textContent = 'Ingrese la información del nuevo producto';
    elementoID('modalEditarProducto').classList.add('activo');
}
function editarProducto(productoid){
    editandoProducto = true;
    elementoID('tituloModalEditarProducto').textContent = 'Editar producto'; elementoID('mensajeModalEditarProducto').textContent = 'Ingrese la nueva información del producto';
    productoSeleccionado = productoid;
    fetch(`Controladores/catalogoReferencia.php?accion=infoProducto&categoriaid=${categoriaSeleccionada}&productoid=${productoid}`).then(resp => resp.json()).then(producto => {
        if(producto.estado){
            elementoID('nombre_producto').value = producto.productoInfo.nombre_producto;
            elementoID('costo_estimado').value = producto.productoInfo.costo_estimado_envio;
            elementoID('modalEditarProducto').classList.add('activo');
        }
    })
}
function eliminarProducto(productoid){
    swal({
        title: '¿Está seguro de eliminar este producto?',
        icon: 'warning',
        buttons: ['Cancelar', 'Aceptar'],
    }).then(resp => {
        if(resp){
            fetch(`Controladores/catalogoReferencia.php?accion=eliminarProducto&productoid=${productoid}`).then(resp => resp.json()).then(resp => {
                if(resp.estado){
                    swal({
                        title: resp.mensaje,
                        icon: 'success',
                        button: 'Aceptar'
                    });
                    verCategoria(categoriaSeleccionada);
                }else{
                    swal({
                        title: 'Error al eliminar destino',
                        text: 'No se pudo eliminar el destino, intente nuevamente',
                        icon: 'error',
                        button: 'Aceptar'
                    });
                }
            });
        }
    })
}
function guardarNuevoProducto(){
    const datos = Object.fromEntries(new FormData(elementoID('formInfoProducto')));
    if(datos.nombre_producto.trim() == '' || datos.costo_estimado.trim() == ''){
        return swal({ title: 'Complete todos los campos obligatorios', icon: 'warning', button: 'Aceptar' });
    }
    if(editandoProducto){
        datos.productoid = productoSeleccionado;
        fetch('Controladores/catalogoReferencia.php?accion=editarProducto', { 
            method: 'POST', ContentType: 'application/json',
            body: JSON.stringify(datos) })
            .then(resp => resp.json())
        .then(resp => {
            if(resp.estado){
                swal({
                    title: resp.mensaje,
                    icon: 'success',
                    button: 'Aceptar'
                });
                cerrarModalEditarProducto(); verCategoria(categoriaSeleccionada);
            }else{
                swal({
                    title: resp.mensaje,
                    text: 'No se pudo editar el producto, intente nuevamente',
                    icon: 'error',
                    button: 'Aceptar'
                });
            }
        })
    }else{
        datos.categoriaid = categoriaSeleccionada;
        fetch('Controladores/catalogoReferencia.php?accion=guardarNuevoProducto', { 
            method: 'POST', ContentType: 'application/json',
            body: JSON.stringify(datos) }).then(resp => resp.json())
        .then(resp => {
            if(resp.estado){
                swal({
                    title: resp.mensaje,
                    icon: 'success',
                    button: 'Aceptar'
                });
                cerrarModalEditarProducto(); verCategoria(categoriaSeleccionada);
            }else{
                swal({
                    title: resp.mensaje,
                    text: 'No se pudo agregar el producto, intente nuevamente',
                    icon: 'error',
                    button: 'Aceptar'
                });
            }
        })
    }
    editandoProducto = false; productoSeleccionado = 0;
}
function cerrarModalEditarProducto(){
    elementoID('modalEditarProducto').classList.remove('activo');
    elementoID('nombre_producto').value = '';
    elementoID('costo_estimado').value = '';
}