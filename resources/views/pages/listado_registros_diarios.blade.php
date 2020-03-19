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
    $('.js-example-basic-single').select2();
  } );

  function cargarListado(){
    var data = sessionStorage.getItem('token');
    // var token = 'aab1846e14a2a7d487234332faa9431fdf01e9e9635858f9a815e9815080e5f531c360a9f08af152';
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
</script>
@endpush