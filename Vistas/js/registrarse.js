const vistaOpcionVendedor = document.querySelector('.opcionVendedor')
const vistaOpcionCliente = document.querySelector('.opcionCliente')
const btnVendedor = document.querySelector('.btnVendedor'), btnCliente = document.querySelector('.btnCliente')
const indicarVendedor = document.querySelector('.indicarVendedor'), indicarCliente = document.querySelector('.indicarCliente')
vistaOpcionVendedor.style.display = 'none'
let cambiandoOpcion = false
document.querySelectorAll('.btnsOpci').forEach(btn => {
    btn.addEventListener('click', e => {
        if (e.target.classList.contains('btnVendedor')) {
            if(btnVendedor.classList.contains('activo')) return
            if(cambiandoOpcion) return
            cambiandoOpcion = true
            vistaOpcionVendedor.removeEventListener('animationend', terminaOcultarVendedor)
            btnCliente.classList.remove('activo')
            btnVendedor.classList.add('activo')
            vistaOpcionCliente.style.position = 'absolute'
            vistaOpcionCliente.classList.add('animate__slideOutLeft')
            vistaOpcionCliente.addEventListener('animationend', terminaOcultarCliente)
            vistaOpcionVendedor.style.display = 'block'
            vistaOpcionVendedor.classList.add('animate__slideInRight')
            vistaOpcionVendedor.addEventListener('animationend', () => {
                vistaOpcionVendedor.classList.remove('animate__slideInRight')
            })           
            indicarCliente.classList.remove('activo')
            indicarVendedor.classList.add('activo')
        } else {
            if(btnCliente.classList.contains('activo')) return
            if(cambiandoOpcion) return
            cambiandoOpcion = true
            vistaOpcionCliente.removeEventListener('animationend', terminaOcultarCliente)
            btnVendedor.classList.remove('activo')
            btnCliente.classList.add('activo')
            vistaOpcionVendedor.style.position = 'absolute'
            vistaOpcionVendedor.classList.add('animate__slideOutRight')
            vistaOpcionVendedor.addEventListener('animationend', terminaOcultarVendedor)
            vistaOpcionCliente.style.display = 'block'
            vistaOpcionCliente.classList.add('animate__slideInLeft')
            vistaOpcionCliente.addEventListener('animationend', () => {
                vistaOpcionCliente.classList.remove('animate__slideInLeft')
            })
            indicarVendedor.classList.remove('activo')
            indicarCliente.classList.add('activo')
        }
    })
})

function terminaOcultarCliente(){
    vistaOpcionCliente.style.position = 'relative'
    vistaOpcionCliente.style.display = 'none'
    vistaOpcionCliente.classList.remove('animate__slideOutLeft')
    cambiandoOpcion = false
}

function terminaOcultarVendedor(){
    vistaOpcionVendedor.style.position = 'relative'
    vistaOpcionVendedor.style.display = 'none'
    vistaOpcionVendedor.classList.remove('animate__slideOutRight')
    cambiandoOpcion = false
}