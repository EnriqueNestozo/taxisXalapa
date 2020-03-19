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
    $('.clave').select2();
    
    $('#hora').focusout(function(){
      if( $('#hora').val() !='' ){
        $('#horaDiv').removeClass(' has-danger');
        $('#hora-error').hide();
      }
    });

    $('#persona').change(function(){
      if( $('#persona').val() !='' || $('#personaSelect').val() != -1 ){
        $('#personaDiv').removeClass('has-danger');
        $('#persona-error').hide();
      }
    });

    $('#personaSelect').change(function(){
      if( $('#persona').val() !='' || $('#personaSelect').val() != -1 ){
        $('#personaDiv').removeClass('has-danger');
        $('#persona-error').hide();
      }
    });

    $('#direccion').change(function(){
      if( $('#direccion').val() !='' ){
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

    $('#clave').change(function(){
      if( $('#clave').val() !=-1 ){
        $('#claveDiv').removeClass(' has-danger');
        $('#clave-error').hide();
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

  function editarRegistro(id_registro){
    console.log(id_registro);
  }

  function eliminarRegistro(id_registro){
    console.log(id_registro);
  }

  function desplegarModalRegistro(){
    $('#modalRegistroDiario').modal("show");
    console.log("se muestra");
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
    if($('#hora').val() =='' || ( $('#persona').val() =='' && $('#personaSelect').val() == -1  ) || $('#direccion').val() =='' ||  $('#entre_calles').val() =='' || $('#referencia').val() =='' || $('#clave').val() == -1  ){
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
    $('#claveDiv').removeClass('has-danger');
    $('#clave-error').hide();
  }

  function marcarErrores(){
    if($('#hora').val() ==''){
      $('#horaDiv').addClass(' has-danger');
      $('#hora-error').show();
    }
    if( $('#persona').val() =='' && $('#personaSelect').val() == -1 ){
      $('#personaDiv').addClass('has-danger');
      $('#persona-error').show();
    }
    if( $('#direccion').val() =='' ){
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
    if( $('#clave').val() == -1 ){
      $('#claveDiv').addClass('has-danger');
      $('#clave-error').show();
    }
  }
</script>
@endpush