function readURL(input,idpreview) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $("#"+idpreview)
                .attr('src', e.target.result)
                .width(250)
                .height(250);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>Turno:</td>'+
            '<td>'+d.turno+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Nombre completo:</td>'+
            '<td>'+d.nombre+'</td>'+
        '</tr>'+
    '</table>';
}

function cargarListado(){
    cargarListadoChoferes();
    var data = sessionStorage.getItem('token');
    return $('#listado').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        destroy: true,
        language: {
        url: routeBase+'/DataTables/DataTable_Spanish.json'
        },
        ajax: {
        url: rutaListadoUnidades,
        type: "GET",
        dataType: 'json',
        headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer '+data,
        }
        },
        columns: [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            {data: 'placas', name: 'placas'},
            {data: "numero", name: 'numero', "defaultContent":""},
            {data: 'numero_economico', name: 'numero_economico', "defaultContent":""},
            {data: 'action', name:'action'}
        ]
    });
}

function registrarDatosUnidad(){
    limpiarErrores();
    if(validarCampos()){
        $("#registroUnidadbtn").html("Cargando...");
        $("#registroUnidadbtn").prop('disabled', true);
        $.post({
            url: rutaRegistroUnidad,
            data:$("#datosUnidadForm").serialize(),
            dataType: 'JSON',
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer '+sessionStorage.getItem('token')
            },
            success: function(result){
                md.showNotification('bottom','right','success','Unidad creado correctamente');
                cargarListado();
                limpiarCampos();
                $('#modalDatosUnidad').modal('hide');
            },
            error: function(result){
                md.showNotification('bottom','right','danger','Ha ocurrido un error al crear la unidad');
            },
            complete: function(result){
                $("#registroUnidadbtn").html("Registrar");
                $("#registroUnidadbtn").prop('disabled', false);
            }
        });
    }else{
        marcarCamposIncorrectos();
    }
}

function cargarListadoChoferes(){
    $('#conductor1Select').empty();
    $('#conductor2Select').empty();
    console.log("aqui");
    $.get({
        url: routeBase+'/api/conductores',
        dataType: 'json',
        headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer '+sessionStorage.getItem('token'),
        },
        success: function(result){
            let turno1 = result[0];
            let turno2 = result[1];
            html = '';
            html = html + '<option value="" selected style="min-width: 300px;"> Seleccione una clave...</option>'
            turno1.forEach(element => {
                html += '<option ';
                html += ' value="'+element.id+'" ';
                html += '>'+element.nombre+' '+element.primer_apellido+' '+element.segundo_apellido+'</option>';
            });
            $('#conductor1Select').append(html);

            html2 = '';
            html2 = html2 + '<option value="" selected style="min-width: 300px;"> Seleccione una clave...</option>'
            turno2.forEach(element => {
                html2 += '<option ';
                html2 += ' value="'+element.id+'" ';
                html2 += '>'+element.nombre+' '+element.primer_apellido+' '+element.segundo_apellido+'</option>';
            });
            $('#conductor2Select').append(html2);
        },
        error: function(result){
        console.log(result);
        md.showNotification('bottom','right','danger','Ha ocurrido un error al cargar los datos de la unidad');
        }
    });
}

function editarUnidad(id_unidad){
    $.get({
        url: routeBase+'/api/unidades/'+id_unidad,
        dataType: 'json',
        headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer '+sessionStorage.getItem('token'),
        },
        success: function(result){
            $('#marca').val(result['marca']);
            $('#modelo').val(result['modelo']);
            $('#tarjeta_circulacion').val(result['tarjeta_circulacion'])
            $('#idUnidad').val( result['id'] );
            $('#placas').val( result['placas'] );
            $('#numero').val( result['numero'] );
            $('#numero_economico').val( result['numero_economico'] );
            if(result.conductores){
                result.conductores.forEach(element => {
                    if(element.turno ==1){
                        $('#conductor1Select').val(element.id).trigger('change');
                    }
                    if(element.turno == 2){
                        $('#conductor2Select').val(element.id).trigger('change');
                    }
                });
                
            }
            desplegarModalUnidad();
        },
        error: function(result){
        console.log(result);
        md.showNotification('bottom','right','danger','Ha ocurrido un error al cargar los datos de la unidad');
        }
    });
}

