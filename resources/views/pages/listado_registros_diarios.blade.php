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
                  <th style="width:10%;">N. Registro</th>
                  <th style="width:10%;">Hora</th>
                  <th style="width:15%;">Persona</th>
                  <th style="width:20%;">Dirección</th>
                  <th style="width:10%;">Clave</th>
                  <th style="width:15%;">Quien lo registró</th>
                  <th style="width:20%;">Acciones</th>
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

  
 .custom-control-label {
    position: relative;
    margin-bottom: 0;
    vertical-align: top;
}
.custom-control-input {
    position: absolute;
    z-index: -1;
    opacity: 0;
}

.custom-control-input:checked~.custom-control-label::before {
    color: #fff;
    border-color: #8a063c;
    background-color: #8a063c;
}
.custom-switch .custom-control-label::before {
    left: -2.25rem;
    width: 1.75rem;
    pointer-events: all;
    border-radius: .5rem;
}
.custom-control-label::before, .custom-file-label, .custom-select {
    transition: background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
.custom-control-label::before {
    position: absolute;
    top: .25rem;
    left: -1.5rem;
    display: block;
    width: 1rem;
    height: 1rem;
    pointer-events: none;
    content: "";
    background-color: #fff;
    border: #adb5bd solid 1px;
}
.custom-switch .custom-control-input:checked~.custom-control-label::after {
    background-color: #fff;
    -webkit-transform: translateX(.75rem);
    transform: translateX(.75rem);
}
.custom-switch .custom-control-label::after {
    top: calc(.25rem + 2px);
    left: calc(-2.25rem + 2px);
    width: calc(1rem - 4px);
    height: calc(1rem - 4px);
    background-color: #adb5bd;
    border-radius: .5rem;
    transition: background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-transform .15s ease-in-out;
    transition: transform .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    transition: transform .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-transform .15s ease-in-out;
}
.custom-control-label::after {
    position: absolute;
    top: .25rem;
    left: -1.5rem;
    display: block;
    width: 1rem;
    height: 1rem;
    content: "";
    background: no-repeat 50%/50% 50%;
}
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