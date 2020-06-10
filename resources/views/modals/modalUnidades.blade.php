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
            
            <div class="form-group" id="marcaDiv">
              <label for="marca" class="col-form-label">Marca:</label>
              <input type="text" class="form-control is-invalid" id="marca" name="marca" style="padding-top:20px">
              <span id="marca-error" class="error text-danger" for="marca" style="display:none">Campo faltante</span>
            </div>
            <div class="form-group" id="modeloDiv">
              <label for="modelo" class="col-form-label">Modelo:</label>
              <input type="text" class="form-control is-invalid" id="modelo" name="modelo" style="padding-top:20px">
              <span id="modelo-error" class="error text-danger" for="modelo" style="display:none">Campo faltante</span>
            </div>
            <div class="form-group" id="placasDiv">
              <label for="placas" class="col-form-label">Placas:</label>
              <input type="text" class="form-control is-invalid" id="placas" name="placas" style="padding-top:20px">
              <span id="placas-error" class="error text-danger" for="placas" style="display:none">Campo faltante</span>
            </div>
            <div class="form-group" id="numeroDiv">
              <label for="numero" class="col-form-label">Numero de radio:</label>
              <input type="text" class="form-control" id="numero" maxlength="100" name="numero" style="padding-top:20px">
              <span id="numero-error" class="error text-danger" for="numero" style="display:none">Campo faltante</span>
            </div>
            <div class="form-group" id="baseDiv">
              <label for="baseSelect" class="col-form-label">Base:</label>
              <select class="special_select" id="baseSelect" maxlength="100" name="base" style="padding-top:20px; width:200px">
                <option value="">Seleccione una base...</option>
                <option value="1">Base 1</option>
                <option value="2">Base 2</option>
              </select>
              <span id="baseSelect-error" class="error text-danger" for="baseSelect" style="display:none">Campo faltante</span>
            </div>
            <div class="form-group" id="numero_economicoDiv">
              <label for="numero_economico" class="col-form-label">Número económico:</label>
              <input type="text" class="form-control" id="numero_economico" maxlength="100" name="numero_economico" style="padding-top:20px">
              <span id="numero_economico-error" class="error text-danger" for="numero_economico" style="display:none">Campo faltante</span>
            </div>
            <!-- <div class="form-group" id="conductor1Div">
              <label for="conductor1Select" class="col-form-label">Chofer 1er. turno:</label>
              <select class="clave" id="conductor1Select" maxlength="100" name="conductor1Select" style="padding-top:20px">
                <option value="">Seleccione un chofer...</option>
              </select>
              <span id="conductor1Select-error" class="error text-danger" for="conductor1Select" style="display:none">Campo faltante</span>
            </div>
            <div class="form-group" id="conductor2Div">
              <label for="conductor2Select" class="col-form-label">Chofer 2do. turno:</label>
              <select class="clave" id="conductor2Select" maxlength="100" name="conductor2Select" style="padding-top:20px">
                <option value="">Seleccione un chofer...</option>
              </select>
              <span id="conductor2Select-error" class="error text-danger" for="conductor2Select" style="display:none">Campo faltante</span>
            </div> -->
            <div class="form-group" id="tarjeta_circulacionDiv">
              <label for="tarjeta_circulacion" class="col-form-label">Tarjeta de circulación:</label>
              <input type="text" class="form-control" id="tarjeta_circulacion" maxlength="100" name="tarjeta_circulacion" style="padding-top:20px">
              <span id="tarjeta_circulacion-error" class="error text-danger" for="tarjeta_circulacion" style="display:none">Campo faltante</span>
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