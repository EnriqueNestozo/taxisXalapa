@extends('layouts.app', ['activePage' => 'listado_clientes', 'titlePage' => __('Clientes registrados')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Clientes registrados</h4>
            <p class="card-category"> Listado de clientes</p>
          </div>
          <div class="card-body">
            <div class="table-responsive">


<table id="listado" class="table-hover"  style="width:100%">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Primer_apellido</th>
                <th>Segundo_apellido</th>
                <th>Telefono fijo</th>
                <th>Celular</th>
                <th>Género</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
        <tfoot>
            <tr>
              <th>Nombre</th>
              <th>Primer_apellido</th>
              <th>Segundo_apellido</th>
              <th>Telefono fijo</th>
              <th>Celular</th>
              <th>Género</th>
              <th>Acciones</th>
            </tr>
        </tfoot>
    </table>


              <table class="table">
                <thead class=" text-primary">
                  <!-- <th>
                    ID
                  </th> -->
                  
                <tbody>
                  <!-- <tr>
                    <td>
                      1
                    </td>
                    <td>
                      Dakota Rice
                    </td>
                    <td>
                      Niger
                    </td>
                    <td>
                      Oud-Turnhout
                    </td>
                    <td class="text-primary">
                      $36,738
                    </td>
                  </tr> -->
                  
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
<script>
  $(document).ready(function() {
    cargarListado();
    // $('#listado').DataTable();
  } );

  function cargarListado(){
    var token = 'dd16ddd35df118b102b99f1e99c7a553a2ffd3ff4e9a3df2ddc01c6389d947cd147ebfb5c936d17b';
    $('#listado').DataTable({
      processing: true,
      serverSide: true,
      searching: true,
      language: {
        url: routeBase+'/DataTables/DataTable_Spanish.json'
      },
      ajax: {
        url: "{{route('api.clientes.list')}}",
        type: "GET",
        dataType: 'json',
        headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer '+ token,
        }
      },
      columns: [
          {data: 'nombre', name: 'nombre'},
          {data: 'primer_apellido', name: 'primer_apellido'},
          {data: "segundo_apellido", name: 'segundo_apellido'},
          {data: "telefono_fijo", name: 'telefono_fijo'},
          {data: 'celular', name: 'celular'},
          {data: 'genero', name: 'genero'},
          {data: 'action', name:'action'}
      ]
    });
  }

  function editarCliente(id_cliente){
    console.log(id_cliente);
  }
</script>
@endpush