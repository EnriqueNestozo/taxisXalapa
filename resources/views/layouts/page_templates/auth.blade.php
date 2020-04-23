<div class="wrapper ">
  @include('layouts.navbars.sidebar')
  <div class="main-panel">
    @include('layouts.navbars.navs.auth')
    @yield('content')
    @include('layouts.footers.auth')
  </div>
</div>
@push('js')
<script>
  //Variables globales
  var routeBase			    = '{!! url('') !!}';
  $(document).ready(function() {
    verificarExistenciasDeServicios();
  });
</script>
@endpush