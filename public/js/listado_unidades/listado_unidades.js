$(document).ready(function() {
    $('.clave').select2();
    $('#telefono_referencia').mask('000-000-00-00');
    $('#telefono_emergencia_referencia').mask('000-000-00-00');
    $('#telefono_fijo').mask('000-000-00-00');
    $('#celular').mask('000-000-00-00');
    var table  = cargarListado();


    $('#placas').change(function(){
      if( $('#placas').val() !=''){
        $('#placas-error').hide();
        $('#placasDiv').removeClass(' has-danger');
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

    $('#modalDatosUnidad').on('hidden.bs.modal', function () {
      $('#datosUnidadForm').trigger("reset");
      cargarListadoChoferes();
    });
    // $('#modalRegistroConductor').on('hidden.bs.modal', function () {
    //   $('#datosConductorForm').trigger("reset");
    // });

    $('#listado tbody').on('click', 'td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = table.row( tr );
      console.log(tr);

      ///OBTENER EL ID DE LA UNIDAD PRESIONADA PARA MANDAR A TRAER SUS CONDUCTORES
      $.get({
        url: routeBase+'/api/unidades',
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
      if ( row.child.isShown() ) {
          // This row is already open - close it
          row.child.hide();
          tr.removeClass('shown');
      }
      else {
          // Open this row
          row.child( format(row.data()) ).show();
          tr.addClass('shown');
      }
    });

    //Falta cuando cambie select de conductor

} );