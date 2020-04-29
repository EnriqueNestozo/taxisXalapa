function cargarListado(){
    var data = sessionStorage.getItem('token');
    $('#listadoServiciosPendientes').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        destroy: true,
        language: {
        url: routeBase+'/DataTables/DataTable_Spanish.json'
        },
        ajax: {
        url: rutaListadoServiciosPendientes,
        type: "GET",
        dataType: 'json',
        headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer '+data,
        }
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'horarios[0].hora', name: 'horarios[0].hora'},
            {data: "cliente.nombre", name: 'cliente.nombre'},
            {data: "direccionCompleta", name: 'direccionCompleta'},
            {data: 'action', name:'action'}
        ]
    });
}

function cargarListadoRegistros(){
    var data = sessionStorage.getItem('token');
    $('#listadoRegistrosRecurrentes').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        destroy: true,
        language: {
            url: routeBase+'/DataTables/DataTable_Spanish.json'
        },
        ajax: {
            url: routeBase+'/api/registros-diarios-list/1' ,
            type: "GET",
            dataType: 'json',
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer '+data,
            }
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'hora', name: 'hora'},
            {data: "cliente.nombre", name: 'cliente.nombre'},
            {data: "direccionCompleta", name: 'direccionCompleta'},
            {data: "unidad.numero", name:"unidad.numero", defaultContent:' '},
            {data: 'estatus', defaultContent:' '},
            {data: 'user.name'},
            {data: 'action', name:'action'}
        ]
    });
}

function generarRegistro(idServicio){
    cargarDatos(idServicio);
    $('#modalRegistroDiario').modal('show');
}

function cancelarRegistro(idServicio){
    var data = sessionStorage.getItem('token');
    swal({
        title: '¿Esta seguro que desea cancelar el servicio de hoy?',
        text: "El servicio se cancelará de manera permanente!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        cancelButtonText: 'Cancelar!',
        confirmButtonText: 'Continuar!',
        buttonsStyling: false
        }).then(function(confirmation) {
        // console.log(confirmation);
        if (confirmation['dismiss'] != 'cancel') {
            $.post({
            url: rutaCancelarRegistro,
            data:{
                idServicio: idServicio,
            },   
            dataType: 'json',
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer '+data,
            },
            success: function( result ) {
                md.showNotification('bottom','right','success','Registro cancelado correctamente');
                cargarListado();
            },
            error: function(result){
                console.log(result);
                md.showNotification('bottom','right','danger','Ha ocurrido un error al eliminar el registro');
            }
            });
        }
    });
}

function cargarDatos(idServicio){
    $.get({
        url:  routeBase+'/api/servicio-actual/'+ idServicio,
        dataType: 'json',
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer '+sessionStorage.getItem('token'),
        },
        success: function( result ) {
            console.log(result);
            let datosGenerales = result[0];
            let datosPersona = result[1];
            $('#idServicio').val(datosGenerales.id);
            let direcciones = result[2][0];
            $('#personaSelect').val(datosGenerales.cliente_id).trigger('change');
            // $('#personaSelect').prop('disabled',true);
            $('#hora').val(datosGenerales.horarios[0].hora).trigger('change');
            if(datosGenerales.unidad_id !=null){
                $('#clave').val(datosGenerales.unidad_id).trigger('change');
            }
            setTimeout(function(){
                $('#direccionSelect').val(datosGenerales.direccion_id).trigger('change');
                // $('#direccionSelect').prop('disabled',true);
            },1000);
            let unidad = result[3];
        },
        error: function(result){
            console.log(result);
        }
    });
}

function obtenerListadoDirecciones(){
    console.log("esta en eso");
    var data = sessionStorage.getItem('token');
    var personaid = $('#personaSelect').val();
    $('#direccionSelect').empty();
    $.get({
        url: routeBase+"/api/get-direcciones/"+personaid,
        dataType: 'json',   
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer '+data,
        },
        success: function( result ) {
            html = '';
            html = html + '<option value="" selected style="min-width: 300px;"> Seleccione una dirección guardada...</option>'
            for (let index = 0; index < result.length; index++) {
                html += '<option ';
                html += ' value="'+result[index].id+'" ';
                html += '>'+result[index].calle+', col. '+result[0].colonia.asentamiento+', '+(result[0].localidad.nombre).toLowerCase() +'</option>';
            }
            $('#direccionSelect').append(html);
        },
        error: function(result){
            console.log(result);
        }
    });
}

function limpiarErrores(){
    $('#horaDiv').removeClass(' has-danger');
    $('#hora-error').hide();
    $('#personaDiv').removeClass('has-danger');
    $('#persona-error').hide();
    $('#municipioDiv').removeClass('has-danger');
    $('#municipio-error').hide();
    $('#calleDiv').removeClass('has-danger');
    $('#calle-error').hide();
    // $('#referenciaDiv').removeClass('has-danger');
    // $('#referencia-error').hide();
    $('#telefonoDiv').removeClass('has-danger');
    $('#telefono-error').hide();
    $('#celularDiv').removeClass('has-danger');
    $('#celular-error').hide();
}

function registrarViaje(){
    var arrayDeDatos = $("#registroDiarioForm").serializeArray();
    arrayDeDatos.push({name:'idUser', value:sessionStorage.getItem('user')});
    arrayDeDatos.push({name:'tipoRegistro', value:1});
    $.post({
        url: rutaCrearRegistroDiario,
        data: arrayDeDatos,
        dataType: 'json',
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer '+sessionStorage.getItem('token'),
        },
        success: function( result ) {
            $("#registroDiarioBtn").html("Registrar");
            $("#registroDiarioBtn").prop('disabled', false);
            $('#registroDiarioForm').trigger("reset");
            $('#modalRegistroDiario').modal('hide');
            $('#direccionSelect').empty();
            html = '';
            html = html + '<option value="" selected style="min-width: 300px;"> Seleccione una direccion...</option>'
            $('#direccionSelect').append(html);
            // console.log("success registro");
            cargarListado();
            cargarListadoRegistros();
            obtenerListadoPersonas();
            // $('#personaSelect').prop('disabled',false);
            // $('#municipioSelect').prop('disabled',false);
            // $('#persona').prop('disabled',false);
            // $('#municipio').prop('disabled',false);
            $('#idRegistro').val('');
            $('#idCliente').val('');
            md.showNotification('bottom','right','success','Registro creado correctamente');
        },
        error: function(result){
            console.log(result);
            $("#registroDiarioBtn").html("Registrar");
            $("#registroDiarioBtn").prop('disabled', false);
            md.showNotification('bottom','right','danger','Ha ocurrido un error al crear el registro');
        }
    });
}