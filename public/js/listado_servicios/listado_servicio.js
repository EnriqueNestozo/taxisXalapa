$(document).ready(function() {
    cargarListado();
    obtenerListadoClavesTaxis();
    obtenerListadoPersonas();
    $('.special_select').select2({
      tags: true,
      // dropdownParent: $('#modalRegistroDiario')
    });
    $('#telefono').mask('000-000-00-00');
    // $('#celular').mask('000-000-00-00');
    
    cargarSelectsMunicipio();

    $('#modalRegistroServicio').on('hidden.bs.modal', function () {
        $('#registroDiarioForm').trigger("reset");
        limpiarErrores();
        obtenerListadoPersonas();
        cargarSelectsMunicipio();
        $('#direccionSelect').empty();
        html = '';
        html = html + '<option value="" selected style="min-width: 300px;"> Seleccione una direccion...</option>'
        $('#direccionSelect').append(html);
        $('#persona').prop('disabled',false);
        $('#municipio').prop('disabled',false);
        $('#localidad').prop('disabled',false);
        $('#colonia').prop('disabled',false);
        $('#referencia').prop('disabled',false);
        $('#telefono').prop('disabled',false);
        // $('#celular').prop('disabled',false);
        $('#busquedaSelect').prop('disabled',false);
        $('#municipioSelect').prop('disabled',false);
        $('#localidadSelect').prop('disabled',false);
        $('#coloniaSelect').prop('disabled',false);
        $('#lunes').prop('disabled',true);
        $('#martes').prop('disabled',true);
        $('#miercoles').prop('disabled',true);
        $('#jueves').prop('disabled',true);
        $('#viernes').prop('disabled',true);
        $('#sabado').prop('disabled',true);
        $('#domingo').prop('disabled',true);
      });

    $('#lunesCheck').change(function(){
        $('#lunes').prop('disabled', !$('#lunesCheck').is(':checked')).trigger('change');
    });
    
    $('#martesCheck').change(function(){
        console.log(!$('#martesCheck').is(':checked'));
        $('#martes').prop('disabled', !$('#martesCheck').is(':checked')).trigger('change');
    });

    $('#miercolesCheck').change(function(){
        $('#miercoles').prop('disabled', !$('#miercolesCheck').is(':checked')).trigger('change');
    });

    $('#juevesCheck').change(function(){
        $('#jueves').prop('disabled', !$('#juevesCheck').is(':checked')).trigger('change');
    });

    $('#viernesCheck').change(function(){
        $('#viernes').prop('disabled', !$('#viernesCheck').is(':checked')).trigger('change');
    });

    $('#sabadoCheck').change(function(){
        $('#sabado').prop('disabled', !$('#sabadoCheck').is(':checked')).trigger('change');
    });

    $('#domingoCheck').change(function(){
        $('#domingo').prop('disabled', !$('#domingoCheck').is(':checked')).trigger('change');
    });

    $('#persona, #telefono').keyup(function(){
        if( $('#persona').val() !='' || $('#telefono').val() !='' ){
          console.log("entra");
          $('#personaDiv').removeClass('has-danger');
          $('#persona-error').hide();
          $('#telefonoDiv').removeClass('has-danger');
          $('#telefono-error').hide();
          $('#busquedaDiv').removeClass('has-danger');
          $('#busqueda-error').hide();
    
          if( $('busquedaSelect').val() == null){
            console.log("entra2");
            $('#busquedaSelect').prop('disabled',true);
            $('#direccionSelect').empty();
            html = '';
            html = html + '<option value="" selected style="min-width: 300px;"> Seleccione una direccion...</option>'
            $('#direccionSelect').append(html);
          }
        }else{
          console.log("else");
            $('#busquedaSelect').prop('disabled',false);
        }
      });
    
    $('#busquedaSelect').change(function(){
        if(  $('#busquedaSelect').val() != '' ){
            $('#busquedaDiv').removeClass('has-danger');
            $('#busqueda-error').hide();
            $('#personaDiv').removeClass('has-danger');
            $('#persona-error').hide();
            $('#telefonoDiv').removeClass('has-danger');
            $('#telefono-error').hide();
            if( $('#busquedaSelect').val() !='' ){
            obtenerListadoDirecciones();
            $.get({
                url: routeBase+ '/api/clientes/'+$('#busquedaSelect').val(),
                dataType: 'json',
                headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer '+sessionStorage.getItem('token'),
                },
                success: function( result ) {
                $('#telefono').val(result['telefono_fijo']);
                $('#persona').val(result['nombre']);
                // $('#celular').val(result['celular']);
                $('#telefono').prop('disabled',true);
                $('#persona').prop('disabled',true);
                // $('#celular').prop('disabled',true);
                },
                error: function(result){
                console.log(result);
                }
            });
            $('#persona').prop('disabled',true);
            }
        }else{
            $('#busquedaSelect').prop('disabled',false);
            $('#persona').prop('disabled',false);
            
            // html = '';
            // html = html + '<option value="" selected style="min-width: 300px;"> Seleccione una dirección...</option>'
            // $('#municipioSelect').append(html);
            $('#telefono').val('');
            // $('#celular').val('');
            $('#telefono').prop('disabled',false);
            // $('#celular').prop('disabled',false);
        }
    });
    
    $('#direccionSelect').change(function(){
        if( $('#direccionSelect').val() !='' ){
            $('#municipioSelect').val('').trigger('change');
            $('#municipioSelect').prop('disabled',true).trigger('change');
            $('#municipio').prop('disabled',true);
            $('#localidadSelect').val('').trigger('change');
            $('#localidadSelect').prop('disabled',true).trigger('change');
            $('#localidad').prop('disabled',true);
            $('#coloniaSelect').val('').trigger('change');
            $('#coloniaSelect').prop('disabled',true).trigger('change');
            $('#colonia').prop('disabled',true);
            $('#calle').prop('disabled',true);
            $('#entre_calles').prop('disabled',true);
            $('#referencia').prop('disabled',true);
            limpiarErrores();
            $.get({
                url: routeBase+ '/api/direcciones/'+$('#direccionSelect').val(),
                dataType: 'json',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer '+sessionStorage.getItem('token'),
                },
                success: function( result ) {
                    $('#referencia').val(result['referencia']);
                    $('#entre_calles').val(result['entre_calles']);
                    $('#calle').val(result['calle']);
                    // console.log(result);
                    // $('#localidadSelect').select2({data:result}).trigger('change');
                },
                error: function(result){
                    console.log(result);
                }
            });
        }else{
            $('#referencia').val('');
            $('#entre_calles').val('');
            $('#calle').val('');
            $('#municipioSelect').prop('disabled',false);
            $('#municipioSelect').val(87).trigger('change');
            $('#municipio').prop('disabled',false);
            $('#localidadSelect').prop('disabled',false);
            $('#localidadSelect').val('').trigger('change');
            $('#localidad').prop('disabled',false);
            $('#coloniaSelect').prop('disabled',false);
            $('#colonia').prop('disabled',false);
            $('#calle').prop('disabled',false);
            $('#entre_calles').prop('disabled',false);
            $('#referencia').prop('disabled',false);
        }
    });
    
    $('#municipio').keyup(function(){
        if( $('#municipio').val() !='' || $('#municipioSelect').val() !=-''){
            $('#municipioDiv').removeClass(' has-danger');
            $('#municipio-error').hide();
            if( $('#municipio').val() !=''){
            $('#municipioSelect').prop('disabled',true);
        }
        }else{
            $('#municipioSelect').prop('disabled',false);
        }
    });
    
    $('#municipioSelect').change(function(){
        var data = sessionStorage.getItem('token');
        if( $('#municipio').val() !='' || $('#municipioSelect').val() !=-''){
            $('#municipioDiv').removeClass(' has-danger');
            $('#municipio-error').hide();
            if($('#municipioSelect').val() !=null ){
            $.when( 
                $.ajax( routeBase+ '/api/localidades/'+$('#municipioSelect').val() ),
                $.ajax( routeBase+ '/api/colonias/'+$('#municipioSelect').val() )
            )
                .done(function ( v1,v2) {
                $('#localidadSelect').empty();
                $('#coloniaSelect').empty();
                // console.log(v1[0],v2[0]);
                // console.log("colonias:  " +v2);
                $('#localidadSelect').select2({data:v1[0]}).trigger('change');
                $('#coloniaSelect').select2({data:v2[0]}).trigger('change');
                // $('.special_select').select2({
                //   tags: true,
                //   dropdownParent: $('#modalRegistroDiario')
                // });
                $('#localidadSelect').val(1).trigger('change');
                $('#coloniaSelect').val('').trigger('change');
            });
            $('#municipio').prop('disabled',true);
        }
        }else{
            $('#municipio').prop('disabled',false);
        }
    });
    
    $('#localidadSelect').change(function(){
        if( $('#localidadSelect').val() !='' || $('#localidad').val() !='' ){
            $('#localidadDiv').removeClass(' has-danger');
            $('#localidad-error').hide();
            if( $('#localidadSelect').val() !='' ){
            $('#localidad').prop('disabled',true);
            }
        }else{
            $('#localidad').prop('disabled',false);
        }
    });
    
    $('#localidad').keyup(function(){
        if( $('#localidad').val() !='' || $('#localidadSelect').val() !=-''){
            $('#localidadDiv').removeClass(' has-danger');
            $('#localidad-error').hide();
            if( $('#localidad').val() !=''){
            // $('#localidadSelect').prop('disabled',true);
            $('#coloniaSelect').prop('disabled',true).trigger('change');
            }
        }else{
            // $('#localidadSelect').prop('disabled',false);
            $('#coloniaSelect').prop('disabled',false).trigger('change');
        }
    });
    
    $('#coloniaSelect').change(function(){
        if( $('#coloniaSelect').val() !='' ){
            $('#coloniaDiv').removeClass(' has-danger');
            $('#colonia-error').hide();
            $('#colonia').prop('disabled',true);
        }else{  
            $('#colonia').prop('disabled',false);
        }
    });
    
    $('#colonia').keyup(function(){
        if( $('#colonia').val() !='' || $('#coloniaSelect').val() !=-''){
            $('#coloniaDiv').removeClass(' has-danger');
            $('#colonia-error').hide();
            if( $('#colonia').val() !=''){
            $('#coloniaSelect').prop('disabled',true);
            }
        }else{
            $('#coloniaSelect').prop('disabled',false);
        }
    });
    
    $('#calle').change(function(){
        if( $('#calle').val() !='' ){
            $('#calleDiv').removeClass(' has-danger');
            $('#calle-error').hide();
        }
    });
    
    // $('#telefono').change(function(){
    //     if( $('#telefono').val() != '' || $('#celular').val() != '' ){
    //         $('#telefonoDiv').removeClass(' has-danger');
    //         $('#telefono-error').hide();
    //         $('#celularDiv').removeClass(' has-danger');
    //         $('#celular-error').hide();
    //     }
    // });
    
    // $('#celular').change(function(){
    //     if( $('#celular').val() != '' || $('#telefono').val() != '' ){
    //         $('#celularDiv').removeClass(' has-danger');
    //         $('#celular-error').hide();
    //         $('#telefonoDiv').removeClass(' has-danger');
    //         $('#telefono-error').hide();
    //     }
    // });
});