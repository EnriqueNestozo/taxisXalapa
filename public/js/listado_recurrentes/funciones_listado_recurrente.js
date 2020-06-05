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
            {data: "direccionDestino", name: 'direccionDestino', defaultContent: ''},
            {data: "unidad.numero", name:"unidad.numero", defaultContent:''},
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
            $('#direccionSelect').empty();
            html = '';
            html = html + '<option value="" selected style="min-width: 300px;"> Seleccione una direccion...</option>'
            $('#direccionSelect').append(html);
            // console.log("success registro");
            cargarListado();
            cargarListadoRegistros();
            obtenerListadoPersonas();
            if($('#idRegistro').val() == ''){
                swal({
                    title: 'Registro realizado correctamente',
                    text: "¿Quiere añadir el destino?",
                    type: 'success',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    cancelButtonText: 'No',
                    confirmButtonText: 'Si',
                    buttonsStyling: false
                }).then(function(confirmation) {
                    // console.log(confirmation);
                    if (confirmation['dismiss'] != 'cancel') {
                        agregarDestino(result['id'],result['cliente_id']);
                        $('#registroDestinoBtn').show();
                        $('#eliminarDestinoBtn').hide();
                    }
                });
            }else{
                md.showNotification('bottom','right','success','Registro modificado correctamente');
            }
            $('#registroDiarioForm').trigger("reset");
            $('#modalRegistroDiario').modal('hide');
            // $('#personaSelect').prop('disabled',false);
            // $('#municipioSelect').prop('disabled',false);
            // $('#persona').prop('disabled',false);
            // $('#municipio').prop('disabled',false);
            $('#idRegistro').val('');
            $('#idCliente').val('');
        },
        error: function(result){
            console.log(result);
            $("#registroDiarioBtn").html("Registrar");
            $("#registroDiarioBtn").prop('disabled', false);
            md.showNotification('bottom','right','danger','Ha ocurrido un error al crear el registro');
        }
    });
}

function editarRegistro(id_registro){
    var data = sessionStorage.getItem('token');
    $.get({
        url: routeBase+"/api/registros-diarios/"+id_registro,
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
        $('#hora').val(registro['hora']);
        $('#personaSelect').val(registro['cliente_id']).trigger('change');
        $('#personaSelect').prop('disabled',true);
        $('#persona').prop('disabled',true);
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
            console.log("unidad "+registro['unidad_id']);
            $('#clave').val(registro['unidad_id']).trigger('change');
        }else{
            $('#clave').val('').trigger('change');
        }
        $('#idRegistro').val(registro['id']);
        $('#idCliente').val(registro['cliente_id']);
        },
        error: function(result){
            console.log(result);
        }
    });
    $('#modalRegistroDiario').modal('show');
}

function eliminarRegistro(id_registro){
    var data = sessionStorage.getItem('token');
    swal({
        title: '¿Esta seguro que desea cancelar el registro?',
        text: "El registro se cancelará de manera permanente!",
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
            url: rutaBorradoRegistros,
            data:{
                idRegistro: id_registro,
            },   
            dataType: 'json',
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer '+data,
            },
            success: function( result ) {
                md.showNotification('bottom','right','success','Registro cancelado correctamente');
                cargarListadoRegistros();
            },
            error: function(result){
                console.log(result);
                md.showNotification('bottom','right','danger','Ha ocurrido un error al eliminar el registro');
            }
            });
        }
    });

}

//Funciones para destino

function validarDatosDestino(){
    let datosErroneos = 0;
    $("#registroDestinoBtn").html("Cargando...");
    $("#registroDestinoBtn").prop('disabled', true);
    limpiarErroresDestino();
    if( $('#direccionDestinoSelect').val() =='' ){
        if(
            ($('#personaDestinoSelect').val() == null  ) || 
            ( $('#municipioDestino').val() =='' && $('#municipioDestinoSelect').val() == '' ) || 
            ( $('#localidadDestino').val() =='' && $('#localidadDestinoSelect').val() == '' ) || 
            ( $('#coloniaDestino').val() =='' && $('#coloniaDestinoSelect').val() == '' ) ){
            marcarErroresDestino();
            datosErroneos = 1;
        }
    }
    
    return datosErroneos;
}

function limpiarErroresDestino(){
    $('#personaDestinoDiv').removeClass('has-danger');
    $('#personaDestino-error').hide();
    $('#municipioDestinoDiv').removeClass('has-danger');
    $('#municipioDestino-error').hide();
    $('#calleDestinoDiv').removeClass('has-danger');
    $('#calleDestino-error').hide();
    // $('#referenciaDiv').removeClass('has-danger');
    // $('#referencia-error').hide();
    
}

