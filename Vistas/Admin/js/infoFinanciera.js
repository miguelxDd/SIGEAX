// contenedores de los graficos
const ingresosEnvNormal = elementoID('ingresosEnvNormal');
const ingresosEnvPerson = elementoID('ingresosEnvPerson');
const numeroEnvNormal = elementoID('numeroEnvNormal');
const numeroEnvPerson = elementoID('numeroEnvPerson');

const opcionesDeLosGraficos = {
    width: 600,
    height: 350,
    rightPriceScale: {
        visible: true,
        borderColor: 'rgba(197, 203, 206, 1)',
    },
    layout: {
        background: {
            type: 'solid',
            color: '#ffffff',
        },
        textColor: 'rgba(33, 56, 77, 1)',
    },
    grid: {
        horzLines: {
            color: '#F0F3FA',
        },
        vertLines: {
            color: '#F0F3FA',
        },
    },
    crosshair: {
        horzLine: {
            visible: false,
        },
    },
    timeScale: {
        borderColor: 'rgba(197, 203, 206, 1)',
    },
    handleScroll: {
        vertTouchDrag: false,
    },
};

// grafico de ingresos por envios normales
let chartIngrEnvNormal = LightweightCharts.createChart(ingresosEnvNormal, opcionesDeLosGraficos);
let ingresosEnvNormalSeries = chartIngrEnvNormal.addLineSeries({
    color: 'rgba(76, 175, 80, 1)',
    lineWidth: 2,
});
// grafico de ingresos por envios personales
let chartIngrEnvPerson = LightweightCharts.createChart(ingresosEnvPerson, opcionesDeLosGraficos);
let ingresosEnvPersonSeries = chartIngrEnvPerson.addLineSeries({
    color: 'rgba(76, 175, 80, 1)',
    lineWidth: 2,
});
// grafico de numero de envios normales
let chartNumEnvNormal = LightweightCharts.createChart(numeroEnvNormal, opcionesDeLosGraficos);
let numeroEnvNormalSeries = chartNumEnvNormal.addLineSeries({
    color: 'rgba(76, 175, 80, 1)',
    lineWidth: 2,
});
// grafico de numero de envios personales
let chartNumEnvPerson = LightweightCharts.createChart(numeroEnvPerson, opcionesDeLosGraficos);
let numeroEnvPersonSeries = chartNumEnvPerson.addLineSeries({
    color: 'rgba(76, 175, 80, 1)',
    lineWidth: 2,
});

// funcion para obtener los datos de los graficos
graficarDatos();

async function graficarDatos() {
    // obtenemos los datos de los graficos
    const [ingresosEnvNormaldatos, ingresosEnvPersondatos, numeroEnvNormaldatos, numeroEnvPersondatos] = await Promise.all([
        fetch('Controladores/consultas.php?accion=ingresosEnvNormal').then(res => res.json()),
        fetch('Controladores/consultas.php?accion=ingresosEnvPerson').then(res => res.json()),
        fetch('Controladores/consultas.php?accion=numeroEnvNormal').then(res => res.json()),
        fetch('Controladores/consultas.php?accion=numeroEnvPerson').then(res => res.json())
    ]);

    // grafico de ingresos por envios normales
    ingresosEnvNormalSeries.setData(ingresosEnvNormaldatos);
    // grafico de ingresos por envios personales
    ingresosEnvPersonSeries.setData(ingresosEnvPersondatos);
    // grafico de numero de envios normales
    numeroEnvNormalSeries.setData(numeroEnvNormaldatos);
    // grafico de numero de envios personales
    numeroEnvPersonSeries.setData(numeroEnvPersondatos);
}


