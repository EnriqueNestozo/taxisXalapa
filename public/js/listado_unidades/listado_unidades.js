$(document).ready(function() {
    $('.clave').select2();
    $('#telefono_referencia').mask('000-000-00-00');
    $('#telefono_emergencia_referencia').mask('000-000-00-00');
    $('#telefono_fijo').mask('000-000-00-00');
    $('#celular').mask('000-000-00-00');
    cargarListado();

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

    $('#modalRegistroDiario').on('hidden.bs.modal', function () {
      limpiarCampos();
    });

    //Falta cuando cambie select de conductor

} );