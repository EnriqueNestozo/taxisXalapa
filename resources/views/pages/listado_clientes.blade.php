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
                <!-- <th>Primer_apellido</th>
                <th>Segundo_apellido</th> -->
                <th>Telefono fijo</th>
                <th>Celular</th>
                <!-- <th>No. de viajes</th> -->
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
        <tfoot>
            
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
    var data = sessionStorage.getItem('token');
    console.log( data );
    // var token = 'aab1846e14a2a7d487234332faa9431fdf01e9e9635858f9a815e9815080e5f531c360a9f08af152';
    $('#listado').DataTable({
      processing: true,
      serverSide: true,
      searching: true,
      destroy: true,
      language: {
        url: routeBase+'/DataTables/DataTable_Spanish.json'
      },
      ajax: {
        url: "{{route('api.clientes.list')}}",
        type: "GET",
        dataType: 'json',
        headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer '+data,
        }
      },
      columns: [
          {data: 'nombre', name: 'nombre'},
          // {data: 'primer_apellido', name: 'primer_apellido'},
          // {data: "segundo_apellido", name: 'segundo_apellido'},
          {data: "telefono_fijo", name: 'telefono_fijo', "defaultContent":""},
          {data: 'celular', name: 'celular', "defaultContent":""},
          // {data: 'num_viajes', name: 'num_viajes', "defaultContent":""},
          {data: 'action', name:'action'}
      ]
    });
  }

  function editarCliente(id_cliente){
    console.log(id_cliente);
  }

  function eliminarCliente(id_cliente){
    swal({
      title: '¿Esta seguro que desea eliminar este cliente?',
      text: "El cliente se eliminará de manera permanente!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonClass: 'btn btn-success',
      cancelButtonClass: 'btn btn-danger',
      cancelButtonText: 'Cancelar!',
      confirmButtonText: 'Eliminar!',
      buttonsStyling: false
    }).then(function(confirmation) {
      console.log(confirmation);
      if (confirmation['dismiss'] != 'cancel') {
        $.post({
          url: "{{route('api.delete.cliente')}}",
          data:{
            idCliente: id_cliente,
          },   
          dataType: 'json',
          headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer '+sessionStorage.getItem('token'),
          },
          success: function( result ) {
            md.showNotification('bottom','right','success','Registro eliminado correctamente');
            cargarListado();
          },
          error: function(result){
            console.log(result);
            md.showNotification('bottom','right','danger','Ha ocurrido un error al eliminar el registro');
          }
        });
      }
    })
  }
</script>
@endpush