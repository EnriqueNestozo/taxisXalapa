<div class="modal fade" role="dialog" id="modalRegistroDiario" aria-hidden="true" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Registro diario</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
        <div class="col-6">
        <div class="form-group">
            <label for="hora" class="col-form-label">Hora:</label>
            <input type="time" class="form-control" id="hora">
          </div>
          <div class="form-group">
            <label for="persona" class="col-form-label">Persona:</label>
            <select class="js-example-basic-single" id="persona">
                <option value="-1">Seleccione una persona...</option>
                <option value="AL">María del carmen sanchez</option>
                <option value="WY">José Angel Perez Cruz</option>
                <option value="WY">José Miguel Velez</option>
                <option value="WY">Angel Ochoa</option>
            </select>
            <input type="text" class="form-control" id="persona" maxlength="100" placeholder="Sino existe escriba el nombre">
          </div>
          <div class="form-group">
            <label for="direccion" class="col-form-label">Dirección:</label>
            <input type="text" class="form-control" id="direccion" maxlength="100">
          </div>
          <div class="form-group">
            <label for="entre_calles" class="col-form-label">Entre calles:</label>
            <input type="text" class="form-control" id="entre_calles" maxlength="100">
          </div>
          <div class="form-group">
            <label for="referencia" class="col-form-label">Referencia:</label>
            <input type="text" class="form-control" id="referencia" maxlength="100">
          </div>
          <div class="form-group">
            <label for="clave" class="col-form-label">Clave:</label>
            <select class="js-example-basic-single" id="clave">
                <option value="-1">Seleccione una clave...</option>
                <option value="AL">sffdfs423</option>
                <option value="WY">dfsdf2346</option>
            </select>
          </div>

        </div>
        <div class="col-6">
        </div>
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Registrar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>