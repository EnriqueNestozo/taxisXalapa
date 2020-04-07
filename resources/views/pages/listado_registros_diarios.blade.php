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
                  <th>Quien lo registró</th>
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
<style>

</style>
@push('js')
<script>
  $(document).ready(function() {
    cargarListado();
    obtenerListadoClavesTaxis();
    obtenerListadoPersonas();
    $('.clave').select2();
    $('#telefono').mask('000-000-00-00');
    $('#celular').mask('000-000-00-00');
    $.when( 
      $.ajax( "{{route('api.get.municipios')}}" ),
      $.ajax( "{{route('api.get.municipios')}}"  ))
      .done(function ( v1, v2 ) {
      console.log("municipios",  v1[0] );
      // $.each(v1[0], function(key,value){
      //   $('#municipioSelect')
      // });
      $('#municipioSelect').select2({data:v1[0]}).trigger('change');
    });

    $('#modalRegistroDiario').on('hidden.bs.modal', function () {
      $('#registroDiarioForm').trigger("reset");
      $('#persona').prop('disabled',false);
      $('#direccion').prop('disabled',false);
      $('#referencia').prop('disabled',false);
      $('#telefono').prop('disabled',false);
      $('#celular').prop('disabled',false);
      $('#personaSelect').prop('disabled',false);
      $('#direccionSelect').prop('disabled',false);
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
          $('#direccionSelect').empty();
          $('#personaSelect').prop('disabled',true);
          html = '';
          html = html + '<option value="" selected style="min-width: 300px;"> Seleccione una direccion...</option>'
          $('#direccionSelect').append(html);
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
        $('#direccionSelect').empty();
        html = '';
        html = html + '<option value="" selected style="min-width: 300px;"> Seleccione una dirección...</option>'
        $('#direccionSelect').append(html);
        $('#telefono').val('');
        $('#celular').val('');
        $('#telefono').prop('disabled',false);
        $('#celular').prop('disabled',false);
      }
    });

    $('#direccion').change(function(){
      if( $('#direccion').val() !='' || $('#direccionSelect').val() !=-''){
        $('#direccionDiv').removeClass(' has-danger');
        $('#direccion-error').hide();
        if( $('#direccion').val() !=''){
          $('#direccionSelect').prop('disabled',true);
      }
      }else{
        $('#direccionSelect').prop('disabled',false);
      }
    });

    $('#direccionSelect').change(function(){
      var data = sessionStorage.getItem('token');
      if( $('#direccion').val() !='' || $('#direccionSelect').val() !=-''){
        $('#direccionDiv').removeClass(' has-danger');
        $('#direccion-error').hide();
        if($('#direccionSelect').val() !=null ){
          $.get({
            url: routeBase+ '/api/direcciones/'+$('#direccionSelect').val(),
            dataType: 'json',
            headers: {
              'Accept': 'application/json',
              'Authorization': 'Bearer '+data,
            },
            success: function( result ) {
              $('#referencia').val(result['referencia']);
              $('#entre_calles').val(result['entre_calles']);
              console.log(result);
              $('#referencia').prop('disabled',true);
            },
            error: function(result){
              console.log(result);
            }
          });
          $('#direccion').prop('disabled',true);
      }
      }else{
        $('#direccion').prop('disabled',false);
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

  } );

  function cargarListado(){
    var data = sessionStorage.getItem('token');
    $('#listado').DataTable({
      processing: true,
      serverSide: true,
      searching: true,
      destroy: true,
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
          {data: 'id', name: 'id'},
          {data: 'hora', name: 'hora'},
          {data: "cliente.nombre", name: 'cliente.nombre'},
          {data: "direccion.calle", name: 'direccion.calle'},
          {data: 'unidad.numero_economico', name: 'unidad.numero_economico', "defaultContent":""},
          {data: 'user.name'},
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
          $('#personaSelect').empty();
          html = '';
          html = html + '<option value="" selected style="min-width: 300px;"> Seleccione una persona...</option>'
          for (let index = 0; index < result.length; index++) {
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
    var personaid = $('#personaSelect').val();
    $('#direccionSelect').empty();
    $.get({
        url: routeBase+"/api/get-direcciones/"+personaid,
        dataType: 'json',   
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer '+data,
        },
      success: function( result ) {
        html = '';
        html = html + '<option value="" selected style="min-width: 300px;"> Seleccione una dirección...</option>'
        for (let index = 0; index < result.length; index++) {
          html += '<option ';
          html += ' value="'+result[index].id+'" ';
          html += '>'+result[index].calle+'</option>';
        }
        $('#direccionSelect').append(html);
      },
      error: function(result){
        console.log(result);
      }
    });
  }

  function editarRegistro(id_registro){
    var data = sessionStorage.getItem('token');
    $.get({
        url: routeBase+"/api/registros-diarios/"+id_registro,
        dataType: 'json',   
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer '+data,
        },
      success: function( result ) {
        let registro = result[0];
        let clientes = result[1];
        let direcciones = result[2];
        let unidades = result[3];
        $('#hora').val(registro['hora']);
        $('#personaSelect').val(registro['cliente_id']).trigger('change');
        $('#personaSelect').prop('disabled',true);
        $('#persona').prop('disabled',true);
        setTimeout(function(){
          $('#direccionSelect').val(registro['direccion_id']).trigger('change');
          var objeto = direcciones.filter(obj => {
            return obj['id'] == $('#direccionSelect').val()
          });
          console.log(objeto[0]['referencia']);
          $('#referencia').val(objeto[0]['referencia']);
          $('#entre_calles').val(objeto[0]['entre_calles']);
          
        }, 1000);
        
        $('#telefono').val(clientes['telefono_fijo']).trigger('change');
        $('#celular').val(clientes['celular']).trigger('change');
        if(registro['unidad_id']!=null){
          $('#unidad').val(registro['unidad_id']).trigger('change');
        }
        $('#idRegistro').val(registro['id']);
        $('#idCliente').val(registro['cliente_id']);
      },
      error: function(result){
        console.log(result);
      }
    });
    $('#modalRegistroDiario').modal('show');
  }

  function eliminarRegistro(id_registro){
    var data = sessionStorage.getItem('token');
    swal({
            title: '¿Esta seguro que desea eliminar el registro?',
            text: "El registro se eliminará de manera permanente!",
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
                url: "{{route('api.delete.registro')}}",
                data:{
                  idRegistro: id_registro,
                },   
                dataType: 'json',
                headers: {
                  'Accept': 'application/json',
                  'Authorization': 'Bearer '+data,
                },
                success: function( result ) {
                  md.showNotification('bottom','right','success','Registro eliminado correctamente');
                  cargarListado();
                },
                error: function(result){
                  console.log(result);
                  md.showNotification('bottom','right','danger','Ha ocurrido un error al eliminar el registro');
                }
              });
            }
          })
    
  }

  function desplegarModalRegistro(){
    $('#personaSelect').val('').trigger('change');
    $('#modalRegistroDiario').modal("show");
    
  }

  function registrarViaje(){
    if(validarDatos() == 0 ){
      console.log("registra");
      var data = sessionStorage.getItem('token');
      var arrayDeDatos = $("#registroDiarioForm").serializeArray();
      arrayDeDatos.push({name:'idUser', value:sessionStorage.getItem('user')});

      $.post({
        url: "{{route('api.registros.diarios.create')}}",
        data: arrayDeDatos,
        dataType: 'json',
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer '+data,
        },
        success: function( result ) {
          $("#registroDiarioBtn").html("Registrar");
          $("#registroDiarioBtn").prop('disabled', false);
          $('#registroDiarioForm').trigger("reset");
          $('#modalRegistroDiario').modal('hide');
          $('#direccionSelect').empty();
          html = '';
          html = html + '<option value="" selected style="min-width: 300px;"> Seleccione una direccion...</option>'
          $('#direccionSelect').append(html);
          console.log("success registro");
          cargarListado();
          obtenerListadoPersonas();
          $('#personaSelect').prop('disabled',false);
          $('#direccionSelect').prop('disabled',false);
          $('#persona').prop('disabled',false);
          $('#direccion').prop('disabled',false);
          $('#idRegistro').val('');
          $('#idCliente').val('');
          md.showNotification('bottom','right','success','Registro creado correctamente');
        },
        error: function(result){
          console.log(result);
          $("#registroDiarioBtn").html("Registrar");
          $("#registroDiarioBtn").prop('disabled', false);
          md.showNotification('bottom','right','danger','Ha ocurrido un error al crear el registro');
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
    if($('#hora').val() =='' || ( $('#persona').val() =='' && $('#personaSelect').val() == null  ) || ( $('#direccion').val() =='' && $('#direccionSelect').val() == null ) || ( $('#telefono').val() == '' && $('#celular').val()=='')  ){
      marcarErrores();
      console.log("faltan datos");
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
    // $('#entre_callesDiv').removeClass('has-danger');
    // $('#entre_calles-error').hide();
    // $('#referenciaDiv').removeClass('has-danger');
    // $('#referencia-error').hide();
    $('#telefonoDiv').removeClass('has-danger');
    $('#telefono-error').hide();
    $('#celularDiv').removeClass('has-danger');
    $('#celular-error').hide();
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
    if( $('#direccion').val() =='' && $('#direccionSelect').val() == ''  ){
      $('#direccionDiv').addClass('has-danger');
      $('#direccion-error').show();
    }
    // if( $('#entre_calles').val()=='' ){
    //   $('#entre_callesDiv').addClass('has-danger');
    //   $('#entre_calles-error').show();
    // }
    // if( $('#referencia').val() =='' ){
    //   $('#referenciaDiv').addClass('has-danger');
    //   $('#referencia-error').show();
    // }
    if( $('#telefono').val() == '' && $('#celular').val() == '' ){
      $('#telefonoDiv').addClass('has-danger');
      $('#telefono-error').show();
      $('#celularDiv').addClass('has-danger');
      $('#celular-error').show();
    }
    // if( $('#celular').val() == '' ){
    //   $('#celularDiv').addClass('has-danger');
    //   $('#celular-error').show();
    // }
  }
</script>
@endpush