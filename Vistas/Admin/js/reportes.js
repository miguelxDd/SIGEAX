let informacionDestinosD = [], grafico1 = 0
const inputFechas = elementoID('paraSeleccionarFechas'); inputFechas.style.display = 'none';
const para3Meses = elementoID('ultimos3Meses');
informacionDestinos();
function informacionDestinos(fechaInicio = '', fechaFin = ''){
    $('#destinosInfo').dataTable({
        dom: 'Bfrtip', //para los botones
        buttons: [
            {
                extend: 'pdfHtml5',
                text: '<i data-feather="file-text"></i> Exportar a PDF',
                className: 'btn btn-secondary',
                title: 'Información de destinos',
                exportOptions: {
                    columns: [0, 1, 2]
                },
                customize: function (doc) {
                    doc.content[1].table.widths = ["*", "*", "*"];
                    let numFilas = doc.content[1].table.body.length;
                    for (let i = 1; i < numFilas; i++) {
                        doc.content[1].table.body[i][0].alignment = 'center';
                        doc.content[1].table.body[i][1].alignment = 'center';
                        doc.content[1].table.body[i][2].alignment = 'center';
                    }
                },
                filename: 'Información destinos',
                download: 'open',
                // messageTop: 'Información de destinos de los últimos 3 meses.',
            }
        ],
        destroy: true,
        ajax: {
            url: `Controladores/consultas.php?accion=destinosInfo&fechaInicio=${fechaInicio}&fechaFin=${fechaFin}`,
            dataSrc: function (d) {
                informacionDestinosD = d.aaData; graficarInfoDestinos();
                return d.aaData;
            }
        },
        order: [[0, "desc"]],
        iDisplayLength: 10, //paginacion
        lengthChange: false,
        language: {
            search: "Buscar:",
            info: "Mostrando _START_ a _END_ de _TOTAL_ destinos", // Personaliza el mensaje de información
            paginate: {
                first: "Primero", // Personaliza el control para ir a la primera página
                last: "Último", // Personaliza el control para ir a la última página
                next: "Siguiente", // Personaliza el control para ir a la siguiente página
                previous: "Anterior" // Personaliza el control para ir a la página anterior
            },
            zeroRecords: "Aún no hay destinos registrados"
        }
    }).on('draw.dt', function () { feather.replace(); });
}

function graficarInfoDestinos(){
    let destinos = [], numeroPaquetes = [], valorDinero = [];    
    for(let i = 0; i < informacionDestinosD.length; i++){
        destinos.push(informacionDestinosD[i][0]); numeroPaquetes.push(informacionDestinosD[i][1]);
        valorDinero.push(informacionDestinosD[i][2].split('$')[1]);
    }
    let ctx = elementoID('destinosInfoChart').getContext('2d');
    grafico1 = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: destinos,
            datasets: [
                {
                    label: 'Número de paquetes',
                    data: numeroPaquetes,
                    backgroundColor: '#007bff',
                    borderColor: '#007bff',
                    borderWidth: 1
                },
                {
                    label: 'Valor en dinero',
                    data: valorDinero,
                    backgroundColor: '#28a745',
                    borderColor: '#28a745',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Información de destinos'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            //agregamos el signo de dolar solo al dato de valor en dinero
                            if(context.dataset.label == 'Valor en dinero'){
                                return context.dataset.label + ': $' + context.parsed.y;
                            }
                        }
                    }
                }
            },
        }
    });
}

function seleccionarFechas(){
    para3Meses.style.display = 'none'; inputFechas.style.display = 'block';
}
function cerrarFechas(){
    para3Meses.style.display = 'block'; inputFechas.style.display = 'none';
    grafico1.destroy();
    informacionDestinos();
}

elementoID('btnFechas').addEventListener('click', () => {
    let fechaInicio = elementoID('fechaInicio').value, fechaFin = elementoID('fechaFin').value;
    if(fechaInicio != '' && fechaFin != ''){
        grafico1.destroy();
        informacionDestinos(fechaInicio, fechaFin);
    }else{
        swal({ title: 'Debe seleccionar ambas fechas', icon: 'warning', button: 'Aceptar'})
    }
})