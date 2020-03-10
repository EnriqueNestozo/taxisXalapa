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
  $(document).ready(function(){
      $.get("{{route('api.clientes.list')}}", function(data, status){
        console.log(data[0]);
      }).fail(function(xhr, textStatus, errorThrown){
        alert(xhr.responseText);
      });
    });
</script>
@endpush