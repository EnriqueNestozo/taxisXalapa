function verificarExistenciasDeServicios() {
    $.get({
        url:  routeBase+'/api/servicios-pendientes',
        dataType: 'json',
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer '+sessionStorage.getItem('token'),
        },
        success: function( result ) {
            console.log(result);
            md.showNotification('bottom','right','info','Hay un servicio pendiente sin asignar en 1 hora.');
        },
        error: function(result){
            console.log(result);
        }
    });
    // md.showNotification('bottom','right','info','Hay un servicio pendiente sin asignar en 1 hora.');
    // setTimeout(verificarExistenciasDeServicios, 15000);
}

function cargarSelectsMunicipio(){
    $.when( 
        $.ajax( rutaListadoMunicipios ))
        .done(function ( v1) {
        $('#municipioSelect').select2({data:v1});
        $('#municipioSelect').val(87).trigger('change');
    });
}

function obtenerListadoPersonas(){
    var data = sessionStorage.getItem('token');
    $.get({
        url: rutaListadoClientes,
        dataType: 'json',
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer '+data,
        },
        success: function( result ) {
            $('#personaSelect').empty();
            html = '';
            html = html + '<option value="" selected style="min-width: 300px;"> Seleccione una persona...</option>'
            for (let index = 0; index < result.length; index++) {
            html += '<option ';
            html += ' value="'+result[index].id+'" ';
            html += '>'+result[index].nombre+'</option>';
            }
            $('#personaSelect').append(html);
        },
        error: function(result){
            console.log(result);
        }
    });
}

function obtenerListadoClavesTaxis(){
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
            html = html + '<option value="" selected style="min-width: 300px;"> Seleccione una clave...</option>'
            for (let index = 0; index < result.length; index++) {
            html += '<option ';
            html += ' value="'+result[index].id+'" ';
            html += '>'+result[index].numero_economico+'</option>';
            }
            $('#clave').append(html);
        },
        error: function(result){
            console.log(result);
        }
    });
}