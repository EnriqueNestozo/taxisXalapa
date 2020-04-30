@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Reportes')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row" id="cardsReportes">
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats" onclick="desplegarReporteMensualServicios()" style="cursor: pointer;">
              <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                  <i class="material-icons">description</i>
                </div>
                <div style="text-align:center; padding-top:1em">
                  <h4 class="card-title" >Reporte mensual de servicios</h4>
                </div>
              </div>
  
              <div class="card-footer">
                <div class="stats">
                  <!-- <i class="material-icons text-danger">warning</i>
                  <a href="#pablo">Get More Space...</a> -->
                </div>
              </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats" onclick="desplegarReportePorTaxi()" style="cursor: pointer;">
              <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                  <i class="material-icons">description</i>
                </div>
                <div style="text-align:center; padding-top:1em">
                  <h4 class="card-title" >Corte por número de taxi</h4>
                </div>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <!-- <i class="material-icons text-danger">warning</i>
                  <a href="#pablo">Get More Space...</a> -->
                </div>
              </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats" onclick="desplegarReporteGeneral()" style="cursor: pointer;">
              <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                  <i class="material-icons">description</i>
                </div>
                <div style="text-align:center; padding-top:1em">
                  <h4 class="card-title" >Reporte por cliente, destino, hora</h4>
                
                </div>
              </div>
  
              <div class="card-footer">
                <div class="stats">
                  <!-- <i class="material-icons text-danger">warning</i>
                  <a href="#pablo">Get More Space...</a> -->
                </div>
              </div>
            </div>
        </div>
        <!-- <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-success card-header-icon">
              <div class="card-icon">
                <i class="material-icons">store</i>
              </div>
              <p class="card-category">Revenue</p>
              <h3 class="card-title">$34,245</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">date_range</i> Last 24 Hours
              </div>
            </div>
          </div>
        </div> -->
        <!-- <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
              <div class="card-icon">
                <i class="material-icons">info_outline</i>
              </div>
              <p class="card-category">Fixed Issues</p>
              <h3 class="card-title">75</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">local_offer</i> Tracked from Github
              </div>
            </div>
          </div>
        </div> -->
        <!-- <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-info card-header-icon">
              <div class="card-icon">
                <i class="fa fa-twitter"></i>
              </div>
              <p class="card-category">Followers</p>
              <h3 class="card-title">+245</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">update</i> Just Updated
              </div>
            </div>
          </div>
        </div> -->
      </div>
      <div class="row" id="regresarAcardsReportes" style="display:none; padding-bottom:2em;" onclick="mostrarCardsReportes()">
        <div class="col-lg-4 col-md-6 col-sm-6">
          <span class="material-icons"><button class="btn" style="background-color:#cf1d66"><span class="material-icons">keyboard_return</span> Regresar</button></span>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12 col-md-12" id="tablaReporteMensual" style="display:none">
          <div class="card">
            <div class="card-header card-header-tabs card-header-primary">
              <h3>Reporte mensual de servicios</h3>
            </div>

            <div class="card-body">
              <div class="row">
              
              <div class="col-lg-4 col-md-4 col-sm-6">
                <span>Fecha</span>
                <div class="row">
                  <div class="col-lg-8 col-md-8 col-sm-8" id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%;">
                      <i class="fa fa-calendar"></i>&nbsp;
                      <span></span> <i class="fa fa-caret-down"></i>
                  </div>
                  <div class="col-log-2 col-md-2 col-sm-2">
                      <button class="btn btn-info" onclick="buscarDatos()">Consultar</button>
                  </div> 
                </div>
              </div>
              
              <div class="table-responsive">
                <table id="myTable1" class="display table-hover" style="width:100%">
                  <thead>
                    <tr>
                        <th>N. Registro</th>
                        <th>Hora</th>
                        <th>Cliente</th>
                        <th>Dirección</th>
                        <th>Unidad</th>
                        <th>Estatus</th>
                        <th>Quien registró</th>
                        <th>Tipo de servicio</th>
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

@push('js')
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap- 
datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script> -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <script>
    $(document).ready(function() {
      moment.locale('es');   
      md.initFormExtendedDatetimepickers();
      // $('#tablaReporteMensual').hide();
      $('#tablaReportePorTaxi').hide();
      
      var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        $('#reportrange span').html(start.format('D/MM/YYYY') + ' - ' + end.format('D/MM/YYYY'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
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
          "firstDay": 2
        },
        ranges: {
           'Hoy': [moment(), moment()],
           'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
           'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
           'Este mes': [moment().startOf('month'), moment().endOf('month')],
           'El mes pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    },cb );

//     function(start, end, label) {
//   console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
// }
    cb(start, end);

      // md.initDashboardPageCharts();
    });

    function desplegarReporteMensualServicios(){
      $('#cardsReportes').hide();
      $('#regresarAcardsReportes').show();
      console.log("desplegado");
      $('#tablaReporteMensual').show();
    }

    function desplegarReportePorTaxi(){
      $('#tablaReportePorTaxi').show();
    }

    function desplegarReporteDeCorte(){

    }

    function mostrarCardsReportes(){
      $('#cardsReportes').show();
      $('#regresarAcardsReportes').hide();
      $('#tablaReporteMensual').hide();
      $('#tablaReportePorTaxi').hide();
    }

    function buscarDatos(){
      $('#tablaReporteMensual').show();
      $('#myTable1').DataTable( {
        processing: true,
        serverSide: true,
        searching: true,
        destroy: true,
        language: {
            url: routeBase+'/DataTables/DataTable_Spanish.json'
        },
        dom: 'Bfrtip',
        buttons: [
            'copy', 'excel', 'pdf',
        ],
        ajax: {
            url: routeBase+'/api/registros-list',
            type: "GET",
            dataType: 'json',
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer '+sessionStorage.getItem('token'),
            }
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'hora', name: 'hora'},
            {data: "cliente.nombre", name: 'cliente.nombre'},
            {data: "direccionCompleta", name: 'direccionCompleta'},
            {data: "unidad.numero", name:"unidad.numero", defaultContent:' '},
            {data: 'estatus'},
            {data: 'user.name'},
            {data: 'tipo_registro'}
        ]
      } );
    }
  </script>
@endpush