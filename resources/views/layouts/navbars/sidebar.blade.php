<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/login.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a  href="{{ route('listado-diarios') }}" class="simple-text logo-normal">
      {{ __('TAXIS XALAPA') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'listado_registros_diarios' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('listado-diarios') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Registros diarios') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'listado_registros_recurrentes' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('listado-recurrentes') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Próximos programados') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'listado_servicios' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('listado-servicios') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Nuevo programado') }}</p>
        </a>
      </li>
      @if(@Auth::user()->hasRole('admin'))
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">description</i>
            <p>{{ __('Reportes') }}</p>
        </a>
      </li>
      
      <!-- <li class="nav-item{{ $activePage == 'listado_clientes' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('listado-clientes') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Clientes') }}</p>
        </a>
      </li> -->
      
      <li class="nav-item{{ $activePage == 'listado_unidades' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('listado-unidades') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Unidades') }}</p>
        </a>
      </li>
      @endif
      
      <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
          <i class="material-icons">account_box</i>
          <p>{{ __('Usuario') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse show" id="laravelExample">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('profile.edit') }}">
                <span class="sidebar-mini"> -</span>
                <span class="sidebar-normal">{{ __('Perfil de usuario') }} </span>
              </a>
            </li>
            @if(@Auth::user()->hasRole('admin'))
            <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('admin.users') }}">
                <span class="sidebar-mini"> -</span>
                <span class="sidebar-normal">{{ __('Administrar usuarios') }} </span>
              </a>
            </li>
            @endif
            <li>
              <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <span class="sidebar-mini"> -</span>
                <span class="sidebar-normal">{{ __('Cerrar sesión') }}</span>
              </a>
            </li>
          </ul>
        </div>
        <li>
          <a class="nav-link" href="https://web.whatsapp.com/" target="_blank">
            <!-- <i data-image="{{ asset('material') }}/img/whatsapp-icon.svg" ></i> -->
              <p>
              <svg width="25" height="25" style="margin-right:15px;">
                <image href="{{ asset('material') }}/img/whatsapp-icon.svg" height="25" width="25"/>
              </svg>
                <!-- <img  alt="whatsapp logo" style="width: 25px; height: 25px; margin-right:15px; fill: #DA4567;"> -->
                {{ __('Web WhatsApp') }}
              </p>
          </a>
        </li>
      </li>
    </ul>
  </div>
</div>