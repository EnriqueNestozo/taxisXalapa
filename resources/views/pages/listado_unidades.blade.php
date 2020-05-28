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
                    <th style="width:5%;"></th>
                    <th style="width:15%;">Placa</th>
                    <th style="width:15%;">N. radio</th>
                    <th style="width:10%;">Base</th>
                    <th style="width:15%;">N. económico</th>
                    <th style="width:15%;">Conductores asignados</th>
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

    <br>
    
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
          <button class="btn btn-primary pull-right" onClick="desplegarModalConductor()">Agregar conductor</button>
            <h4 class="card-title ">Conductores registrados</h4>
            <p class="card-category">Listado de conductores</p>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="listadoConductores" class="table-hover"  style="width:100%">
                <thead>
                  <tr>
                    <th style="width:35%;">Nombre completo</th>
                    <th style="width:15%;">Celular</th>
                    <th style="width:15%;">Vencimiento de licencia</th>
                    <th style="width:15%;">Unidad(es)</th>
                    <th style="width:20%;">Acciones</th>
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
@include('modals.modalRelacionConductorUnidad')
@endsection
@push('js')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
  var rutaListadoUnidades = "{{route('api.unidades.list')}}";
  var rutaRegistroUnidad = "{{route('api.create.unidad')}}";
  var rutaEliminadoUnidad = "{{route('api.delete.unidad')}}";
  var rutaRegistroConductor = "{{route('api.create.conductor')}}";
  var rutaListadoConductores = "{{route('api.conductores.get.list')}}";
  var rutaEliminadoConductorUnidad = "{{route('api.conductores.conductorunidad.delete')}}";
  var rutaEliminadoConductor = "{{route('api.delete.conductor')}}";
  $('#vencimiento').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    minYear: 2015,
    maxYear: parseInt(moment().format('YYYY'),10),
    locale:{
      "applyLabel": "Aplicar",
      "cancelLabel": "Cancelar",
      "fromLabel": "Desde",
      "toLabel": "Hasta",
      "customRangeLabel": "Personalizado",
      "daysOfWeek": [
        "Dom",
        "Lu",
        "Mar",
        "Mie",
        "Jue",
        "Vie",
        "Sa"
      ],
      "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octobre",
            "Noviembre",
            "Diciembre"
          ],
    },function(start, end, label){
      $(this).html(start.format('YYYY-MM-D'));
    }
  });
</script>
<script src="{{ asset('js') }}/listado_unidades/listado_unidades.js"></script>
<script src="{{ asset('js') }}/listado_unidades/funciones_listado_unidades.js"></script>
@endpush