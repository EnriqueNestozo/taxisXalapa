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
  //Variables globales de rutas
  var rutaListadoRegistrosDiarios = "{{route('api.registros.diarios.list')}}";
  var rutaListadoClavesTaxis = "{{route('api.get.unidades')}}";
  var rutaListadoClientes= "{{route('api.get.clientes')}}";
  var rutaBorradoRegistros= "{{route('api.delete.registro')}}";
  var rutaCrearRegistroDiario= "{{route('api.registros.diarios.create')}}";
  var rutaListadoMunicipios= "{{route('api.get.municipios')}}";
</script>
<script src="{{ asset('js') }}/listado_registro/listado_registro.js"></script>
<script src="{{ asset('js') }}/listado_registro/funciones_listado_registro.js"></script>
@endpush