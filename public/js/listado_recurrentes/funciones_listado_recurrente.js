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
        ],
        order: [ [0, 'desc'] ]
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
            let direcciones = result[2];
            $('#idServicio').val(datosGenerales.id);
            $('#busquedaSelect').val(datosGenerales.cliente_id).trigger('change');
            $('#hora').val(datosGenerales.horarios[0].hora).trigger('change');
            $('#persona').val(datosPersona.nombre);
            $('#telefono').val(datosPersona.telefono_fijo);
            // $('#persona').prop('disabled',true);
            // $('#telefono').prop('disabled',true);
            $('#idCliente').val(datosPersona.id);
            $('#coloniaSelect').prop('disabled',true);
            $('#colonia').prop('disabled',true);
            let promesa = new Promise(function(resolve,reject){
                // $('#personaSelect').prop('disabled',true);
                if(datosGenerales.unidad_id !=null){
                    $('#clave').val(datosGenerales.unidad_id).trigger('change');
                }
                $('#direccionSelect').empty();
                html = '';
                html = html + '<option value="" selected style="min-width: 300px;"> Seleccione una dirección guardada...</option>'
                for (let index = 0; index < direcciones.length; index++) {
                    console.log(direcciones[index].localidad);
                    html += '<option ';
                    html += ' value="'+direcciones[index].id+'" ';
                    html += (direcciones[index].calle)? '>'+direcciones[index].calle+', ' : '>';
                    html += (direcciones[index].colonia)?'col. '+direcciones[index].colonia.asentamiento+', ' : '';
                    html +=(direcciones[index].localidad.nombre).toLowerCase() +'</option>';
                }
                $('#direccionSelect').append(html);
                resolve("done!");
            })
            promesa.then(function(resolve,reject){
                console.log("asodk, "+datosGenerales.direccion_id);
                $('#direccionSelect').val(datosGenerales.direccion_id).trigger('change');
            })
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
    // $('#celularDiv').removeClass('has-danger');
    // $('#celular-error').hide();
}

function registrarViaje(){
    if(validarDatos() == 0 ){
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
                    md.showNotification('bottom','right','success','Registro modificado correctamente');
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
            ( $('#localidad').val() =='' && $('#localidadSelect').val() == null )  ){
            marcarErrores();
            console.log("faltan datos");
            datosErroneos = 1;
        }
    }else{
        if($('#direccionSelect').val() == ''){
            if(
                $('#hora').val() =='' || 
                ( $('#persona').val() =='' && $('#busquedaSelect').val() == '' && $('#telefono').val() == '') || 
                ( $('#municipio').val() =='' && $('#municipioSelect').val() == null ) || 
                ( $('#localidad').val() =='' && $('#localidadSelect').val() == null ) ){
                marcarErrores();
                console.log("faltan datos");
                datosErroneos = 1;
            }
        }
    }
    
    return datosErroneos;
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
            
            //cargar datos persona
            let promesa = new Promise(function (resolve, reject){
                console.log(result);
                console.log(direcciones);
                $('#hora').val(registro['hora']);
                // $('#busquedaSelect').val(registro['cliente_id']).trigger('change');
                $('#busquedaSelect').prop('disabled',true);
                $('#persona').prop('disabled',false);
                $('#telefono').prop('disabled',false);
                $('#telefono').val(clientes['telefono_fijo']).trigger('change');
                $('#persona').val(clientes['nombre']).trigger('change');
                $('#direccionSelect').empty();
                html = '';
                html = html + '<option value="" selected style="min-width: 300px;"> Seleccione una dirección guardada...</option>'
                for (let index = 0; index < direcciones.length; index++) {
                    console.log("dir   ..."+direcciones[index]);
                    html += '<option ';
                    html += ' value="'+direcciones[index].id+'" ';
                    html += (direcciones[index].calle)? '>'+direcciones[index].calle+', ' : '>';
                    html += (direcciones[index].colonia)?'col. '+direcciones[index].colonia.asentamiento+', ' : '';
                    html +=(direcciones[index].localidad.nombre).toLowerCase() +'</option>';
                }
                $('#direccionSelect').append(html);
                resolve('done!');
            });
            
            promesa.then(function (resolve, reject){
                $('#direccionSelect').val(registro['direccion_id']).trigger('change');
                var objeto = direcciones.filter(obj => {
                    return obj['id'] == $('#direccionSelect').val()
                });
                // console.log("objeto ..."+objeto[0]);
                $('#referencia').val(objeto[0]['referencia']);
                $('#entre_calles').val(objeto[0]['entre_calles']);
            });
            $('#destino').val(registro['destino']);
            //Cargar unidad
            if(registro['unidad_id']!=null){
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
            ($('#busquedaDestinoSelect').val() == null  ) || 
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
    $('#busquedaDestinoDiv').removeClass('has-danger');
    $('#busquedaDestino-error').hide();
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
    $('#busquedaDestinoSelect').val(idCliente).trigger('change');
    $('#busquedaDestinoSelect').prop('disabled',true);
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