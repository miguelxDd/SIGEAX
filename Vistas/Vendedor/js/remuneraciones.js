let totalRemu = 0, totalRemuDinero = 0
listarRemuneraciones()
function listarRemuneraciones() {
    $('#tablaRemuneraciones').dataTable({
        ajax: {
            url: 'Controladores/consultas.php?accion=listarRemuPendientes',
            dataSrc: function (json) {
                totalRemu = json.aaData.length;
                json.aaData.forEach(element => { totalRemuDinero += parseFloat(element[4].split('$')[1]) });
                elementoID('totalRePendientes').innerText = totalRemu
                elementoID('totalRePendientesD').innerText = '$' + totalRemuDinero.toFixed(2)
                return json.aaData
            }
        },
        destroy: true,
        responsive: true,
        order: [[1, "desc"]],
        lengthChange: false,
        pageLength: 10,
        language: {
            search: "Buscar:",
            info: "Mostrando _START_ a _END_ de _TOTAL_ remuneraciones",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            },
            zeroRecords: "No hay remuneraciones pendientes"
        }
    }).on('draw.dt', function () { feather.replace() });
}