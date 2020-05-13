<div class="modal fade" role="dialog" id="modalRelacionConductorUnidad" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Relación Unidad-Conductor</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="datosConductorUnidadForm">

          <div class="container">
            <div class="form-group">
            <input type="text" style="display:none" id="idUnidadModalRelacion" name="idUnidad">
            <div class="form-group" id="conductorDiv">
              <label for="conductorSelect" class="col-form-label">Chofer:</label>
              <select class="clave" id="conductorSelect" name="conductorSelect" style="width:60%;">
                <option value="">Seleccione un chofer...</option>
              </select>
              <span id="conductorSelect-error" class="error text-danger" for="conductorSelect" style="display:none">Campo faltante</span>
            </div>
            
              <label for="turnoSelect" class="col-form-label" style="padding-right:8px">Turno:</label>
              <select class="clave" id="turnoSelect"name="turnoSelect" style="width:60%;">
                <option value="">Seleccione un turno...</option>
                <option value="1">Mañana</option>
                <option value="2">Tarde</option>
                <option value="3">Adicional</option>
              </select>
              <span id="turnoSelect-error" class="error text-danger" for="turnoSelect" style="display:none">Campo faltante</span>
            </div>
            
          </div>

        </form>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-primary" onClick="registrarConductorAUnidad()" id="registroUnidadbtn">Registrar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>