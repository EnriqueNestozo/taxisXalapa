$(document).ready(function() {
  cargarListado();
  obtenerListadoClavesTaxis();
  obtenerListadoPersonas();
  $('.clave').select2({
    tags: true,
    dropdownParent: $('#modalRegistroDiario')
  });
  $('#telefono').mask('000-000-00-00');
  $('#celular').mask('000-000-00-00');
  
  cargarSelectsMunicipio();

  $('#modalRegistroDiario').on('hidden.bs.modal', function () {
    $('#registroDiarioForm').trigger("reset");
    $('#persona').prop('disabled',false);
    $('#municipio').prop('disabled',false);
    $('#referencia').prop('disabled',false);
    $('#telefono').prop('disabled',false);
    $('#celular').prop('disabled',false);
    $('#personaSelect').prop('disabled',false);
    $('#municipioSelect').prop('disabled',false);
  });

  $('#hora').focusout(function(){
    if( $('#hora').val() !='' ){
      $('#horaDiv').removeClass(' has-danger');
      $('#hora-error').hide();
    }
  });

  $('#persona').change(function(){
    if( $('#persona').val() !='' || $('#personaSelect').val() != '' ){
      $('#personaDiv').removeClass('has-danger');
      $('#persona-error').hide();
      if($('#persona').val() !=''){
        $('#municipioSelect').empty();
        $('#personaSelect').prop('disabled',true);
        // html = '';
        // html = html + '<option value="" selected style="min-width: 300px;"> Seleccione una direccion...</option>'
        // $('#municipioSelect').append(html);
      }
    }else{
      $('#personaSelect').prop('disabled',false);
      $('#persona').prop('disabled',false);
    }
  });

  $('#personaSelect').change(function(){
    if( $('#persona').val() !='' || $('#personaSelect').val() != '' ){
      $('#personaDiv').removeClass('has-danger');
      $('#persona-error').hide();
      if( $('#personaSelect').val() !='' ){
        obtenerListadoDirecciones();
        $.get({
          url: routeBase+ '/api/clientes/'+$('#personaSelect').val(),
          dataType: 'json',
          headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer '+sessionStorage.getItem('token'),
          },
          success: function( result ) {
            $('#telefono').val(result['telefono_fijo']);
            $('#celular').val(result['celular']);
            $('#telefono').prop('disabled',true);
            $('#celular').prop('disabled',true);
          },
          error: function(result){
            console.log(result);
          }
        });
        $('#persona').prop('disabled',true);
      }
    }else{
      $('#personaSelect').prop('disabled',false);
      $('#persona').prop('disabled',false);
      
      // html = '';
      // html = html + '<option value="" selected style="min-width: 300px;"> Seleccione una dirección...</option>'
      // $('#municipioSelect').append(html);
      $('#telefono').val('');
      $('#celular').val('');
      $('#telefono').prop('disabled',false);
      $('#celular').prop('disabled',false);
    }
  });

  $('#municipio').change(function(){
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
            // console.log(v1[0],v2[0]);
            // console.log("colonias:  " +v2);
            $('#localidadSelect').select2({data:v1[0]}).trigger('change');
            $('#coloniaSelect').select2({data:v2[0]}).trigger('change');
            $('.clave').select2({
              tags: true,
              dropdownParent: $('#modalRegistroDiario')
            });
            $('#localidadSelect').val(1).trigger('change');
        });
        // $.get({
        //   url: routeBase+ '/api/localidades/'+$('#municipioSelect').val(),
        //   dataType: 'json',
        //   headers: {
        //     'Accept': 'application/json',
        //     'Authorization': 'Bearer '+data,
        //   },
        //   success: function( result ) {
        //     // $('#referencia').val(result['referencia']);
        //     // $('#entre_calles').val(result['entre_calles']);
        //     console.log(result);
        //     $('#localidadSelect').select2({data:result}).trigger('change');
        //     $('#referencia').prop('disabled',true);
        //   },
        //   error: function(result){
        //     console.log(result);
        //   }
        // });
        $('#municipio').prop('disabled',true);
    }
    }else{
      $('#municipio').prop('disabled',false);
    }
  });

  // $('#entre_calles').change(function(){
  //   if( $('#entre_calles').val() !='' ){
  //     $('#entre_callesDiv').removeClass(' has-danger');
  //     $('#entre_calles-error').hide();
  //   }
  // });

  // $('#referencia').change(function(){
  //   if( $('#referencia').val() !='' ){
  //     $('#referenciaDiv').removeClass(' has-danger');
  //     $('#referencia-error').hide();
  //   }
  // });


  $('#telefono').change(function(){
    if( $('#telefono').val() != '' || $('#celular').val() != '' ){
      $('#telefonoDiv').removeClass(' has-danger');
      $('#telefono-error').hide();
      $('#celularDiv').removeClass(' has-danger');
      $('#celular-error').hide();
    }
  });

  $('#celular').change(function(){
    if( $('#celular').val() != '' || $('#telefono').val() != '' ){
      $('#celularDiv').removeClass(' has-danger');
      $('#celular-error').hide();
      $('#telefonoDiv').removeClass(' has-danger');
      $('#telefono-error').hide();
    }
  });

});

  