function eliminarUnidad(id_unidad){
    swal({
        title: '¿Esta seguro que desea eliminar la unidad?',
        text: "La unidad se eliminará de manera permanente!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        cancelButtonText: 'Cancelar!',
        confirmButtonText: 'Eliminar!',
        buttonsStyling: false
    }).then(function(confirmation) {
        console.log(confirmation);
        if (confirmation['dismiss'] != 'cancel') {
        $.post({
            url: rutaEliminadoUnidad,
            data:{
            idUnidad: id_unidad,
            },   
            dataType: 'json',
            headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer '+sessionStorage.getItem('token'),
            },
            success: function( result ) {
            md.showNotification('bottom','right','success','Unidad eliminada correctamente');
            cargarListado();
            },
            error: function(result){
            console.log(result);
            md.showNotification('bottom','right','danger','Ha ocurrido un error al eliminar la unidad');
            }
        });
        }
    })
}

function desplegarModalUnidad(){
    $('#modalDatosUnidad').modal('show');
}

function desplegarModalConductor(){
    $('#modalRegistroConductor').modal('show');
}

function validarCampos(){
    let correctos = false;
    if($('#placas').val() !='' && $('#numero').val() !='' && $('#numero_economico').val() !=''){
        correctos = true;
    }
    return correctos;
}

function marcarCamposIncorrectos(){
    if($('#placas').val() ==''){
        $('#placas-error').show();
        $('#placasDiv').addClass(' has-danger');
    }
    if($('#numero').val() ==''){
        $('#numero-error').show();
        $('#numeroDiv').addClass(' has-danger');
    }
    if($('#numero_economico').val() ==''){
        $('#numero_economico-error').show();
        $('#numero_economicoDiv').addClass(' has-danger');
    }
}

function limpiarErrores(){
    $('#placas-error').hide();
    $('#placasDiv').removeClass(' has-danger');
    $('#numero-error').hide();
    $('#numeroDiv').removeClass(' has-danger');
    $('#numero_economico-error').hide();
    $('#numero_economicoDiv').removeClass(' has-danger');
}


function registrarDatosConductor(){
    var arrayDeDatos = $("#datosConductorForm").serializeArray();
    var formData = new FormData();
    arrayDeDatos.forEach(element => 
        formData.append(element.name, element.value));
    
    formData.append('fotoPersona', $('#fotoPersona')[0].files[0]);
    formData.append('fotoElector', $('#fotoElector')[0].files[0]);
    formData.append('fotoLicencia', $('#fotoLicencia')[0].files[0]);
    formData.append('fotoElectorReverso', $('#fotoElectorReverso')[0].files[0]);
    formData.append('fotoLicenciaReverso', $('#fotoLicenciaReverso')[0].files[0]);

    // arrayDeDatos.push({name:'idUser', value:sessionStorage.getItem('user')});
    $.post({
        url: rutaRegistroConductor,
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer '+sessionStorage.getItem('token'),
        },
        success: function( result ) {
            $("#registroConductorbtn").html("Registrar");
            $("#registroConductorbtn").prop('disabled', false);
            $('#datosConductorForm').trigger("reset");
            $('#datosConductorForm').modal('hide');
            // $('#direccionSelect').empty();
            // html = '';
            // html = html + '<option value="" selected style="min-width: 300px;"> Seleccione una direccion...</option>'
            // $('#direccionSelect').append(html);
            // console.log("success registro");
            cargarListado();
            // obtenerListadoPersonas();
            // $('#personaSelect').prop('disabled',false);
            // $('#municipioSelect').prop('disabled',false);
            // $('#persona').prop('disabled',false);
            // $('#municipio').prop('disabled',false);
            // $('#idRegistro').val('');
            // $('#idCliente').val('');
            md.showNotification('bottom','right','success','Registro creado correctamente');
        },
        error: function(result){
            console.log(result);
            $("#registroConductorbtn").html("Registrar");
            $("#registroConductorbtn").prop('disabled', false);
            md.showNotification('bottom','right','danger','Ha ocurrido un error al crear el registro');
        }
    });
}