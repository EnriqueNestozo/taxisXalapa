function cargarListado(){
    var data = sessionStorage.getItem('token');
    $('#listado').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        destroy: true,
        language: {
        url: routeBase+'/DataTables/DataTable_Spanish.json'
        },
        ajax: {
        url: rutaListadoServicios,
        type: "GET",
        dataType: 'json',
        headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer '+data,
        }
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: "cliente.nombre", name: 'cliente.nombre'},
            {data: "direccionCompleta", name: 'direccionCompleta'},
            {data: 'user.name'},
            {data: 'action', name:'action'}
        ]
    });
}

function desplegarModalServicio(){
    $('#personaSelect').val('').trigger('change');
    $('#modalRegistroServicio').modal("show");
}

function obtenerListadoDirecciones(){
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

function validarDatos(){
    let datosErroneos = 0;
    $("#registroDiarioBtn").html("Cargando...");
    $("#registroDiarioBtn").prop('disabled', true);
    limpiarErrores();
    if( $('#isRecurrente').is(':checked') ){
        if( $('#lunesCheck').is(':checked') ){
            if ($('#lunes').val() =='' ){
                datosErroneos = 1;
            }
        }
        if( $('#martesCheck').is(':checked') ){
            if ($('#martes').val() =='' ){
                datosErroneos = 1;
            }
        }
        if( $('#miercolesCheck').is(':checked') ){
            if ($('#miercoles').val() =='' ){
                datosErroneos = 1;
            }
        }
        if( $('#juevesCheck').is(':checked') ){
            if ($('#jueves').val() =='' ){
                datosErroneos = 1;
            }
        }
        if( $('#viernesCheck').is(':checked') ){
            if ($('#viernes').val() =='' ){
                datosErroneos = 1;
            }
        }
        if( $('#sabadoCheck').is(':checked') ){
            if ($('#sabado').val() =='' ){
                datosErroneos = 1;
            }
        }
        if( $('#domingoCheck').is(':checked') ){
            if ($('#domingo').val() =='' ){
                datosErroneos = 1;
            }
        }
        if(
            ( $('#persona').val() =='' && $('#personaSelect').val() == null  ) || 
            ( $('#municipio').val() =='' && $('#municipioSelect').val() == null ) || 
            ( $('#localidad').val() =='' && $('#localidadSelect').val() == null ) || 
            ( $('#colonia').val() =='' && $('#coloniaSelect').val() == null ) ||
            $('#calle').val() == '' || 
            ( $('#telefono').val() == '' && $('#celular').val()=='')  ){
            marcarErrores();
            console.log("faltan datos");
            datosErroneos = 1;
        }
    }else{
        if(
            $('#hora').val() =='' || 
            ( $('#persona').val() =='' && $('#personaSelect').val() == null  ) || 
            ( $('#municipio').val() =='' && $('#municipioSelect').val() == null ) || 
            ( $('#localidad').val() =='' && $('#localidadSelect').val() == null ) || 
            ( $('#colonia').val() =='' && $('#coloniaSelect').val() == null ) ||
            $('#calle').val() == '' || 
            ( $('#telefono').val() == '' && $('#celular').val()=='')  ){
            marcarErrores();
            console.log("faltan datos");
            datosErroneos = 1;
        }
    }
    
    return datosErroneos;
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

function marcarErrores(){
    if($('#hora').val() ==''){
        $('#horaDiv').addClass(' has-danger');
        $('#hora-error').show();
    }
    if( $('#persona').val() =='' && $('#personaSelect').val() == '' ){
        $('#personaDiv').addClass('has-danger');
        $('#persona-error').show();
    }
    if( $('#municipio').val() =='' && $('#municipioSelect').val() == ''  ){
        $('#municipioDiv').addClass('has-danger');
        $('#municipio-error').show();
    }
    if( $('#localidad').val() =='' && $('#localidadSelect').val() == ''  ){
        $('#localidadDiv').addClass('has-danger');
        $('#localidad-error').show();
    }
    if( $('#colonia').val() =='' && $('#coloniaSelect').val() == ''  ){
        $('#coloniaDiv').addClass('has-danger');
        $('#colonia-error').show();
    }
    if( $('#calle').val()=='' ){
      $('#calleDiv').addClass('has-danger');
      $('#calle-error').show();
    }
    // if( $('#referencia').val() =='' ){
    //   $('#referenciaDiv').addClass('has-danger');
    //   $('#referencia-error').show();
    // }
    if( $('#telefono').val() == '' && $('#celular').val() == '' ){
        $('#telefonoDiv').addClass('has-danger');
        $('#telefono-error').show();
        $('#celularDiv').addClass('has-danger');
        $('#celular-error').show();
    }
    // if( $('#celular').val() == '' ){
    //   $('#celularDiv').addClass('has-danger');
    //   $('#celular-error').show();
    // }
}

function registrarServicio(){
    if(validarDatos() == 0 ){
        var data = sessionStorage.getItem('token');
        var arrayDeDatos = $("#registroDiarioForm").serializeArray();
        arrayDeDatos.push({name:'idUser', value:sessionStorage.getItem('user')});

        $.post({
        url: rutaCrearServicio,
        data: arrayDeDatos,
        dataType: 'json',
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer '+data,
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
            obtenerListadoPersonas();
            $('#personaSelect').prop('disabled',false);
            $('#municipioSelect').prop('disabled',false);
            $('#persona').prop('disabled',false);
            $('#municipio').prop('disabled',false);
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
    }else{
        $("#registroDiarioBtn").html("Registrar");
        $("#registroDiarioBtn").prop('disabled', false);
    }
}

function editarServicio(id_registro){
    var data = sessionStorage.getItem('token');
    $.get({
        url: routeBase+"/api/servicio/"+id_registro,
        dataType: 'json',   
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer '+data,
        },
        success: function( result ) {
        let registro = result[0];
        let clientes = result[1];
        let direcciones = result[2];
        let unidades = result[3];
        // $('#hora').val(registro['hora']);
        $('#personaSelect').val(registro['cliente_id']).trigger('change');
        $('#personaSelect').prop('disabled',true);
        $('#persona').prop('disabled',true);
        // console.log(registro['horarios']);
        registro['horarios'].forEach(element => {
            if(element['dia']=="Lunes"){
                $('#lunesCheck').prop('checked',true).trigger('change');
                $('#lunes').val(element['hora']);
            }
            if(element['dia']=="Martes"){
                $('#martesCheck').prop('checked',true).trigger('change');
                $('#martes').val(element['hora']);
            }
            if(element['dia']=="Miercoles"){
                $('#miercolesCheck').prop('checked',true).trigger('change');
                $('#miercoles').val(element['hora']);
            }
            if(element['dia']=="Jueves"){
                $('#juevesCheck').prop('checked',true).trigger('change');
                $('#jueves').val(element['hora']);
            }
            if(element['dia']=="Viernes"){
                $('#viernesCheck').prop('checked',true).trigger('change');
                $('#viernes').val(element['hora']);
            }
            if(element['dia']=="Sabado"){
                $('#sabadoCheck').prop('checked',true).trigger('change');
                $('#sabado').val(element['hora']);
            }
            if(element['dia']=="Domingo"){
                $('#domingoCheck').prop('checked',true).trigger('change');
                $('#domingo').val(element['hora']);
            }
        });
        setTimeout(function(){
            $('#direccionSelect').val(registro['direccion_id']).trigger('change');
            var objeto = direcciones.filter(obj => {
                return obj['id'] == $('#direccionSelect').val()
            });
            console.log(objeto[0]['calle']);
            $('#referencia').val(objeto[0]['referencia']);
            $('#entre_calles').val(objeto[0]['entre_calles']);
            
        }, 1000);
        
        $('#telefono').val(clientes['telefono_fijo']).trigger('change');
        $('#celular').val(clientes['celular']).trigger('change');
        if(registro['unidad_id']!=null){
            $('#unidad').val(registro['unidad_id']).trigger('change');
        }
        $('#idRegistro').val(registro['id']);
        $('#idCliente').val(registro['cliente_id']);
        },
        error: function(result){
            console.log(result);
        }
    });
    $('#modalRegistroServicio').modal('show');
}

function eliminarServicio(id_registro){
    var data = sessionStorage.getItem('token');
    swal({
        title: '¿Esta seguro que desea eliminar el servicio?',
        text: "El servicio se eliminará de manera permanente!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        cancelButtonText: 'Cancelar!',
        confirmButtonText: 'Eliminar!',
        buttonsStyling: false
        }).then(function(confirmation) {
        // console.log(confirmation);
        if (confirmation['dismiss'] != 'cancel') {
            $.post({
            url: rutaBorradoServicios,
            data:{
                idServicio: id_registro,
            },   
            dataType: 'json',
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer '+data,
            },
            success: function( result ) {
                md.showNotification('bottom','right','success','Servicio eliminado correctamente');
                cargarListado();
            },
            error: function(result){
                console.log(result);
                md.showNotification('bottom','right','danger','Ha ocurrido un error al eliminar el servicio');
            }
            });
        }
    });

}