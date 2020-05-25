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
              
              <div class="col-lg-12 col-md-12 col-sm-12" style="padding-bottom:20px;">
                <!-- <span>Fecha</span> -->
                <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4">
                  <label for="reportrange">Fecha</label>
                  <div class="col-lg-10 col-md-10 col-sm-10" id="reportrange" style="background: #fff; cursor: pointer; padding-top: 5px; padding-bottom: 5px; border: 1px solid #ccc; width: 100%; height:50%">
                      <i class="fa fa-calendar"></i>&nbsp;
                      <span></span> <i class="fa fa-caret-down"></i>
                  </div>
                
                </div>
                  <div class="col-lg-2 col-md-2 col-sm-2">
                    <label for="tipo_servicio">Tipo de servicio</label>
                    <select name="tipo_servicio" id="tipo_servicio" class="form-control">
                      <option value="todos" selected>Todos</option>
                      <option value="diario">Diario</option>
                      <option value="programado">Programado</option>
                    </select>
                  </div>
                  <div class="col-lg-2 col-md-2 co-sm-2">
                    <label for="base">Base</label>
                    <select name="base" id="base" class="form-control">
                      <option value="todos" selected>Todas</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                    </select>
                  </div>
                  <div class="col-lg-2 col-md-2 col-sm-2" style="padding-top:10px;">
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
<script src="{{ asset('js') }}/reportes/reportes.js"></script>

@endpush