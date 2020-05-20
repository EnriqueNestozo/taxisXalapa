var table = null;
$(document).ready(function() {
    $('.clave').select2();
    $('#telefono_referencia').mask('000-000-00-00');
    $('#telefono_emergencia_referencia').mask('000-000-00-00');
    $('#telefono_fijo').mask('000-000-00-00');
    $('#celular').mask('000-000-00-00');
    table  = cargarListado();
    cargarListadoConductores();

    $('#placas').change(function(){
      if( $('#placas').val() !=''){
        $('#placas-error').hide();
        $('#placasDiv').removeClass(' has-danger');
      }
    });

    $('#marca').change(function(){
      if( $('#marca').val() !=''){
        $('#marca-error').hide();
        $('#marcaDiv').removeClass(' has-danger');
      }
    });

    $('#modelo').change(function(){
      if( $('#modelo').val() !=''){
        $('#modelo-error').hide();
        $('#modeloDiv').removeClass(' has-danger');
      }
    });

    $('#numero').change(function(){
      if( $('#numero').val() != '' ){
        $('#numero-error').hide();
        $('#numeroDiv').removeClass(' has-danger');
      }
    });

    $('#numero_economico').change(function(){
      if( $('#numero_economico').val() !='' ){
        $('#numero_economico-error').hide();
        $('#numero_economicoDiv').removeClass(' has-danger');
      }
    });

    $('#baseSelect').change(function(){
      if( $('#baseSelect').val() !='' ){
        $('#base-error').hide();
        $('#baseDiv').removeClass(' has-danger');
      }
    });

    $('#modalDatosUnidad').on('hidden.bs.modal', function () {
      $('#datosUnidadForm').trigger("reset");
      // cargarListadoChoferes();
    });

    $('#modalRelacionConductorUnidad').on('hidden.bs.modal', function () {
      $('#conductorSelect').val('').trigger('change');
      $('#turnoSelect').val('').trigger('change');
      $('#baseSelect').val('').trigger('change');
    });

    $('#modalRegistroConductor').on('hidden.bs.modal', function () {
      $('#datosConductorForm').trigger("reset");
      $('#previewFotoPersona').attr('src','http://placehold.it/250');
      $('#previewElector').attr('src', 'http://placehold.it/250');
      $('#previewLicencia').attr('src', 'http://placehold.it/250');
      $('#previewReversoElector').attr('src', 'http://placehold.it/250');
      $('#previewReversoLicencia').attr('src', 'http://placehold.it/250');
    });

    $('#listado tbody').on('click', 'td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = table.row( tr );
      let elemento = tr[0].lastChild.lastChild.attributes.onClick.nodeValue;
      re = /\((.*)\)/;
      let idUnidad = elemento.match(re)[1]
      // console.log(idUnidad);
      ///OBTENER EL ID DE LA UNIDAD PRESIONADA PARA MANDAR A TRAER SUS CONDUCTORES
      
      if ( row.child.isShown() ) {
          // This row is already open - close it
          row.child.hide();
          tr.removeClass('shown');
      }
      else {
        $.get({
          url: routeBase+'/api/unidad-conductor/'+idUnidad,
          dataType: 'json',
          headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer '+sessionStorage.getItem('token'),
          },
          success: function(result){
              // console.log(result[0].conductores);
              if(result[0].conductores.length > 0){
                  row.child( format(result[0].conductores) ).show();
                  tr.addClass('shown');
              }else{
                row.child( format(null) ).show();
                tr.addClass('shown');
              }
          },
          error: function(result){
            console.log(result);
            md.showNotification('bottom','right','danger','Ha ocurrido un error al cargar los datos de la unidad');
          }
        });
        
      }
    });

    //Falta cuando cambie select de conductor

} );