//-------------------------------------------------------------------------------------
//------------------- PARA HOSTORIAL DE ORDENES PARA CLIENTES -------------------------
// animación de carga
function cargando(){
    return `<div id="cargaContenedor"><div id="cargando" style="margin: auto"></div></div>`;
}
// tabla para mostrar los paquetes normales o personalizados en historialOrdenes
function tablaPaquete(tipo){
    return `
    <table class="table table-hover table-striped table-bordered" id="tabla">
        <thead>
            <tr>
                <th>Identificador</th>
                <th>Descripción</th>
                <th>Fecha Envío</th>
                <th>Total</th>
                <th>${(tipo == 'normal')? 'Destino' : 'Dirección particular'}</th>
                <th>Estado</th>
                <th></th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            
        </tbody>
    </table>
    `;
}
//Elemento vista a detalle de paquete
function paginacionDetallePaquete(numPagina, paginaFin){
    return `
    <nav>
        <ul class="pagination justify-content-end">
            <li class="page-item ${(numPagina == 1)? 'disabled' : ''}">
                <button class="page-link" onclick="cambiarPagina('anterior')">Anterior</button>
            </li>
            <li class="page-item"><a class="page-link" id="numeroDePagina">${numPagina}</a></li>
            <li class="page-item ${(numPagina == paginaFin)? 'disabled' : ''}">
                <button class="page-link" onclick="cambiarPagina('siguiente')">Siguiente</button>
            </li>
        </ul>                
    </nav>
    <p class="text-body-secondary" style="margin-top: -15px;">Número total de páginas: ${paginaFin}</p>
    `;
}

// se muestra en la vista paquetesPorVendedor
function tablaNumeroPaqPorVendedor(){
    return `
    <h4 class="text-center mt-2">Numero de paquetes por vendedor</h4>
    <table class="table table-striped text-center table-bordered" id="numporVendedor">
        <thead>
            <tr class="table-secondary">
                <th>Nombre Vendedor</th>
                <th># de paquetes</th>
                <th></th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
        </tbody>
    </table>
    `;
}
//para mostrar los paquetes de un vendedor especifico en paquetesPorVendedor
function vendedorPaquetes(nombre){
    return `
    <button class="btn btn-primary" onclick="retrocederAvendedores()">Atrás</button>
    <h4 class="text-center mt-2">Paquetes de ${nombre}</h4>
    <table class="table table-striped text-center table-bordered" id="vendedorPaquetes">
        <thead>
            <tr class="table-secondary">
                <th>Descripción</th>
                <th>Fecha envío</th>
                <th>Total</th>
                <th></th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
        </tbody>
    </table>
    `;
}

