@extends('layouts.app', ['activePage' => 'listado_registros_diarios', 'titlePage' => __('Registros diarios')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
              <button class="btn btn-primary pull-right" onClick="desplegarModalRegistro()">Agregar registro</button>
            <h4 class="card-title ">Registros diarios</h4>
            <p class="card-category"> Listado de registros diarios</p>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="listado" class="table-hover"  style="width:100%">
                <thead>
                  <th>N. Registro</th>
                  <th>Hora</th>
                  <th>Persona</th>
                  <th>Dirección</th>
                  <th>Clave</th>
                  <th>Acciones</th>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@include('modals.modalRegistroDiario')
@endsection
@push('js')
<script>
  $(document).ready(function() {
    cargarListado();
    obtenerListadoClavesTaxis();
    obtenerListadoPersonas();
    $('.clave').select2();
    
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
      }
    });

    $('#personaSelect').change(function(){
      if( $('#persona').val() !='' || $('#personaSelect').val() != '' ){
        $('#personaDiv').removeClass('has-danger');
        $('#persona-error').hide();
        if( $('#personaSelect').val() !='' ){
          obtenerListadoDirecciones();
        }
      }
    });

    $('#direccion').change(function(){
      if( $('#direccion').val() !='' || $('#direccionSelect').val() !=-''){
        $('#direccionDiv').removeClass(' has-danger');
        $('#direccion-error').hide();
      }
    });

    $('#entre_calles').change(function(){
      if( $('#entre_calles').val() !='' ){
        $('#entre_callesDiv').removeClass(' has-danger');
        $('#entre_calles-error').hide();
      }
    });

    $('#referencia').change(function(){
      if( $('#referencia').val() !='' ){
        $('#referenciaDiv').removeClass(' has-danger');
        $('#referencia-error').hide();
      }
    });


    $('#telefono').change(function(){
      if( $('#telefono').val() != '' ){
        $('#telefonoDiv').removeClass(' has-danger');
        $('#telefono-error').hide();
      }
    });

    $('#celular').change(function(){
      if( $('#celular').val() != '' ){
        $('#celularDiv').removeClass(' has-danger');
        $('#celular-error').hide();
      }
    });

  } );

  function cargarListado(){
    var data = sessionStorage.getItem('token');
    $('#listado').DataTable({
      processing: true,
      serverSide: true,
      searching: true,
      language: {
        url: routeBase+'/DataTables/DataTable_Spanish.json'
      },
      ajax: {
        url: "{{route('api.registros.diarios.list')}}",
        type: "GET",
        dataType: 'json',
        headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer '+data,
        }
      },
      columns: [
          {data: 'num_registro', name: 'num_registro'},
          {data: 'hora', name: 'hora'},
          {data: "persona", name: 'persona'},
          {data: "direccion", name: 'direccion'},
          {data: 'claveTaxi', name: 'claveTaxi'},
          {data: 'action', name:'action'}
      ]
    });
  }

  function obtenerListadoClavesTaxis(){
    var data = sessionStorage.getItem('token');
    $.get({
        url: "{{route('api.get.unidades')}}",
        dataType: 'json',
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer '+data,
        },
        success: function( result ) {
          $('#clave').empty();
          html = '';
          html = html + '<option value="" selected style="min-width: 300px;"> Seleccione una clave...</option>'
          for (let index = 0; index < result.length; index++) {
            html += '<option ';
            html += ' value="'+result[index].id+'" ';
            html += '>'+result[index].numero_economico+'</option>';
          }
          $('#clave').append(html);
        },
        error: function(result){
          console.log(result);
        }
    });
  }

  function obtenerListadoPersonas(){
    var data = sessionStorage.getItem('token');
    $.get({
        url: "{{route('api.get.clientes')}}",
        dataType: 'json',
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer '+data,
        },
        success: function( result ) {
          console.log();
          $('#personaSelect').empty();
          html = '';
          html = html + '<option value="" selected style="min-width: 300px;"> Seleccione una persona...</option>'
          for (let index = 0; index < result.length; index++) {
            console.log("a",result[index]);
            html += '<option ';
            html += ' value="'+result[index].id+'" ';
            html += '>'+result[index].nombre+'</option>';
          }
          $('#personaSelect').append(html);
        },
        error: function(result){
          console.log(result);
        }
    });
  }

  function obtenerListadoDirecciones(){
    var data = sessionStorage.getItem('token');
    $.get({
        url: "{{route('api.get.direcciones',"+ $('#personaSelect').val() +" )}}",
        dataType: 'json',
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer '+data,
        },
      success: function( result ) {
        $('#direccionSelect').empty();
        html = '';
        html = html + '<option value="" selected style="min-width: 300px;"> Seleccione una dirección...</option>'
        for (let index = 0; index < result.length; index++) {
          html += '<option ';
          html += ' value="'+result[index].id+'" ';
          html += '>'+result[index].nombre+'</option>';
        }
        $('#direccionSelect').append(html);
      },
      error: function(result){
        console.log(result);
      }
    });
  }

  function editarRegistro(id_registro){
    console.log(id_registro);
  }

  function eliminarRegistro(id_registro){
    console.log(id_registro);
  }

  function desplegarModalRegistro(){
    $('#modalRegistroDiario').modal("show");
    
  }

  function registrarViaje(){
    if(validarDatos() == 0 ){
      var data = sessionStorage.getItem('token');
      $.post({
        url: "{{route('api.registros.diarios.create')}}",
        data:$("#registroDiarioForm").serialize(),
        dataType: 'json',
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer '+data,
        },
        success: function( result ) {
          console.log(result);
          $("#registroDiarioBtn").html("Registrar");
          $("#registroDiarioBtn").prop('disabled', false);
        },
        error: function(result){
          console.log(result);
          $("#registroDiarioBtn").html("Registrar");
          $("#registroDiarioBtn").prop('disabled', false);
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
    if($('#hora').val() =='' || ( $('#persona').val() =='' && $('#personaSelect').val() == null  ) || ( $('#direccion').val() =='' && $('#direccionSelect').val() == null ) ||  $('#entre_calles').val() =='' || $('#referencia').val() =='' || $('#telefono').val() == ''  ){
      marcarErrores();
      datosErroneos = 1;
    }
    return datosErroneos;
  }

  function limpiarErrores(){
    $('#horaDiv').removeClass(' has-danger');
    $('#hora-error').hide();
    $('#personaDiv').removeClass('has-danger');
    $('#persona-error').hide();
    $('#direccionDiv').removeClass('has-danger');
    $('#direccion-error').hide();
    $('#entre_callesDiv').removeClass('has-danger');
    $('#entre_calles-error').hide();
    $('#referenciaDiv').removeClass('has-danger');
    $('#referencia-error').hide();
  }

  function marcarErrores(){
    if($('#hora').val() ==''){
      $('#horaDiv').addClass(' has-danger');
      $('#hora-error').show();
    }
    if( $('#persona').val() =='' && $('#personaSelect').val() == '' ){
      $('#personaDiv').addClass('has-danger');
      $('#persona-error').show();
    }
    if( $('#direccion').val() =='' && $('#direccion').val() == ''  ){
      $('#direccionDiv').addClass('has-danger');
      $('#direccion-error').show();
    }
    if( $('#entre_calles').val()=='' ){
      $('#entre_callesDiv').addClass('has-danger');
      $('#entre_calles-error').show();
    }
    if( $('#referencia').val() =='' ){
      $('#referenciaDiv').addClass('has-danger');
      $('#referencia-error').show();
    }
    if( $('#telefono').val() == '' ){
      $('#telefonoDiv').addClass('has-danger');
      $('#telefono-error').show();
    }
    if( $('#celular').val() == '' ){
      $('#celularDiv').addClass('has-danger');
      $('#celular-error').show();
    }
  }
</script>
@endpush