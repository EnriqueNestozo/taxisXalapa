@extends('layouts.app', ['activePage' => 'listado_unidades', 'titlePage' => __('Unidades')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <button class="btn btn-primary pull-right" onClick="desplegarModalUnidad()">Agregar unidad</button>
            <button class="btn btn-primary pull-right" onClick="desplegarModalConductor()">Agregar conductor</button>
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
@include('modals.modalConductor')
@endsection
@push('js')
<script>
  var rutaListadoUnidades = "{{route('api.unidades.list')}}";
  var rutaRegistroUnidad = "{{route('api.create.unidad')}}";
  var rutaEliminadoUnidad = "{{route('api.delete.unidad')}}";
  var rutaRegistroConductor = "{{route('api.create.conductor')}}";
</script>
<script src="{{ asset('js') }}/listado_unidades/listado_unidades.js"></script>
<script src="{{ asset('js') }}/listado_unidades/funciones_listado_unidades.js"></script>
@endpush