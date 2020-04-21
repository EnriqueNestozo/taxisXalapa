@extends('layouts.app', ['activePage' => 'listado_servicios', 'titlePage' => __('Servicios activos')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
          <button class="btn btn-primary pull-right" onClick="desplegarModalServicio()">Agregar servicio</button>
            <h4 class="card-title ">Servicios registrados</h4>
            <p class="card-category">Listado de registros</p>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="listado" class="table-hover"  style="width:100%">
                <thead>
                  <tr>
                    <th style="width:25%;">No. servicio</th>
                    <th style="width:25%;">Cliente</th>
                    <th style="width:25%;">Dirección</th>
                    <th style="width:25%;">Quien registró</th>
                    <th style="width:25%;">Acciones</th>
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
@include('modals.modalServicios')
@endsection
@push('js')
<script>
  //Variables globales de rutas
  var rutaListadoServicios = "{{route('api.servicios.list')}}";
  var rutaListadoClavesTaxis = "{{route('api.get.unidades')}}";
  var rutaListadoClientes= "{{route('api.get.clientes')}}";
  var rutaBorradoServicios= "{{route('api.servicio.delete')}}";
  var rutaCrearServicio= "{{route('api.servicios.create')}}";
  var rutaListadoMunicipios= "{{route('api.get.municipios')}}";
</script>
<script src="{{ asset('js') }}/listado_servicios/listado_servicio.js"></script>
<script src="{{ asset('js') }}/listado_servicios/funciones_listado_servicio.js"></script>
@endpush