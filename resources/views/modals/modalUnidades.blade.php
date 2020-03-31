<div class="modal fade" role="dialog" id="modalDatosUnidad" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Datos de la unidad</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="datosUnidadForm">

          <div class="container">
            <input type="text" style="display:none" id="idUnidad" name="idUnidad">
            <div class="form-group" id="placasDiv">
                <label for="placas" class="col-form-label">Placas:</label>
                <input type="text" class="form-control is-invalid" id="placas" name="placas" style="padding-top:20px">
                <span id="placas-error" class="error text-danger" for="placas" style="display:none">Campo faltante</span>
            </div>
            <div class="form-group" id="numeroDiv">
              <label for="numero" class="col-form-label">Número:</label>
              <input type="text" class="form-control" id="numero" maxlength="100" name="numero" style="padding-top:20px">
              <span id="numero-error" class="error text-danger" for="numero" style="display:none">Campo faltante</span>
            </div>
            <div class="form-group" id="numero_economicoDiv">
              <label for="numero_economico" class="col-form-label">Número económico:</label>
              <input type="text" class="form-control" id="numero_economico" maxlength="100" name="numero_economico" style="padding-top:20px">
              <span id="numero_economico-error" class="error text-danger" for="numero_economico" style="display:none">Campo faltante</span>
            </div>
            <div class="form-group" id="conductorDiv">
              <label for="conductorSelect" class="col-form-label">Coductor asignado:</label>
              <select class="clave" id="conductorSelect" maxlength="100" name="conductorSelect" style="padding-top:20px">
                <option value="">Seleccione un conductor...</option>
              </select>
              <span id="conductorSelect-error" class="error text-danger" for="conductorSelect" style="display:none">Campo faltante</span>
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-primary" onClick="registrarDatosUnidad()" id="registroUnidadbtn">Registrar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>