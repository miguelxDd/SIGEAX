graficar();
async function graficar() {
  const respuesta = await fetch('Controladores/ruta.php?accion=destMasPaqVendedor');
  const datos = await respuesta.json();
  elementoID('totalDestinos').innerText = datos.length;
  const ctx = document.getElementById('myChart');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: datos.map(destino => destino.destino),
      datasets: [{
        label: 'Destinos más frecuentes',
        data: datos.map(destino => destino.paquetes),
        borderWidth: 1,
        backgroundColor: '#323ECF',
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
}