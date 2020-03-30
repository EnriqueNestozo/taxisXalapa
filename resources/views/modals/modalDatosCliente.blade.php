<div class="modal fade" role="dialog" id="modalDatosCliente" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Datos del cliente</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="datosClienteForm">

          <div class="container">
            <input type="text" style="display:none" id="idCliente" name="idCliente">
            <div class="form-group" id="nombreDiv">
                <label for="nombre" class="col-form-label">Nombre completo:</label>
                <input type="text" class="form-control is-invalid" id="nombre" name="nombre" style="padding-top:20px">
                <span id="nombre-error" class="error text-danger" for="nombre" style="display:none">Campo faltante</span>
            </div>
            <div class="form-group" id="telefonoDiv">
              <label for="telefono" class="col-form-label">Teléfono:</label>
              <input type="text" class="form-control" id="telefono" maxlength="100" name="telefono_fijo" style="padding-top:20px">
              <span id="telefono-error" class="error text-danger" for="telefono" style="display:none">Campo faltante</span>
            </div>
            <div class="form-group" id="celularDiv">
              <label for="celular" class="col-form-label">Celular:</label>
              <input type="text" class="form-control" id="celular" maxlength="100" name="celular" style="padding-top:20px">
              <span id="celular-error" class="error text-danger" for="celular" style="display:none">Campo faltante</span>
            </div>
          </div>

        
          
        </form>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-primary" onClick="registrarDatosCliente()" id="registroDiarioBtn">Registrar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>