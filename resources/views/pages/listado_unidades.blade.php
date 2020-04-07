@extends('layouts.app', ['activePage' => 'listado_unidades', 'titlePage' => __('Unidades')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
          <button class="btn btn-primary pull-right" onClick="desplegarModalUnidad()">Agregar unidad</button>
            <h4 class="card-title ">Unidades registradas</h4>
            <p class="card-category">Listado de unidades</p>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="listado" class="table-hover"  style="width:100%">
                <thead>
                  <tr>
                    <th>Placa</th>
                    <th>Número</th>
                    <th>Clave</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                    
                </tbody>
                <tfoot>
                    
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@include('modals.modalUnidades')
@endsection
@push('js')
<script>
  $(document).ready(function() {
    $('.clave').select2();
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
        url: "{{route('api.unidades.list')}}",
        type: "GET",
        dataType: 'json',
        headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer '+data,
        }
      },
      columns: [
          {data: 'placas', name: 'placas'},
          {data: "numero", name: 'numero', "defaultContent":""},
          {data: 'numero_economico', name: 'numero_economico', "defaultContent":""},
          {data: 'action', name:'action'}
      ]
    });
  }

  function registrarDatosUnidad(){
    limpiarErrores();
    if(validarCampos()){
      $("#registroUnidadbtn").html("Cargando...");
      $("#registroUnidadbtn").prop('disabled', true);
      $.post({
        url: "{{route('api.create.unidad')}}",
        data:$("#datosUnidadForm").serialize(),
        dataType: 'JSON',
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer '+sessionStorage.getItem('token')
        },
        success: function(result){
          md.showNotification('bottom','right','success','Unidad creado correctamente');
          cargarListado();
          limpiarCampos();
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

  function editarUnidad(id_unidad){
    $.get({
      url: routeBase+'/api/unidades/'+id_unidad,
      dataType: 'json',
      headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer '+sessionStorage.getItem('token'),
      },
      success: function(result){
        $('#idUnidad').val( result['id'] );
        $('#placas').val( result['placas'] );
        $('#numero').val( result['numero'] );
        $('#numero_economico').val( result['numero_economico'] );
        //Falta cargar las unidades
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
          url: "{{route('api.delete.unidad')}}",
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
            cargarListado();
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

  function limpiarCampos(){
    $('#datosUnidadForm').trigger("reset");
  }

  
</script>
@endpush