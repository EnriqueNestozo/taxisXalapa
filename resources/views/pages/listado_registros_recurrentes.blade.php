@extends('layouts.app', ['activePage' => 'listado_registros_recurrentes', 'titlePage' => __('Registros recurrentes')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <!-- <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Servicios pendientes</h4>
            <p class="card-category"> Listado de servicios pendientes</p>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="listadoServiciosPendientes" class="table-hover"  style="width:100%">
                <thead class=" text-primary">
                  <tr>
                    <th style="width:25%;">No. servicio</th>
                    <th style="width:25%;">Cliente</th>
                    <th style="width:25%;">Dirección</th>
                    <th style="width:25%;">Acciones</th>
                  </tr>
                    
                </thead>
                <tbody>              
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      
    </div> -->
    <div class="row">
      <div class="col-md-12">
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
      </div>
      
    </div>
  </div>
</div>
@endsection