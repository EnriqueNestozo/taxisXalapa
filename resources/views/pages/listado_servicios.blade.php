@extends('layouts.app', ['activePage' => 'listado_servicios', 'titlePage' => __('Servicios activos')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
          <button class="btn btn-primary pull-right" onClick="desplegarModalUnidad()">Agregar unidad</button>
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
@include('modals.modalUnidades')
@endsection