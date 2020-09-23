$(document).ready(function() {
  cargarListado();
  obtenerListadoClavesTaxis();
  // obtenerListadoPersonas();
  $('#direccionSelect').select2({
    // tags: true,
    dropdownParent: $('#direccionDiv')
  });
  $('#busquedaSelect').select2({
    // tags: true,
    dropdownParent: $('#busquedaDiv')
  });
  // $('#personaSelect').select2({
  //   // tags: true,
  //   dropdownParent: $('#personaDiv')
  // });
  $('#municipioSelect').select2({
    // tags: true,
    dropdownParent: $('#municipioDiv')
  });
  $('#localidadSelect').select2({
    // tags: true,
    dropdownParent: $('#localidadDiv')
  });
  $('#coloniaSelect').select2({
    // tags: true,
    dropdownParent: $('#coloniaDiv')
  });
  $('#clave').select2({
    // tags: true,
    dropdownParent: $('#claveDiv')
  });
  $('#direccionDestinoSelect').select2({
    // tags: true,
    dropdownParent: $('#direccionDestinoDiv')
  });
  $('#busquedaDestinoSelect').select2({
    // tags: true,
    dropdownParent: $('#busquedaDestinoDiv')
  });
  $('#municipioDestinoSelect').select2({
    // tags: true,
    dropdownParent: $('#municipioDestinoDiv')
  });
  $('#localidadDestinoSelect').select2({
    // tags: true,
    dropdownParent: $('#localidadDestinoDiv')
  });
  $('#coloniaDestinoSelect').select2({
    // tags: true,
    dropdownParent: $('#coloniaDestinoDiv')
  });
  $('#telefono').mask('000-000-00-00');
  // $('#celular').mask('000-000-00-00');

  $('#modalRegistroDiario').on('hidden.bs.modal', function () {
    $('#registroDiarioForm').trigger("reset");
    limpiarErrores();
    // obtenerListadoPersonas();
    // cargarSelectsMunicipio();
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
    $('#calle').prop('disabled',false);
    $('#entre_calles').prop('disabled',false);
    // $('#celular').prop('disabled',false);
    $('#busquedaSelect').prop('disabled',false);
    $('#municipioSelect').prop('disabled',false);
    $('#localidadSelect').prop('disabled',false);
    $('#coloniaSelect').prop('disabled',false);
    $('#clave').val('').trigger('change');
  });

  $('#modalDestino').on('hidden.bs.modal', function () {
    $('#destinoForm').trigger("reset");
    limpiarErroresDestino();
    // obtenerListadoPersonas();
    // cargarSelectsMunicipio();
    $('#direccionDestinoSelect').empty();
    html = '';
    html = html + '<option value="" selected style="min-width: 300px;"> Seleccione una direccion...</option>'
    $('#direccionDestinoSelect').append(html);
    $('#direccionDestinoSelect').trigger('change');
    $('#busquedaDestino').prop('disabled',false);
    $('#municipioDestino').prop('disabled',false);
    $('#localidadDestino').prop('disabled',false);
    $('#coloniaDestino').prop('disabled',false);
    $('#referenciaDestino').prop('disabled',false);
   
    $('#busquedaDestinoSelect').prop('disabled',false);
    $('#municipioDestinoSelect').prop('disabled',false);
    $('#localidadDestinoSelect').prop('disabled',false);
    $('#coloniaDestinoSelect').prop('disabled',false);
    $('#eliminarDestinoBtn').hide();
    $('#registroDestinoBtn').show();
  });

  // $('#isRecurrente').change(function(){
  //   if( $('#isRecurrente').is(':checked') ){
  //     $('#semanaDiv').show();
  //     $('#horaDiv').hide();
  //   }else{
  //     $('#horaDiv').show();
  //     $('#semanaDiv').hide();
  //   }
  // });


  $('#hora').focusout(function(){
    if( $('#hora').val() !='' ){
      $('#horaDiv').removeClass(' has-danger');
      $('#hora-error').hide();
    }
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
    if( $('#busquedaSelect').val() > 0  ){
      console.log($('#busquedaSelect').val());
      $('#busquedaDiv').removeClass('has-danger');
      $('#busqueda-error').hide();
      $('#personaDiv').removeClass('has-danger');
      $('#persona-error').hide();
      $('#telefonoDiv').removeClass('has-danger');
      $('#telefono-error').hide();
      // if( $('#busquedaSelect').val() !='' ){
        obtenerListadoDirecciones();
        $.get({
          url: routeBase+ '/api/clientes/'+$('#busquedaSelect').val(),
          dataType: 'json',
          headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer '+sessionStorage.getItem('token'),
          },
          success: function( result ) {
            $('#municipioSelect').prop('disabled',false);
            $('#municipio').prop('disabled',false);
            $('#municipio').val('');
            $('#localidadSelect').prop('disabled',false);
            $('#localidad').prop('disabled',false);
            $('#localidad').val('');
            $('#municipioSelect').val(87).trigger('change');
            $('#coloniaSelect').prop('disabled',false);
            $('#colonia').prop('disabled',false);
            $('#colonia').val('');
            $('#calle').prop('disabled',false);
            $('#calle').val('');
            $('#entre_calles').prop('disabled',false);
            $('#entre_calles').val('');
            $('#referencia').prop('disabled',false);
            $('#referencia').val('');
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
        // $('#persona').prop('disabled',true);
      // }
    }else{
      $('#direccionSelect').empty();
      html = '';
      html = html + '<option value="" selected style="min-width: 300px;"> Seleccione una direccion...</option>'
      $('#direccionSelect').append(html);
      $('#direccionSelect').val('');
      $('#municipioSelect').prop('disabled',false);
      $('#municipioSelect').val(87);
      $('#municipioSelect').trigger('change');
      $('#localidadSelect').prop('disabled',false);
      $('#coloniaSelect').prop('disabled',false);
      $('#busquedaSelect').prop('disabled',false);
      $('#persona').val('');
      $('#persona').prop('disabled',false);
      $('#persona').trigger('change');
      // html = '';
      // html = html + '<option value="" selected style="min-width: 300px;"> Seleccione una dirección...</option>'
      // $('#municipioSelect').append(html);
      $('#telefono').val('');
      // $('#celular').val('');
      $('#telefono').prop('disabled',false);
      $('#telefono').trigger('change');
      // $('#celular').prop('disabled',false);
    }
  });


  $('#busquedaDestinoSelect').change(function(){
    if( $('#busquedaDestino').val() !='' || $('#busquedaDestinoSelect').val() != '' ){
      $('#busquedaDestinoDiv').removeClass('has-danger');
      $('#busquedaDestinoSelect-error').hide();
      if( $('#busquedaDestinoSelect').val() !='' ){
        obtenerListadoDireccionesDestino();
        $.get({
          url: routeBase+ '/api/clientes/'+$('#busquedaDestinoSelect').val(),
          dataType: 'json',
          headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer '+sessionStorage.getItem('token'),
          },
          success: function( result ) {
            console.log(result);
          },
          error: function(result){
            console.log(result);
          }
        });
        $('#persona').prop('disabled',true);
        $('#telefono').prop('disabled',true);
      }
    }else{
      $('#direccionDestinoSelect').empty();
      html = '';
      html = html + '<option value="" selected style="min-width: 300px;"> Seleccione una direccion...</option>'
      $('#direccionDestinoSelect').append(html);
      $('#busquedaDestinoSelect').prop('disabled',false);
      $('#busquedaDestino').prop('disabled',false);
      
      // html = '';
      // html = html + '<option value="" selected style="min-width: 300px;"> Seleccione una dirección...</option>'
      // $('#municipioSelect').append(html);
      
    }
  });

  $('#direccionSelect').change(function(){
    console.log("asodksd!"+$('#direccionSelect').val());
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

  $('#direccionDestinoSelect').change(function(){
    if( $('#direccionDestinoSelect').val() !='' ){
      $('#municipioDestinoSelect').val('').trigger('change');
      $('#municipioDestinoSelect').prop('disabled',true).trigger('change');
      $('#municipioDestino').prop('disabled',true);
      $('#localidadDestinoSelect').val('').trigger('change');
      $('#localidadDestinoSelect').prop('disabled',true).trigger('change');
      $('#localidadDestino').prop('disabled',true);
      $('#coloniaDestinoSelect').val('').trigger('change');
      $('#coloniaDestinoSelect').prop('disabled',true).trigger('change');
      $('#coloniaDestino').prop('disabled',true);
      $('#calleDestino').prop('disabled',true);
      $('#entre_callesDestino').prop('disabled',true);
      $('#referenciaDestino').prop('disabled',true);
      $.get({
        url: routeBase+ '/api/direcciones/'+$('#direccionDestinoSelect').val(),
        dataType: 'json',
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer '+sessionStorage.getItem('token'),
        },
        success: function( result ) {
          $('#referenciaDestino').val(result['referencia']);
          $('#entre_callesDestino').val(result['entre_calles']);
          $('#calleDestino').val(result['calle']);
          // console.log(result);
          // $('#localidadSelect').select2({data:result}).trigger('change');
        },
        error: function(result){
          console.log(result);
        }
      });
    }else{
      $('#referenciaDestino').val('');
      $('#entre_callesDestino').val('');
      $('#calleDestino').val('');
      $('#municipioDestinoSelect').prop('disabled',false);
      $('#municipioDestino').prop('disabled',false);
      $('#localidadDestinoSelect').prop('disabled',false);
      $('#localidadDestino').prop('disabled',false);
      $('#coloniaDestinoSelect').prop('disabled',false);
      $('#coloniaDestino').prop('disabled',false);
      $('#calleDestino').prop('disabled',false);
      $('#entre_callesDestino').prop('disabled',false);
      $('#referenciaDestino').prop('disabled',false);
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

  $('#municipioDestino').change(function(){
    if( $('#municipioDestino').val() !='' || $('#municipioDestinoSelect').val() !=-''){
      $('#municipioDestinoDiv').removeClass(' has-danger');
      $('#municipioDestino-error').hide();
      if( $('#municipioDestino').val() !=''){
        $('#municipioDestinoSelect').prop('disabled',true);
    }
    }else{
      $('#municipioDestinoSelect').prop('disabled',false);
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
            // console.log("v1 y v2",v1);
            $('#localidadSelect').empty();
            $('#coloniaSelect').empty();
            // console.log(v1[0],v2[0]);
            // console.log("colonias:  " +v2);
            html = '';
            for (let index = 0; index < v1[0].length; index++) {
              html += '<option ';
              html += ' value="'+v1[0][index].id+'" ';
              html += '>'+v1[0][index].text+'</option>';
            }
            $('#localidadSelect').append(html).trigger('change');
              html = '';
            for (let index = 0; index < v2[0].length; index++) {
              html += '<option ';
              html += ' value="'+v2[0][index].id+'" ';
              html += '>'+v2[0][index].text+'</option>';
            }
            $('#coloniaSelect').append(html).trigger('change');
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
  
  $('#municipioDestinoSelect').change(function(){
    var data = sessionStorage.getItem('token');
    if( $('#municipioDestino').val() !='' || $('#municipioDestinoSelect').val() !=-''){
      $('#municipioDestinoDiv').removeClass(' has-danger');
      $('#municipioDestino-error').hide();
      if($('#municipioDestinoSelect').val() !=null ){
        $.when( 
          $.ajax( routeBase+ '/api/localidades/'+$('#municipioDestinoSelect').val() ),
          $.ajax( routeBase+ '/api/colonias/'+$('#municipioDestinoSelect').val() )
        )
          .done(function ( v1,v2) {
            $('#localidadDestinoSelect').empty();
            $('#coloniaDestinoSelect').empty();
            // console.log(v1[0],v2[0]);
            // console.log("coloniaDestinos:  " +v2);
            html = '';
            for (let index = 0; index < v1[0].length; index++) {
              html += '<option ';
              html += ' value="'+v1[0][index].id+'" ';
              html += '>'+v1[0][index].text+'</option>';
            }
            $('#localidadDestinoSelect').append(html).trigger('change');
            html = '';
            for (let index = 0; index < v2[0].length; index++) {
              html += '<option ';
              html += ' value="'+v2[0][index].id+'" ';
              html += '>'+v2[0][index].text+'</option>';
            }
            $('#coloniaDestinoSelect').append(html).trigger('change');
            // $('.special_select').select2({
            //   tags: true,
            //   dropdownParent: $('#modalRegistroDiario')
            // });
            $('#localidadDestinoSelect').val(1).trigger('change');
            $('#coloniaDestinoSelect').val('').trigger('change');
        });
        $('#municipioDestino').prop('disabled',true);
    }
    }else{
      $('#municipioDestino').prop('disabled',false);
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
  
  $('#localidadDestinoSelect').change(function(){
    if( $('#localidadDestinoSelect').val() !='' || $('#localidadDestino').val() !='' ){
      $('#localidadDestinoDiv').removeClass(' has-danger');
      $('#localidadDestino-error').hide();
      if( $('#localidadDestinoSelect').val() !='' ){
        $('#localidadDestino').prop('disabled',true);
      }
    }else{
      $('#localidadDestino').prop('disabled',false);
    }
  });

  $('#localidad').change(function(){
    if( $('#localidad').val() !='' || $('#localidadSelect').val() !=-''){
      $('#localidadDiv').removeClass(' has-danger');
      $('#localidad-error').hide();
      if( $('#localidad').val() !=''){
        // $('#localidadSelect').prop('disabled',true);
        $('#coloniaSelect').prop('disabled',true).trigger('change');
      }
    }else{
      // $('#localidadSelect').prop('disabled',false);
      // $('#coloniaSelect').prop('disabled',false).trigger('change');
    }
  });

  $('#localidadDestino').change(function(){
    if( $('#localidadDestino').val() !='' || $('#localidadDestinoSelect').val() !=-''){
      $('#localidadDestinoDiv').removeClass(' has-danger');
      $('#localidadDestino-error').hide();
      if( $('#localidadDestino').val() !=''){
        // $('#localidadSelect').prop('disabled',true);
        $('#coloniaDestinoSelect').prop('disabled',true).trigger('change');
      }
    }else{
      // $('#localidadSelect').prop('disabled',false);
      $('#coloniaDestinoSelect').prop('disabled',false).trigger('change');
    }
  });

  $('#coloniaSelect').change(function(){
    if( $('#coloniaSelect').val() !='' || $('#colonia').val() !='' ){
      $('#coloniaDiv').removeClass(' has-danger');
      $('#colonia-error').hide();
      if( $('#coloniaSelect').val() !='' ){
        $('#colonia').prop('disabled',true);
      }
    }else{ 
        $('#colonia').prop('disabled',false);
    }
  });

  $('#coloniaDestinoSelect').change(function(){
    if( $('#coloniaDestinoSelect').val() !='' ){
      $('#coloniaDestinoDiv').removeClass(' has-danger');
      $('#coloniaDestino-error').hide();
      $('#coloniaDestino').prop('disabled',true);
    }else{  
      $('#coloniaDestino').prop('disabled',false);
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

  $('#coloniaDestino').change(function(){
    if( $('#coloniaDestino').val() !='' || $('#coloniaDestinoSelect').val() !=-''){
      $('#coloniaDestinoDiv').removeClass(' has-danger');
      $('#coloniaDestino-error').hide();
      if( $('#coloniaDestino').val() !=''){
        $('#coloniaDestinoSelect').prop('disabled',true);
      }
    }else{
      $('#coloniaDestinoSelect').prop('disabled',false);
    }
  });

  // $('#calle').change(function(){
  //   if( $('#calle').val() !='' ){
  //     $('#calleDiv').removeClass(' has-danger');
  //     $('#calle-error').hide();
  //   }
  // });

  // $('#calleDestino').change(function(){
  //   if( $('#calleDestino').val() !='' ){
  //     $('#calleDestinoDiv').removeClass(' has-danger');
  //     $('#calleDestino-error').hide();
  //   }
  // });

  // $('#referencia').change(function(){
  //   if( $('#referencia').val() !='' ){
  //     $('#referenciaDiv').removeClass(' has-danger');
  //     $('#referencia-error').hide();
  //   }
  // });


  // $('#telefono').change(function(){
  //   if( $('#telefono').val() != '' ){
  //   // if( $('#telefono').val() != '' || $('#celular').val() != '' ){
  //     $('#telefonoDiv').removeClass(' has-danger');
  //     $('#telefono-error').hide();
  //     if($('#busquedaSelect').val() ==null){
  //       $('#busquedaSelect').prop('disabled',true);
  //     }
      
  //     // $('#celularDiv').removeClass(' has-danger');
  //     // $('#celular-error').hide();
  //   }
  // });

  // $('#celular').change(function(){
  //   if( $('#celular').val() != '' || $('#telefono').val() != '' ){
  //     $('#celularDiv').removeClass(' has-danger');
  //     $('#celular-error').hide();
  //     $('#telefonoDiv').removeClass(' has-danger');
  //     $('#telefono-error').hide();
  //   }
  // });

});

