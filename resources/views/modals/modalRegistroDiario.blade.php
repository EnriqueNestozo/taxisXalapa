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
        
          <div class="col-xls-6 col-sm-6 col-md-6">
            <div class="row">
              <div class="col-12">
                <input type="text" style="display:none" id="idRegistro" name="idRegistro">
                <input type="text" style="display:none" id="idCliente" name="idCliente">
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
              </div>
              
            </div>
            <div class="row">
              <div class="col-12">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d60163.0976120704!2d-96.91890004993273!3d19.533300130772247!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85db321ca1f225d9%3A0x584837bc4340a47c!2sXalapa-Enr%C3%ADquez%2C%20Ver.!5e0!3m2!1ses!2smx!4v1584632991648!5m2!1ses!2smx" width="380" height="300" frameborder="0" style="border:0;" allowfullscreen aria-hidden="false" tabindex="0"></iframe>
              </div>
            </div>
          
          </div>

          <div class="col-xls-6 col-sm-6 col-md-6">
            <div class="row">
              <div class="col-12">
                <div class="form-group" id="municipioDiv">
                  <label for="municipio" class="col-form-label">Municipio:</label>
                  <br>
                  <select class="clave" id="municipioSelect" name="municipioSelect" style="width: 100%">
                    <option value="">Seleccione un municipio...</option>
                  </select>
                  <input type="text" class="form-control" id="municipio" maxlength="100" name="municipio" placeholder="Sino escriba el municipio">
                  <span id="municipio-error" class="error text-danger" for="municipio" style="display:none">Campo faltante</span>
                </div>
                <div class="form-group" id="localidadDiv">
                  <label for="localidad" class="col-form-label">Localidad:</label>
                  <br>
                  <select class="clave" id="localidadSelect" name="localidadSelect" style="width: 100%">
                    <option value="">Seleccione una localidad...</option>
                  </select>
                  <input type="text" class="form-control" id="localidad" maxlength="100" name="localidad" placeholder="Sino escriba la localidad">
                  <span id="localidad-error" class="error text-danger" for="localidad" style="display:none">Campo faltante</span>
                </div>
                <div class="form-group" id="coloniaDiv">
                  <label for="colonia" class="col-form-label">Colonia:</label>
                  <br>
                  <select class="clave" id="coloniaSelect" name="coloniaSelect" style="width: 100%">
                    <option value="">Seleccione una colonia...</option>
                  </select>
                  <input type="text" class="form-control" id="colonia" maxlength="100" name="colonia" placeholder="Sino escriba la colonia">
                  <span id="colonia-error" class="error text-danger" for="colonia" style="display:none">Campo faltante</span>
                </div>
                <div class="form-group" id="calleDiv">
                  <label for="calle" class="col-form-label">Calle y número:</label>
                  <input type="text" class="form-control" id="calle" maxlength="100" name="calle">
                  <!-- <span id="entre_calle-error" class="error text-danger" for="entre_calles" style="display:none">Campo faltante</span> -->
                </div>
                <div class="form-group" id="entre_callesDiv">
                  <label for="entre_calles" class="col-form-label">Entre calles:</label>
                  <input type="text" class="form-control" id="entre_calles" maxlength="100" name="entre_calles">
                  <!-- <span id="entre_calle-error" class="error text-danger" for="entre_calles" style="display:none">Campo faltante</span> -->
                </div>
                <div class="form-group" id="referenciaDiv">
                  <label for="referencia" class="col-form-label">Referencia:</label>
                  <input type="text" class="form-control" id="referencia" maxlength="100" name="referencia">
                  <!-- <span id="referencia-error" class="error text-danger" for="referencia" style="display:none">Campo faltante</span> -->
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">

                <div class="form-group" id="claveDiv">
                  <label for="clave" class="col-form-label">Clave:</label>
                  <select class="clave" id="clave" name="clave"  style="width: 100%">
                  </select>
                </div>

              </div>
            </div>
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