//para cambiar el grafico de ingresos por envios normales de diario a semanal
function cambiarIngreEnvNormal(semanal = false){
    chartIngrEnvNormal.removeSeries(ingresosEnvNormalSeries);
    ingresosEnvNormalSeries = chartIngrEnvNormal.addLineSeries({
        color: 'rgba(76, 175, 80, 1)',
        lineWidth: 2,
    });
    if(semanal){
        elementoID('ingresosDia').classList.remove('active'); elementoID('ingresosSemana').classList.add('active');
        fetch('Controladores/consultas.php?accion=ingresosEnvNormal&semanal=true').then(res => res.json()).then(datos => ingresosEnvNormalSeries.setData(datos));
    }else{
        elementoID('ingresosSemana').classList.remove('active'); elementoID('ingresosDia').classList.add('active');
        fetch('Controladores/consultas.php?accion=ingresosEnvNormal').then(res => res.json()).then(datos => ingresosEnvNormalSeries.setData(datos));
    }
}
//para cambiar el grafico de ingresos por envios personalizados de diario a semanal
function cambiarIngreEnvPerson(semanal = false){
    chartIngrEnvPerson.removeSeries(ingresosEnvPersonSeries);
    ingresosEnvPersonSeries = chartIngrEnvPerson.addLineSeries({
        color: 'rgba(76, 175, 80, 1)',
        lineWidth: 2,
    });
    if(semanal){
        elementoID('ingresosDia2').classList.remove('active'); elementoID('ingresosSemana2').classList.add('active');
        fetch('Controladores/consultas.php?accion=ingresosEnvPerson&semanal=true').then(res => res.json()).then(datos => ingresosEnvPersonSeries.setData(datos));
    }else{
        elementoID('ingresosSemana2').classList.remove('active'); elementoID('ingresosDia2').classList.add('active');
        fetch('Controladores/consultas.php?accion=ingresosEnvPerson').then(res => res.json()).then(datos => ingresosEnvPersonSeries.setData(datos));
    }
}
//para cambiar el grafico de numero de envios normales de diario a semanal
function cambiarNumEnvNormal(semanal = false){
    chartNumEnvNormal.removeSeries(numeroEnvNormalSeries);
    numeroEnvNormalSeries = chartNumEnvNormal.addLineSeries({
        color: 'rgba(76, 175, 80, 1)',
        lineWidth: 2,
    });
    if(semanal){
        elementoID('numeroDia').classList.remove('active'); elementoID('numeroSemana').classList.add('active');
        fetch('Controladores/consultas.php?accion=numeroEnvNormal&semanal=true').then(res => res.json()).then(datos => numeroEnvNormalSeries.setData(datos));
    }else{
        elementoID('numeroSemana').classList.remove('active'); elementoID('numeroDia').classList.add('active');
        fetch('Controladores/consultas.php?accion=numeroEnvNormal').then(res => res.json()).then(datos => numeroEnvNormalSeries.setData(datos));
    }
}
//para cambiar el grafico de numero de envios personalizados de diario a semanal
function cambiarNumEnvPerson(semanal = false){
    chartNumEnvPerson.removeSeries(numeroEnvPersonSeries);
    numeroEnvPersonSeries = chartNumEnvPerson.addLineSeries({
        color: 'rgba(76, 175, 80, 1)',
        lineWidth: 2,
    });
    if(semanal){
        elementoID('numeroDia2').classList.remove('active'); elementoID('numeroSemana2').classList.add('active');
        fetch('Controladores/consultas.php?accion=numeroEnvPerson&semanal=true').then(res => res.json()).then(datos => numeroEnvPersonSeries.setData(datos));
    }else{
        elementoID('numeroSemana2').classList.remove('active'); elementoID('numeroDia2').classList.add('active');
        fetch('Controladores/consultas.php?accion=numeroEnvPerson').then(res => res.json()).then(datos => numeroEnvPersonSeries.setData(datos));
    }
}

// ejecutamos la funcion para que los graficos ocupen todo el espacio disponible que tengan
darTamano();
// cuando se redimensiona la ventana se redimensionan los graficos
window.onresize = darTamano;

function darTamano() {
    const { width, height } = ingresosEnvNormal.getBoundingClientRect();
    chartIngrEnvNormal.resize(width, height)
    chartIngrEnvPerson.resize(width, height)
    chartNumEnvNormal.resize(width, height)
    chartNumEnvPerson.resize(width, height)
}
