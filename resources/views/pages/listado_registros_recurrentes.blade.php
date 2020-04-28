@extends('layouts.app', ['activePage' => 'listado_registros_recurrentes', 'titlePage' => __('Registros recurrentes')])

@section('content')
<div class="content">
  <div class="container-fluid">
    
    <div class="row">


    <div class="col-lg-12 col-md-12">
          <div class="card">
            <div class="card-header card-header-tabs card-header-primary">
              <div class="nav-tabs-navigation">
                <div class="nav-tabs-wrapper">
                  <!-- <span class="nav-tabs-title">Registros recurrentes:</span> -->
                  <ul class="nav nav-tabs" data-tabs="tabs">
                    <li class="nav-item tab-r">
                      <a class="nav-link active" href="#pendientes" data-toggle="tab" id="tab-pendientes">
                        <i class="material-icons" style="font-size: 24px;">assignment_late</i> Servicios pendientes
                        <div class="ripple-container"></div>
                      </a>
                    </li>
                    <li class="nav-item tab-r" >
                      <a class="nav-link" href="#registros-recurrentes" data-toggle="tab" id="tab-registros">
                        <i class="material-icons" style="font-size: 24px;">list</i> Registros recurrentes
                        <div class="ripple-container"></div>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="tab-content">
                <div class="tab-pane active" id="pendientes">
                  <table id="listadoServiciosPendientes" class="table-hover"  style="width:100%">
                    <thead>
                      <tr>
                        <th style="width:10%;">No. servicio</th>
                        <th style="width:15%;">Hora</th>
                        <th style="width:25%;">Cliente</th>
                        <th style="width:25%;">Dirección</th>
                        <!-- <th style="width:25%;">Estatus</th> -->
                        <th style="width:25%;">Acciones</th>
                      </tr>
                    </thead>
                      
                    <tbody>
                      
                    </tbody>
                  </table>
                </div>
                <div class="tab-pane" id="registros-recurrentes">
                  <table id="listadoRegistrosRecurrentes" class="table-hover"  style="width:100%">
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


      <!-- <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Registros recurrentes</h4>
            <p class="card-category"> Listado de registros recurrentes</p>
          </div>
          <div class="card-body">
            <div class="table-responsive">
            <table id="listadoRegistrosRecurrentes" class="table-hover"  style="width:100%">
                <thead class=" text-primary">
                  <tr>
                    <th style="width:25%;">No. registro</th>
                    <th style="width:25%;">Hora</th>
                    <th style="width:25%;">Cliente</th>
                    <th style="width:25%;">Dirección</th>
                    <th style="width:25%;">Unidad</th>
                    <th style="width:25%;">Estatus</th>
                    <th style="width:25%;">Acciones</th>
                  </tr>
                    
                </thead>
                <tbody>              
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div> -->
      
    </div>
  </div>
</div>
@include('modals.modalRegistroDiario')
@endsection
@push('js')
<script>
  //Variables globales de rutas
  var rutaListadoServiciosPendientes = "{{route('api.servicios.pendientes.list')}}";
  var rutaListadoClavesTaxis = "{{route('api.get.unidades')}}";
  var rutaListadoClientes= "{{route('api.get.clientes')}}";
  var rutaBorradoServicios= "{{route('api.servicio.delete')}}";
  var rutaCrearServicio= "{{route('api.servicios.create')}}";
  var rutaListadoMunicipios= "{{route('api.get.municipios')}}";
  var rutaCrearRegistroDiario= "{{route('api.registros.diarios.create')}}";
</script>
<script src="{{ asset('js') }}/listado_recurrentes/listado_recurrentes.js"></script>
<script src="{{ asset('js') }}/listado_recurrentes/funciones_listado_recurrente.js"></script>
@endpush