function marcarErroresDestino(){
    if( $('#municipioDestino').val() =='' && $('#municipioDestinoSelect').val() == ''  ){
        $('#municipioDestinoDiv').addClass('has-danger');
        $('#municipioDestino-error').show();
    }
    if( $('#localidadDestino').val() =='' && $('#localidadDestinoSelect').val() == ''  ){
        $('#localidadDestinoDiv').addClass('has-danger');
        $('#localidadDestino-error').show();
    }
    if( $('#coloniaDestino').val() =='' && $('#coloniaDestinoSelect').val() == ''  ){
        $('#coloniaDestinoDiv').addClass('has-danger');
        $('#coloniaDestino-error').show();
    }
    // if( $('#calleDestino').val()=='' ){
    //   $('#calleDestinoDiv').addClass('has-danger');
    //   $('#calleDestino-error').show();
    // }
}

function agregarDestino(idRegistro,idCliente){
    $('#idRegistroDestino').val(idRegistro);
    $('#modalDestino').modal('show');
    $('#personaDestinoSelect').val(idCliente).trigger('change');
    $('#personaDestinoSelect').prop('disabled',true);
}

function registrarDestino(){
    if(validarDatosDestino() == 0 ){
        // console.log("registra");
        var data = sessionStorage.getItem('token');
        var arrayDeDatos = $("#destinoForm").serializeArray();
        arrayDeDatos.push({name:'idUser', value:sessionStorage.getItem('user')});

        $.post({
            url: rutaCrearRegistroDestino,
            data: arrayDeDatos,
            dataType: 'json',
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer '+data,
            },
            success: function( result ) {
                $("#registroDestinoBtn").html("Registrar");
                $("#registroDestinoBtn").prop('disabled', false);
                $('#destinoForm').trigger("reset");
                $('#modalDestino').modal('hide');

                cargarListadoRegistros();
                obtenerListadoPersonas();
                $('#personaDestinoSelect').prop('disabled',false);
                $('#municipioDestinoSelect').prop('disabled',false);
                $('#municipioDestino').prop('disabled',false);
                $('#idRegistro').val('');
                $('#idCliente').val('');
                md.showNotification('bottom','right','success','Destino creado correctamente');
            },
            error: function(result){
                console.log(result);
                $("#registroDestinoBtn").html("Registrar");
                $("#registroDestinoBtn").prop('disabled', false);
                md.showNotification('bottom','right','danger','Ha ocurrido un error al crear el destino');
            }
        });
    }else{
        $("#registroDestinoBtn").html("Registrar");
        $("#registroDestinoBtn").prop('disabled', false);
    }
}

function mostrarDestino(idDireccionDestino){
    $('#modalDestino').modal('show');
    $('#idRegistroDestino').val(idDireccionDestino['id']);
    $('#idDireccionDestino').val(idDireccionDestino['direccion_destino_id']).trigger('change');
    $('#personaDestinoSelect').val(idDireccionDestino['direccion_destino']['cliente_id']).trigger('change');
    $('#personaDestinoSelect').prop('disabled',true);
    setTimeout(function(){
        $('#direccionDestinoSelect').val(idDireccionDestino['direccion_destino']['id']).trigger('change');
    },1000);
    $('#coloniaDestinoSelect').val(idDireccionDestino['direccion_destino']['colonia_id']).trigger('change');
    $('#calleDestino').val(idDireccionDestino['direccion_destino']['calle']);
    $('#entre_callesDestino').val(idDireccionDestino['direccion_destino']['entre_calles']);
    $('#referenciaDestino').val(idDireccionDestino['direccion_destino']['referencia']);
    $('#eliminarDestinoBtn').show();
    $('#registroDestinoBtn').hide();
}

function eliminarDestino(){
    swal({
        title: '¿Esta seguro que desea eliminar el destino?',
        text: "El destino se eliminará de manera permanente!",
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
                url: rutaBorradoDestino,
                data:{
                    idRegistro: $('#idRegistroDestino').val(),
                },   
                dataType: 'json',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer '+sessionStorage.getItem('token'),
                },
                success: function( result ) {
                    md.showNotification('bottom','right','success','Destino eliminado correctamente');
                    cargarListadoRegistros();
                    $('#modalDestino').modal('hide');
                },
                error: function(result){
                    console.log(result);
                    md.showNotification('bottom','right','danger','Ha ocurrido un error al eliminar el destino');
                }
            });
        }
    });
}

function obtenerListadoDireccionesDestino(){
    var data = sessionStorage.getItem('token');
    var personaid = $('#personaDestinoSelect').val();
    $('#direccionDestinoSelect').empty();
    $.get({
        url: routeBase+"/api/get-direcciones-destino/"+personaid,
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
                if(result[index].calle !=null){
                    calle = result[index].calle+ ', ';
                }else{
                    calle = '';
                }
                html += '>'+calle+'col. '+result[0].colonia.asentamiento+', '+(result[0].localidad.nombre).toLowerCase() +'</option>';
            }
            $('#direccionDestinoSelect').append(html);
        },
        error: function(result){
            console.log(result);
        }
    });
}