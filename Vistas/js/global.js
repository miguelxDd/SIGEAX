function elementoID(id){
    return document.getElementById(id);
}
function animarSalidaID(elemento){
    $('#' + elemento).slideUp();
}
function animarEntradaID(elemento){
    $('#' + elemento).slideDown();
}
function ocultarID(elemento){
    $('#' + elemento).hide();    
}
function mostrarID(elemento){
    $('#' + elemento).show();    
}

// ---- para moverse entre las dos secciones -----
// para que esten disponibles globalmente para que sea fácil hacer este efecto en alguna otra vista
function cambiarASeccion1(){
    const seccion1 = elementoID('seccion1'), seccion2 = elementoID('seccion2')
    seccion1.removeEventListener('animationend', terminaOcultarSeccion1)
    seccion2.style.position = 'absolute'
    seccion2.classList.add('saleDerecha')
    seccion2.addEventListener('animationend', terminaOcultarSeccion2)
    seccion1.style.display = 'block'
    seccion1.classList.add('entraIzquierda')
    seccion1.addEventListener('animationend', () => {
        seccion1.classList.remove('entraIzquierda')
    })
}
function cambiarASeccion2(){
    const seccion1 = elementoID('seccion1'), seccion2 = elementoID('seccion2')
    seccion2.removeEventListener('animationend', terminaOcultarSeccion2)
    seccion1.style.position = 'absolute'
    seccion1.classList.add('saleIzquierda')
    seccion1.addEventListener('animationend', terminaOcultarSeccion1)
    seccion2.style.display = 'block'
    seccion2.classList.add('entraDerecha')
    seccion2.addEventListener('animationend', () => {
        seccion2.classList.remove('entraDerecha')
    })
}
function terminaOcultarSeccion1(){
    const seccion = elementoID('seccion1')
    seccion.style.position = 'relative'
    seccion.style.display = 'none'
    seccion.classList.remove('saleIzquierda')
}
function terminaOcultarSeccion2(){
    const seccion = elementoID('seccion2')
    seccion.style.position = 'relative'
    seccion.style.display = 'none'
    seccion.classList.remove('saleDerecha')
}
