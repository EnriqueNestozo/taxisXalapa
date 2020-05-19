@extends('layouts.app', ['activePage' => 'user-management', 'titlePage' => __('User Management')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title ">{{ __('Usuarios') }}</h4>
                <p class="card-category"> {{ __('Aquí puedes administrar los usuarios') }}</p>
              </div>
              <div class="card-body">
                @if (session('status'))
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <i class="material-icons">close</i>
                        </button>
                        <span>{{ session('status') }}</span>
                      </div>
                    </div>
                  </div>
                @endif
                <div class="row">
                  <div class="col-12 text-right">
                    <a class="btn btn-sm btn-primary" style="color:white;" onClick="mostrarModalUsuario()">{{ __('Agregar usuario') }}</a>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                          {{ __('Nombre') }}
                      </th>
                      <th>
                        {{ __('Correo') }}
                      </th>
                      <th>
                        {{ __('Fecha de creación') }}
                      </th>
                      <th>
                        {{ __('Rol') }}
                      </th>
                      <th class="text-right">
                        {{ __('Acciones') }}
                      </th>
                    </thead>
                    <tbody>
                      @foreach($users as $user)
                        <tr>
                          <td>
                            {{ $user->name }}
                          </td>
                          <td>
                            {{ $user->email }}
                          </td>
                          <td>
                            {{ $user->created_at->format('Y-m-d') }}
                          </td>
                          
                          @foreach($user->roles as $rol)
                          <td>
                            {{ $rol->name }}
                          </td>
                          @endforeach
                           
                          <td class="td-actions text-right">
                            @if ($user->id != auth()->id())
                              <form action="{{ route('user.destroy', $user) }}" method="post">
                                  @csrf
                                  @method('delete')
                              
                                  <a rel="tooltip" class="btn btn-success btn-link" href="{{ route('user.edit', $user) }}" data-original-title="" title="">
                                    <i class="material-icons">edit</i>
                                    <div class="ripple-container"></div>
                                  </a>
                                  <button type="button" class="btn btn-danger btn-link" data-original-title="" title="" onclick="confirm('{{ __("Are you sure you want to delete this user?") }}') ? this.parentElement.submit() : ''">
                                      <i class="material-icons">close</i>
                                      <div class="ripple-container"></div>
                                  </button>
                              </form>
                            @else
                              <a rel="tooltip" class="btn btn-success btn-link" href="{{ route('profile.edit') }}" data-original-title="" title="">
                                <i class="material-icons">edit</i>
                                <div class="ripple-container"></div>
                              </a>
                            @endif
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
  @include('modals.modalUsuario')
@endsection

@push('js')
<script>
  var rutaCrearUsuario ="{{ route('api.user.create') }}";
  var rutaEditarUsuario ="{{ route('user.destroy', $user) }}";
  var email = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/;

  $(document).ready(function(){
    $('#modalDatosUsuario').on('hidden.bs.modal', function () {
      $('#datosUsuarioForm').trigger("reset");
    });

    $('#rolSelect').change(function(){
      if( $('#rolSelect').val() == 'capturista' ){
        $('#turnoDiv').show();
      }else{
        $('#turnoSelect').val('');
        $('#turnoDiv').hide();
      }
    });

  });

  function mostrarModalUsuario(){  
    $('#modalDatosUsuario').modal('show');
  }

  function guardarDatosUsuario(){
    if(!validarcampos()){
      $.post({
        url: rutaCrearUsuario,
        data: $('#datosUsuarioForm').serialize(),
        dataType: 'json',
        headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer '+sessionStorage.getItem('token'),
        },
        success: function(respuesta){
          $('#modalDatosUsuario').modal('hide');
          md.showNotification('bottom','right','success','Se ha registrado el usuario correctamente');
        },
        error: function(respuesta){
          md.showNotification('bottom','right','danger','Ha ocurrido un error al registrar el usuario');
        }
      });
    }else{
      console.log("no validos");
    }
  }

  function validarcampos(){
    var faltanCampos = false;
    limpiarErrores();
    if( $('#name').val() =='' || $('#email').val() =='' || $('#password').val() == '' || ($('#turnoSelect').val() == '' && $('#rolSelect').val() == 'capturista') || $('#rolSelect').val() =='' ){
      if($('#name').val()==''){
        $('#name-error').show();
      }
      if($('#email').val()==''){
        $('#email-error').show();
      }
      if($('#password').val()==''){
        $('#password-error').show();
      }else{
        if( !email.test($'#password').val() ){
          $('#password-error').show();
        }
      }
      if($('#rolSelect').val() == '' || $('#rolSelect').val() == 'admin' ){
        $('#rol-error').show();
      }else{
        if($('#turnoSelect').val() == ''){
          console.log("turno");
          $('#turno-error').show();
        }
      }
      faltanCampos = true;
    }
    return faltanCampos;
  }

  function limpiarErrores(){
    $('#name-error').hide();
    $('#email-error').hide();
    $('#password-error').hide();
    $('#turno-error').hide();
    $('#rol-error').hide();
  }

  function limpiarCampos(){

  }
</script>
@endpush