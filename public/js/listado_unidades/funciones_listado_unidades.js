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

function format ( datosConductor ) {
    if(datosConductor !=null){
        var tablaConductores = '<table class="table" cellpadding="5" cellspacing="0" style="padding-left:50px;">';
       
        datosConductor.forEach(element => {
            if(element.pivot.turno == 1){
                element.pivot.turno = "Mañana";
                tablaConductores += '<tr>'+
                                '<td>Turno:</td>'+
                                '<td>'+element.pivot.turno+'</td>'+
                                '<td><button class="btn btn-danger btn-link btn-sm" type="button" data-original-title="Quitar chofer" onClick="quitarConductorDeUnidad('+element.pivot.id +')"><i class="material-icons">delete</i></button></td>'+
                                '</tr>';
            }else if(element.pivot.turno == 2){
                element.pivot.turno = "Tarde";
                tablaConductores += '<tr>'+
                                '<td>Turno:</td>'+
                                '<td>'+element.pivot.turno+'</td>'+
                                '<td><button class="btn btn-danger btn-link btn-sm" type="button" data-original-title="Quitar chofer" onClick="quitarConductorDeUnidad('+element.pivot.id +')"><i class="material-icons">delete</i></button></td>'+
                                '</tr>';
            }else{
                element.pivot.turno = "Otro";
                tablaConductores += '<tr>'+
                                '<td>Turno:</td>'+
                                '<td>'+element.pivot.turno+'</td>'+
                                '<td><button class="btn btn-danger btn-link btn-sm" type="button" data-original-title="Quitar chofer" onClick="quitarConductorDeUnidad('+element.pivot.id +')"><i class="material-icons">delete</i></button></td>'+
                                '</tr>';
            }
            tablaConductores += '<tr>'+
                '<td>Nombre completo:</td>'+
                '<td>'+element.nombre+" "+element.primer_apellido+" "+element.segundo_apellido+'</td>'+
            '</tr>';
        });
        tablaConductores+='</table>';
        return tablaConductores; 
    }else{
        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
            '<tr>'+
                '<td>Actualmente no hay conductores asociados a esta unidad:</td>'+
            '</tr>'+
        '</table>';
    }
}

function quitarConductorDeUnidad(idConductorUnidad){
    swal({
        title: '¿Esta seguro que desea quitar a este chofer de la unidad?',
        // text: "La unidad se eliminará de manera permanente!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Quitar',
        buttonsStyling: false
    }).then(function(confirmation) {
        if (confirmation['dismiss'] != 'cancel') {
        $.post({
            url: rutaEliminadoConductorUnidad,
            data:{
                id: idConductorUnidad,
            },   
            dataType: 'json',
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer '+sessionStorage.getItem('token'),
            },
            success: function( result ) {
                md.showNotification('bottom','right','success','Conductor eliminado de la unidad correctamente');
                table = cargarListado();
            },
            error: function(result){
            md.showNotification('bottom','right','danger','Ha ocurrido un error al eliminar al conductor de la unidad');
            }
        });
        }
    })
}

function cargarListado(){
    cargarListadoChoferesEnSelect();
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
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "searchable": false,
                "render": function ( type, row, meta ) { 
                    return "<span class='material-icons'>add_box</span>"
                },
            },
            {data: 'placas', name: 'placas'},
            {data: "numero", name: 'numero', "defaultContent":""},
            {data: 'numero_economico', name: 'numero_economico', "defaultContent":""},
            {data: 'action', name:'action', orderable:false}
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
                table = cargarListado();
                $('#datosUnidadForm').trigger('reset');
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

function cargarListadoChoferesEnSelect(){
    $('#conductorSelect').empty();
    $.get({
        url: routeBase+'/api/conductores',
        dataType: 'json',
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer '+sessionStorage.getItem('token'),
        },
        success: function(result){
            console.log(result);
            html = '';
            html = html + '<option value="" selected style="min-width: 300px;"> Seleccione un chofer...</option>'
            result.forEach(element => {
                html += '<option ';
                html += ' value="'+element.id+'" ';
                html += '>'+element.nombre+' '+element.primer_apellido+' '+element.segundo_apellido+'</option>';
            });
            $('#conductorSelect').append(html);
        },
        error: function(result){
            console.log(result);
            md.showNotification('bottom','right','danger','Ha ocurrido un error al cargar los datos de la unidad');
        }
    });
}

function agregarConductor(idUnidad){
    $('#modalRelacionConductorUnidad').modal('show');
    $('#idUnidadModalRelacion').val(idUnidad);
}

function registrarConductorAUnidad(){
    $.post({
        url: routeBase+'/api/unidad-conductor',
        dataType: 'json',
        data:$("#datosConductorUnidadForm").serialize(),
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer '+sessionStorage.getItem('token'),
        },
        success: function(result){
            $("#datosConductorUnidadForm").trigger('reset');
            $('#modalRelacionConductorUnidad').modal('hide');
            md.showNotification('bottom','right','success','Se ha realizado la relación correctamente');
            table = cargarListado();
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
                table = cargarListado();
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
            $('#modalRegistroConductor').modal('hide');
            cargarListadoConductores();
            cargarListadoChoferesEnSelect();
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

function cargarListadoConductores(){
    var data = sessionStorage.getItem('token');
    $('#listadoConductores').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        destroy: true,
        language: {
            url: routeBase+'/DataTables/DataTable_Spanish.json'
        },
        ajax: {
            url: rutaListadoConductores,
            type: "GET",
            dataType: 'json',
            headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer '+data,
            }
        },
        columns: [
            {data: 'nombre', name: 'nombre'},
            {data: "celular", name: 'celular', "defaultContent":""},
            {data: 'vencimiento', name: 'vencimiento', "defaultContent":""},
            {data: 'action', name:'action', orderable:false}
        ]
    });
}

function ELiminarConductor(idConductor){
    swal({
        title: '¿Esta seguro que desea eliminar a este conductor?',
        text: "El conductor se eliminará tambien de las unidades asignadas",
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Eliminar',
        buttonsStyling: false
    }).then(function(confirmation) {
        if (confirmation['dismiss'] != 'cancel') {
            $.post({
                url: rutaEliminadoConductor,
                data: {
                    id: idConductor
                },
                dataType: 'json',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer '+sessionStorage.getItem('token'),
                },
                success: function( result ) {
                    md.showNotification('bottom','right','success','Unidad eliminada correctamente');
                    cargarListadoConductores();
                    cargarListadoChoferesEnSelect();
                },
                error: function(result){
                    console.log(result);
                    md.showNotification('bottom','right','danger','Ha ocurrido un error al eliminar la unidad');
                }
            });
        }
    })
}