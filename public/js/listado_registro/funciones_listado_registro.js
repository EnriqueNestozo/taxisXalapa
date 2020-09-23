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
            url: routeBase+'/api/registros-diarios-list/0',
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
            {data: "cliente", 
                render: function (data){
                    if(data.nombre){
                        return data.nombre
                    }else{
                        return data.telefono_fijo
                    }
                }
            },
            {data: "direccionCompleta", name: 'direccionCompleta'},
            {data: "direccionDestino", name: 'direccionDestino', defaultContent: ''},
            {data: "unidad.numero", name:"unidad.numero", defaultContent:''},
            {data: 'estatus', defaultContent:' '},
            {data: 'user.name'},
            {data: 'action', name:'action'}
        ],order: [ [0, 'desc'] ]
    });
}

function obtenerListadoDirecciones(){
    var data = sessionStorage.getItem('token');
    var personaid = $('#busquedaSelect').val();
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
                html += (result[index].calle)? '>'+result[index].calle+', ' : '>';
                html += (result[index].colonia)?'col. '+result[0].colonia.asentamiento+', ' : '';
                html +=(result[0].localidad.nombre).toLowerCase() +'</option>';
            }
            $('#direccionSelect').append(html);
        },
        error: function(result){
            console.log(result);
        }
    });
}

