<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/login.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a  href="{{ route('home') }}" class="simple-text logo-normal">
      {{ __('TAXIS XALAPA') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">tablero</i>
            <p>{{ __('Tablero') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'listado_registros_diarios' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('listado-diarios') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Registros diarios') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'listado_registros_recurrentes' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('listado-recurrentes') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Registros recurrentes') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'listado_servicios' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('listado-servicios') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Servicios') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'listado_clientes' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('listado-clientes') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Clientes') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'listado_unidades' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('listado-unidades') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Unidades') }}</p>
        </a>
      </li>
      
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
            <li>
              <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <span class="sidebar-mini"> -</span>
                <span class="sidebar-normal">{{ __('Cerrar sesión') }}</span>
                
              </a>
            </li>
            <!-- <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('user.index') }}">
                <span class="sidebar-mini"> UM </span>
                <span class="sidebar-normal"> {{ __('User Management') }} </span>
              </a>
            </li> -->
          </ul>
        </div>
      </li>
      <!-- <li class="nav-item{{ $activePage == 'typography' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('typography') }}">
          <i class="material-icons">library_books</i>
            <p>{{ __('Typography') }}</p>
        </a>
      </li> -->
      <!-- <li class="nav-item{{ $activePage == 'icons' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('icons') }}">
          <i class="material-icons">bubble_chart</i>
          <p>{{ __('Icons') }}</p>
        </a>
      </li> -->
      <!-- <li class="nav-item{{ $activePage == 'map' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('map') }}">
          <i class="material-icons">location_ons</i>
            <p>{{ __('Maps') }}</p>
        </a>
      </li> -->
      <!-- <li class="nav-item{{ $activePage == 'notifications' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('notifications') }}">
          <i class="material-icons">notifications</i>
          <p>{{ __('Notifications') }}</p>
        </a>
      </li> -->
      <!-- <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('language') }}">
          <i class="material-icons">language</i>
          <p>{{ __('RTL Support') }}</p>
        </a>
      </li> -->
      <!-- <li class="nav-item active-pro{{ $activePage == 'upgrade' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('upgrade') }}">
          <i class="material-icons">unarchive</i>
          <p>{{ __('Upgrade to PRO') }}</p>
        </a>
      </li> -->
    </ul>
  </div>
</div>