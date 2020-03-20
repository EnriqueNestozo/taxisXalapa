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
        <form id="registroDiarioForm">
        <div class="row">
          <div class="col-xls-5 col-sm-5 col-md-5">
            <div class="form-group" id="horaDiv">
                <label for="hora" class="col-form-label">Hora:</label>
                <br>
                <input type="time" class="form-control is-invalid" id="hora" name="hora">
                <span id="hora-error" class="error text-danger" for="hora" style="display:none">Campo faltante</span>
            </div>
            <div class="form-group" id="personaDiv">
              <label for="persona" class="col-form-label">Persona:</label>
              <br>
              <select class="clave" id="personaSelect" name="personaSelect" style="width: 100%">
              </select>
              <input type="text" class="form-control" id="persona" maxlength="100" placeholder="Sino existe escriba el nombre" name="persona">
              <span id="persona-error" class="error text-danger" for="persona" style="display:none">Campo faltante</span>
            </div>
            <div class="form-group" id="direccionDiv">
              <label for="direccion" class="col-form-label">Dirección:</label>
              <br>
              <select class="clave" id="direccionSelect" name="direccionSelect" style="width: 100%">
                <option value="">Seleccione una dirección...</option>
              </select>
              <input type="text" class="form-control" id="direccion" maxlength="100" name="direccion" placeholder="Sino escriba la dirección">
              <span id="direccion-error" class="error text-danger" for="direccion" style="display:none">Campo faltante</span>
            </div>
            <div class="form-group" id="entre_callesDiv">
              <label for="entre_calles" class="col-form-label">Entre calles:</label>
              <input type="text" class="form-control" id="entre_calles" maxlength="100" name="entre_calles">
              <span id="entre_calle-error" class="error text-danger" for="entre_calles" style="display:none">Campo faltante</span>
            </div>
            <div class="form-group" id="referenciaDiv">
              <label for="referencia" class="col-form-label">Referencia:</label>
              <input type="text" class="form-control" id="referencia" maxlength="100" name="referencia">
              <span id="referencia-error" class="error text-danger" for="referencia" style="display:none">Campo faltante</span>
            </div>
            <div class="form-group" id="telefonoDiv">
              <label for="telefono" class="col-form-label">Teléfono:</label>
              <input type="text" class="form-control" id="telefono" maxlength="100" name="telefono">
              <span id="telefono-error" class="error text-danger" for="telefono" style="display:none">Campo faltante</span>
            </div>
            <div class="form-group" id="celularDiv">
              <label for="celular" class="col-form-label">Celular:</label>
              <input type="text" class="form-control" id="celular" maxlength="100" name="celular">
              <span id="celular-error" class="error text-danger" for="celular" style="display:none">Campo faltante</span>
            </div>
            <div class="form-group" id="claveDiv">
              <label for="clave" class="col-form-label">Clave:</label>
              <select class="clave" id="clave" name="clave"  style="width: 100%">
              </select>
            </div>

          </div>
          <div class="col-xls-7 col-sm-7 col-md-7">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d60163.0976120704!2d-96.91890004993273!3d19.533300130772247!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85db321ca1f225d9%3A0x584837bc4340a47c!2sXalapa-Enr%C3%ADquez%2C%20Ver.!5e0!3m2!1ses!2smx!4v1584632991648!5m2!1ses!2smx" width="400" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
          </div>
        </div>
        
          
        </form>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-primary" onClick="registrarViaje()" id="registroDiarioBtn">Registrar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>