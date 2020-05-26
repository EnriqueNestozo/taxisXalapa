var fecha_inicio = '';
var fecha_fin = '';
$(document).ready(function() {
    moment.locale('es');   
    md.initFormExtendedDatetimepickers();
    // $('#tablaReporteMensual').hide();
    $('#tablaReportePorTaxi').hide();
    
    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        $('#reportrange span').html(start.format('D/MM/YYYY') + ' - ' + end.format('D/MM/YYYY'));
        fecha_inicio = start.format('YYYY-MM-D');
        fecha_fin = end.format('YYYY-MM-D');
    }

    $('.reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        locale:{
            "applyLabel": "Aplicar",
            "cancelLabel": "Cancelar",
            "fromLabel": "Desde",
            "toLabel": "Hasta",
            "customRangeLabel": "Personalizado",
            "daysOfWeek": [
            "Dom",
            "Lu",
            "Mar",
            "Mie",
            "Jue",
            "Vie",
            "Sa"
            ],
            "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octobre",
            "Noviembre",
            "Diciembre"
            ],
            "firstDay": 2
        },
        ranges: {
            'Hoy': [moment(), moment()],
            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
            'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
            'Este mes': [moment().startOf('month'), moment().endOf('month')],
            'El mes pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    },cb );

    //     function(start, end, label) {
    //   console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
    // }
    cb(start, end);


    obtenerListadoTaxis();

    $("#opcionesAvanzadasTexto").click(function () {
        if($("#Fader").hasClass("slideup")){
            $("#Fader").removeClass("slideup").addClass("slidedown");
            $('#opcionesFlecha').text("keyboard_arrow_up");
        }else{
            $("#Fader").removeClass("slidedown").addClass("slideup");
            $('#opcionesFlecha').text("keyboard_arrow_down");
        }
    });

    // md.initDashboardPageCharts();
});

// function desplegarReporteMensualServicios(){
//     $('#cardsReportes').hide();
//     $('#regresarAcardsReportes').show();
//     console.log("desplegado");
//     $('#tablaReporteMensual').show();
// }

// function desplegarReportePorTaxi(){
//     $('#cardsReportes').hide();
//     $('#regresarAcardsReportes').show();
//     $('#tablaReportePorTaxi').show();
//     obtenerListadoTaxis();
// }


function obtenerListadoTaxis(){
    var data = sessionStorage.getItem('token');
    $.get({
        url: rutaListadoClavesTaxis,
        dataType: 'json',
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer '+data,
        },
        success: function( result ) {
            $('#clave').empty();
            html = '';
            html = html + '<option value="todas" selected style="min-width: 300px;">Todas</option>'
            for (let index = 0; index < result.length; index++) {
                html += '<option ';
                html += ' value="'+result[index].id+'" ';
                html += '>'+result[index].numero+'</option>';
            }
            $('#clave').append(html);
        },
        error: function(result){
            console.log(result);
            //babyjinx
        }
    });
}

function desplegarReporteGeneral(){
    console.log("general");
}

function mostrarCardsReportes(){
    $('#cardsReportes').show();
    $('#regresarAcardsReportes').hide();
    $('#tablaReporteMensual').hide();
    $('#tablaReportePorTaxi').hide();
}

function buscarDatos(){
    // $('#tablaReporteMensual').show();
    $('#myTable1').DataTable( {
        processing: true,
        serverSide: true,
        searching: true,
        destroy: true,
        language: {
            url: routeBase+'/DataTables/DataTable_Spanish.json'
        },
        dom: 'Bfrtip',
        buttons: [
            'copy', 'excel', 'pdf',
        ],
        ajax: {
            url: routeBase+'/api/reporte-registros',
            type: "GET",
            dataType: 'json',
            data:{
                fecha_i: fecha_inicio,
                fecha_f: fecha_fin,
                tipo_servicio: $('#tipo_servicio').val(),
                base: $('#base').val(),
                unidad: $('#clave').val()
            },
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer '+sessionStorage.getItem('token'),
            }
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'unidad.base', name: 'unidad.base', defaultContent:''},
            {data: 'hora', name: 'hora'},
            {data: "cliente.nombre", name: 'cliente.nombre'},
            {data: "direccionCompleta", name: 'direccionCompleta'},
            {data: "unidad.numero", name:"unidad.numero", defaultContent:' '},
            {data: 'estatus'},
            {data: 'user.name'},
            {data: 'tipo_registro'}
        ]
    } );
}

function buscarDatosTaxis(){
    $.get({
        url: routeBase+"/api/reporte-corte-taxi",
        dataType: 'json',
        data:{
            fecha_i: fecha_inicio,
            fecha_f: fecha_fin,
            tipo_servicio: $('#turno').val(),
            base: $('#baseReporteTaxis').val(),
            unidad: $('#clave').val()
        },
        headers:{
            'Accept': 'application/json',
            'Authorization': 'Bearer '+sessionStorage.getItem('token'),
        },
        success: function(result){
            console.log(result);
        },
        error: function(result){
            console.log(result);
        }
    });
    
    // $('#myTable1').DataTable( {
    //     processing: true,
    //     serverSide: true,
    //     searching: true,
    //     destroy: true,
    //     language: {
    //         url: routeBase+'/DataTables/DataTable_Spanish.json'
    //     },
    //     dom: 'Bfrtip',
    //     buttons: [
    //         'copy', 'excel', 'pdf',
    //     ],
    //     ajax: {
    //         url: routeBase+'/api/reporte-registros',
    //         type: "GET",
    //         dataType: 'json',
    //         data:{
    //             fecha_i: fecha_inicio,
    //             fecha_f: fecha_fin,
    //             tipo_servicio: $('#tipo_servicio').val(),
    //             base: $('#base').val()
    //         },
    //         headers: {
    //             'Accept': 'application/json',
    //             'Authorization': 'Bearer '+sessionStorage.getItem('token'),
    //         }
    //     },
    //     columns: [
    //         {data: 'id', name: 'id'},
    //         {data: 'hora', name: 'hora'},
    //         {data: "cliente.nombre", name: 'cliente.nombre'},
    //         {data: "direccionCompleta", name: 'direccionCompleta'},
    //         {data: "unidad.numero", name:"unidad.numero", defaultContent:' '},
    //         {data: 'estatus'},
    //         {data: 'user.name'},
    //         {data: 'tipo_registro'}
    //     ]
    // } );
}