function obtenerListadoDireccionesDestino(){
    var data = sessionStorage.getItem('token');
    var personaid = $('#busquedaDestinoSelect').val();
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
        $('#busquedaSelect').val(registro['cliente_id']).trigger('change');
        $('#busquedaSelect').prop('disabled',true);
        $('#persona').prop('disabled',true);
        $('#telefono').prop('disabled',true);
        setTimeout(function(){
            $('#direccionSelect').val(registro['direccion_id']).trigger('change');
            var objeto = direcciones.filter(obj => {
                return obj['id'] == $('#direccionSelect').val()
            });
            console.log(objeto[0]);
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

function desplegarModalRegistro(){
    obtenerListadoPersonas();
    cargarSelectsMunicipio();
    $('#persona').prop('disabled',false);
    $('#persona').trigger('change');

    $('#telefono').prop('disabled',false);
    $('#telefono').trigger('change');
    var fecha = new Date();
    var minutos = "00";
    var horas = "00";
    if(fecha.getMinutes() < 10){
        minutos = "0"+ fecha.getMinutes();
    }else{
        minutos = fecha.getMinutes();
    }
    if(fecha.getHours() < 10){
        horas = "0"+ fecha.getHours();
    }else{
        horas = fecha.getHours();
    }
    var horaActual = horas + ":" + minutos;
    $('#hora').val(horaActual);
    console.log($('#hora').val(),"aqui",horaActual);
    $('#busquedaSelect').val('').trigger('change');
    $('#modalRegistroDiario').modal("show");
}

function registrarViaje(){
    if(validarDatos() == 0 ){
        // console.log("registra");
        var data = sessionStorage.getItem('token');
        var arrayDeDatos = $("#registroDiarioForm").serializeArray();
        arrayDeDatos.push({name:'idUser', value:sessionStorage.getItem('user')});

        $.post({
        url: rutaCrearRegistroDiario,
        data: arrayDeDatos,
        dataType: 'json',
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer '+data,
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
            obtenerListadoPersonas();
            $('#busquedaSelect').prop('disabled',false);
            $('#municipioSelect').prop('disabled',false);
            $('#persona').prop('disabled',false);
            $('#municipio').prop('disabled',false);
            console.log($('#idRegistro').val());
            
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
    }else{
        $("#registroDiarioBtn").html("Registrar");
        $("#registroDiarioBtn").prop('disabled', false);
    }
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
            ( $('#persona').val() =='' && $('#busquedaSelect').val() == null && $('#telefono').val() == '') || 
            ( $('#municipio').val() =='' && $('#municipioSelect').val() == null ) || 
            ( $('#localidad').val() =='' && $('#localidadSelect').val() == null ) || 
            ( $('#colonia').val() =='' && $('#coloniaSelect').val() == null )  ){
            marcarErrores();
            console.log("faltan datos");
            datosErroneos = 1;
        }
    }else{
        if($('#direccionSelect').val()==''){
            if(
                $('#hora').val() =='' || 
                ( $('#persona').val() =='' && $('#busquedaSelect').val() == '' && $('#telefono').val() == '') || 
                ( $('#municipio').val() =='' && $('#municipioSelect').val() == '' ) || 
                ( $('#localidad').val() =='' && $('#localidadSelect').val() == '' ) ){
                marcarErrores();
                datosErroneos = 1;
            }
        }
    }
    return datosErroneos;
}
function validarDatosDestino(){
    let datosErroneos = 0;
    $("#registroDestinoBtn").html("Cargando...");
    $("#registroDestinoBtn").prop('disabled', true);
    limpiarErroresDestino();
    if( $('#direccionDestinoSelect').val() =='' ){
        if(
            ($('#busquedaDestinoSelect').val() == null  ) || 
            ( $('#municipioDestino').val() =='' && $('#municipioDestinoSelect').val() == '' ) || 
            ( $('#localidadDestino').val() =='' && $('#localidadDestinoSelect').val() == '' ) ){
            marcarErroresDestino();
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
    $('#busquedaDiv').removeClass('has-danger');
    $('#busqueda-error').hide();
    $('#municipioDiv').removeClass('has-danger');
    $('#municipio-error').hide();
    // $('#calleDiv').removeClass('has-danger');
    // $('#calle-error').hide();
    // $('#referenciaDiv').removeClass('has-danger');
    // $('#referencia-error').hide();
    $('#telefonoDiv').removeClass('has-danger');
    $('#telefono-error').hide();
    $('#celularDiv').removeClass('has-danger');
    $('#celular-error').hide();
}

function limpiarErroresDestino(){
    $('#busquedaDestinoDiv').removeClass('has-danger');
    $('#busquedaDestino-error').hide();
    $('#municipioDestinoDiv').removeClass('has-danger');
    $('#municipioDestino-error').hide();
    // $('#calleDestinoDiv').removeClass('has-danger');
    // $('#calleDestino-error').hide();
    // $('#referenciaDiv').removeClass('has-danger');
    // $('#referencia-error').hide();
    
}

function marcarErrores(){
    if($('#hora').val() ==''){
        $('#horaDiv').addClass(' has-danger');
        $('#hora-error').show();
    }
    if( $('#persona').val() =='' && $('#busquedaSelect').val() == '' && $('#telefono').val() == '' ){
        $('#personaDiv').addClass('has-danger');
        $('#persona-error').show();
        $('#busquedaDiv').addClass('has-danger');
        $('#busqueda-error').show();
        $('#telefonoDiv').addClass('has-danger');
        $('#telefono-error').show();
    }
    if( $('#municipio').val() =='' && $('#municipioSelect').val() == ''  ){
        $('#municipioDiv').addClass('has-danger');
        $('#municipio-error').show();
    }
    if( $('#localidad').val() =='' && $('#localidadSelect').val() == ''  ){
        $('#localidadDiv').addClass('has-danger');
        $('#localidad-error').show();
    }
    // if( $('#colonia').val() =='' && $('#coloniaSelect').val() == ''  ){
    //     $('#coloniaDiv').addClass('has-danger');
    //     $('#colonia-error').show();
    // }
    // if( $('#calle').val()=='' ){
    //   $('#calleDiv').addClass('has-danger');
    //   $('#calle-error').show();
    // }
    // if( $('#referencia').val() =='' ){
    //   $('#referenciaDiv').addClass('has-danger');
    //   $('#referencia-error').show();
    // }
    // if( $('#telefono').val() == '' && $('#celular').val() == '' ){
    //     $('#telefonoDiv').addClass('has-danger');
    //     $('#telefono-error').show();
    //     $('#celularDiv').addClass('has-danger');
    //     $('#celular-error').show();
    // }
    // if( $('#celular').val() == '' ){
    //   $('#celularDiv').addClass('has-danger');
    //   $('#celular-error').show();
    // }
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
    // if( $('#coloniaDestino').val() =='' && $('#coloniaDestinoSelect').val() == ''  ){
    //     $('#coloniaDestinoDiv').addClass('has-danger');
    //     $('#coloniaDestino-error').show();
    // }
    // if( $('#calleDestino').val()=='' ){
    //   $('#calleDestinoDiv').addClass('has-danger');
    //   $('#calleDestino-error').show();
    // }
}

function agregarDestino(idRegistro,idCliente){
    $('#idRegistroDestino').val(idRegistro);
    $('#modalDestino').modal('show');
    $('#busquedaDestinoSelect').val(idCliente).trigger('change');
    $('#busquedaDestinoSelect').prop('disabled',true);
}

/*
*   Funciones para destino
*/

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

                cargarListado();
                obtenerListadoPersonas();
                $('#busquedaDestinoSelect').prop('disabled',false);
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
    $('#busquedaDestinoSelect').val(idDireccionDestino['direccion_destino']['cliente_id']).trigger('change');
    $('#busquedaDestinoSelect').prop('disabled',true);
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
                    cargarListado();
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