//formulario de toda la info para registrar a un vendedor
function formularioRegistroVendedor(mostrarTerminosCondiciones = true){
    return `
    <div>
        <main class="pasosRegistro">
            <section class="paso1 animate__animated">
                <h5 class="text-center">Información personal</h5>
                <p class="text-center">Todos los campos son obligatorios.</p>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <strong>¡Advertencia!</strong> Asegurese de llenar todos los campos.
                            <button type="button" class="btn-close"></button>
                        </div>
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <strong>¡Advertencia!</strong> Debes aceptar los términos y condiciones.
                            <button type="button" class="btn-close"></button>
                        </div>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <strong>¡Error!</strong> Ingrese un número de teléfono válido.
                            <button type="button" class="btn-close"></button>
                        </div>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <strong>¡Error!</strong> Ingrese un número de documento válido.
                            <button type="button" class="btn-close"></button>
                        </div>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <strong>¡Error!</strong> Ha ocurrido un error inesperado. Intente nuevamente.
                            <button type="button" class="btn-close"></button>
                        </div>
                    </div>
                </div>
                <form class="row g-3 mb-2" id="informacionVendedor">
                    <div class="col-md-8">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="col-md-4">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" required>
                    </div>
                    <div class="col-12">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Col. La Colonia Av. Avenida #123" required>
                    </div>
                    <div class="col-md-6">
                        <label for="departamento" class="form-label">Departamento</label>
                        <select id="departamento" name="departamento" class="form-select">
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="municipio" class="form-label">Municipio</label>
                        <select id="municipio" name="municipio" class="form-select">
                            <option value="0" selected>Seleccione departamento...</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="documento" class="form-label">Documento</label>
                        <select id="documento" name="documento" class="form-select">
                            <option selected value="dui">DUI</option>
                            <option value="nit">NIT</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="num_documento" class="form-label">Número de documento</label>
                        <input type="text" class="form-control" id="num_documento" name="num_documento" required>
                        <small class="text-body-secondary">Escriba solo los números sin guiones ni espacios</small>
                    </div>
                    <div class="col-12" ${(mostrarTerminosCondiciones === false)? 'hidden' : ''}>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="terminosCondiciones" name="terminosCondiciones" ${(mostrarTerminosCondiciones === false)? 'checked' : ''}>
                            <label class="form-check-label" for="terminosCondiciones">
                                Acepto los terminos y condiciones
                            </label>
                        </div>
                    </div>
                    <button type="submit" id="submitParte1" hidden></button>
                </form>
            </section>


            <section class="paso2 animate__animated">
                <h5 class="text-center">Información de tu negocio</h5>
                <p class="text-center">Todos los campos son obligatorios a menos que se indique lo contrario.</p>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <strong>¡Advertencia!</strong> Asegurese de llenar todos los campos.
                            <button type="button" class="btn-close"></button>
                        </div>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <strong>¡Error!</strong> Ingrese un número de teléfono válido.
                            <button type="button" class="btn-close"></button>
                        </div>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <strong>¡Error!</strong> Ingrese un número de documento válido.
                            <button type="button" class="btn-close"></button>
                        </div>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <strong>¡Error!</strong> Ha ocurrido un error inesperado. Intente nuevamente.
                            <button type="button" class="btn-close"></button>
                        </div>
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <strong>¡Advertencia!</strong> Seleccione un archivo de tipo imagen.
                            <button type="button" class="btn-close"></button>
                        </div>
                    </div>
                </div>
                <form class="row g-3 mb-2" id="informacionNegocio">
                    <div class="col-md-6">
                        <section class="contenedorImagen">
                            <img src="Imagenes/negocioDefecto.png" alt="Logo del negocio" id="logo">
                        </section>
                    </div>
                    <div class="col-md-6">
                        <section class="seccionInputImagen">
                            <label for="logo_negocio" class="form-label">Logo o imagen para tu negocio</label>
                            <input class="form-control" type="file" id="logo_negocio" name="logo_negocio">
                            <button type="button" class="btn btn-secondary mt-2" onclick="eliminarLogoNeg()"><i data-feather="x" class="me-1 mb-1"></i>Eliminar imagen</button>
                        </section>
                    </div>
                    <div class="col-md-8">
                        <label for="nombre_negocio" class="form-label">Nombre de tu negocio</label>
                        <input type="text" class="form-control" id="nombre_negocio" name="nombre_negocio" required>
                    </div>
                    <div class="col-md-4">
                        <label for="telefono_negocio" class="form-label">Teléfono del negocio</label>
                        <input type="tel" class="form-control" id="telefono_negocio" name="telefono_negocio" required>
                    </div>
                    <div class="col-md-8">
                        <label for="direccion_negocio" class="form-label">Dirección del negocio</label>
                        <input type="text" class="form-control" id="direccion_negocio" name="direccion_negocio" placeholder="Col. La Colonia Av. Avenida #123" required>
                    </div>
                    <div class="col-md-4">
                        <label for="correo_negocio" class="form-label">Correo del negocio</label>
                        <input type="mail" class="form-control" id="correo_negocio" name="correo_negocio" placeholder="negocio@ejemplo.com" required>
                    </div>
                    <div class="col-md-6">
                        <label for="departamento_negocio" class="form-label">Departamento</label>
                        <select id="departamento_negocio" name="departamento_negocio" class="form-select">
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="municipio_negocio" class="form-label">Municipio</label>
                        <select id="municipio_negocio" name="municipio_negocio" class="form-select">
                            <option value="0" selected>Seleccione departamento...</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="documento_negocio" class="form-label">Documento</label>
                        <select id="documento_negocio" name="documento_negocio" class="form-select">
                            <option value="nit">NIT</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="num_documento_negocio" class="form-label">Número de documento</label>
                        <input type="text" class="form-control" id="num_documento_negocio" name="num_documento_negocio" required>
                        <small class="text-body-secondary">Escriba solo los números sin guiones ni espacios</small>
                    </div>
                    <div class="col-md-6">
                        <label for="link" class="form-label">Link de página o perfil de Facebook (opcional)</label>
                        <input type="text" class="form-control" id="link" name="link" placeholder="https://www.facebook.com/">
                    </div>
                    <button type="submit" id="submitParte2" hidden></button>
                </form>
            </section>


            <section class="paso3 animate__animated">
                <h5 class="text-center">Información de inicio de sesión</h5>
                <p class="text-center">${(mostrarTerminosCondiciones === false)? 'Establezca un usuario y contraseña. Indiquele que podrá cambiarlos al ingresar' :
                                        'Cree un usuario y contraseña para iniciar sesión en el sistema'}</p>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <strong>¡Error!</strong> No se pudo registrar al vendedor.
                            <button type="button" class="btn-close"></button>
                        </div>
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <strong>¡Éxito!</strong> ${(mostrarTerminosCondiciones === false)? 'Se registró al vendedor y negocio correctamente.' :
                             'Se registró al vendedor y negocio correctamente. Se te redireccionará al inicio de sesión para que inicies sesión con tu nuevo usuario.'}
                            <button type="button" class="btn-close"></button>
                        </div>
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <strong>¡Advertencia!</strong> El nombre de usuario no está disponible. Intente con otro.
                            <button type="button" class="btn-close"></button>
                        </div>
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <strong>¡Advertencia!</strong> Las contraseñas no coinciden.
                            <button type="button" class="btn-close"></button>
                        </div>
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <strong>¡Advertencia!</strong> Usuario demasiado corto.
                            <button type="button" class="btn-close"></button>
                        </div>
                    </div>
                </div>
                <form class="row g-3 mb-2" id="infoUsuario">
                    <div class="col-12">
                        <label for="user" class="form-label">Nombre de usuario</label>
                        <input type="text" class="form-control" id="user" name="user" required>
                        <small class="text-body-secondary">Escriba un usuario de por lo menos 5 caracteres</small>
                    </div>
                    <div class="col-12">
                        <label for="pass" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="pass" name="pass" required>
                    </div>
                    <div class="col-12">
                        <label for="pass2" class="form-label">Confirmar contraseña</label>
                        <input type="password" class="form-control" id="pass2" name="pass2" required>
                    </div>
                    <button type="submit" id="submitParte3" hidden></button>
                </form>
            </section>
        </main>


        <footer class="botonesForm mt-2">
            <button type="button" class="btn btn-secondary" id="btnCancelar"><i data-feather="x" class="me-1 mb-1"></i>Cancelar</button>
            <div class="contenedorIndicadores">
                <section class="indicadores">
                    <div class="indicador indicarPaso1 activo"></div>
                    <div class="indicador indicarPaso2"></div>
                    <div class="indicador indicarPaso3"></div>
                </section>
                <small class="text-body-secondary" id="pasoActual">Paso 1 de 3</small>
            </div>
            <button type="button" class="btn btn-secondary" id="bntContinuar">Siguiente<i data-feather="arrow-right" class="ms-1 mb-1"></i></button>
        </footer>
    </div>
    `
}
//-------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------