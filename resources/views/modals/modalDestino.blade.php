<div class="modal fade" role="dialog" id="modalDestino" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Destino</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="destinoForm">
        <div class="row">
          <div class="col-xls-6 col-sm-6 col-md-6">
           
            <div class="row">
              <div class="col-12">
                <input type="text" style="display:none" id="idRegistroDestino" name="idRegistro">
                <input type="text" style="display:none" id="idDireccionDestino" name="idDireccionDestino">

                <div class="form-group" id="personaDiv">
                  <label for="personaDestinoSelect" class="col-form-label">Persona:</label>
                  <br>
                  <select class="special_select" id="personaDestinoSelect" name="cliente_id" style="width: 100%">
                  </select>
                  <span id="personaDestinoSelect-error" class="error text-danger" for="personaDestinoSelect" style="display:none">Campo faltante</span>
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
                    <div class="form-group" id="direccionDestinoDiv">
                        <label for="direccionDestinoSelect" class="col-form-label">Dirección:</label>
                        <br>
                        <select class="special_select" id="direccionDestinoSelect" name="direccionDestinoSelect" style="width: 100%">
                            <option value="">Seleccione una dirección guardada...</option>
                        </select>
                    </div>

                    <div class="form-group" id="municipioDestinoDiv">
                        <label for="municipioDestinoSelect" class="col-form-label">Municipio:</label>
                        <br>
                        <select class="special_select" id="municipioDestinoSelect" name="municipioDestinoSelect" style="width: 100%">
                            <option value="">Seleccione un municipio...</option>
                        </select>
                        <input type="text" class="form-control" id="municipioDestino" maxlength="100" name="municipioDestino" placeholder="Sino escriba el municipio">
                        <span id="municipioDestino-error" class="error text-danger" for="municipioDestino" style="display:none">Campo faltante</span>
                    </div>
                    <div class="form-group" id="localidadDestinoDiv">
                        <label for="localidadDestinoSelect" class="col-form-label">Localidad:</label>
                        <br>
                        <select class="special_select" id="localidadDestinoSelect" name="localidadDestinoSelect" style="width: 100%">
                            <option value="">Seleccione una localidad...</option>
                        </select>
                        <input type="text" class="form-control" id="localidadDestino" maxlength="100" name="localidadDestino" placeholder="Sino escriba la localidad">
                        <span id="localidadDestino-error" class="error text-danger" for="localidadDestino" style="display:none">Campo faltante</span>
                    </div>
                    <div class="form-group" id="coloniaDestinoDiv">
                        <label for="coloniaDestinoSelect" class="col-form-label">Colonia:</label>
                        <br>
                        <select class="special_select" id="coloniaDestinoSelect" name="coloniaDestinoSelect" style="width: 100%">
                            <option value="">Seleccione una colonia...</option>
                        </select>
                        <input type="text" class="form-control" id="coloniaDestino" maxlength="100" name="coloniaDestino" placeholder="Sino escriba la colonia">
                        <span id="coloniaDestino-error" class="error text-danger" for="coloniaDestino" style="display:none">Campo faltante</span>
                    </div>
                    <div class="form-group" id="calleDestinoDiv">
                        <label for="calleDestino" class="col-form-label">Calle y número:</label>
                        <input type="text" class="form-control" id="calleDestino" maxlength="100" name="calleDestino">
                        <span id="calleDestino-error" class="error text-danger" for="calleDestino" style="display:none">Campo faltante</span>
                    </div>
                    <div class="form-group" id="entre_callesDestinoDiv">
                        <label for="entre_callesDestino" class="col-form-label">Entre calles:</label>
                        <input type="text" class="form-control" id="entre_callesDestino" maxlength="100" name="entre_callesDestino">
                        <!-- <span id="entre_calle-error" class="error text-danger" for="entre_calles" style="display:none">Campo faltante</span> -->
                    </div>
                    <div class="form-group" id="referenciaDestinoDiv">
                        <label for="referenciaDestino" class="col-form-label">Referencia:</label>
                        <input type="text" class="form-control" id="referenciaDestino" maxlength="100" name="referenciaDestino">
                        <!-- <span id="referencia-error" class="error text-danger" for="referencia" style="display:none">Campo faltante</span> -->
                    </div>
                </div>
            </div>
          </div>

        </div>
        
        
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onClick="registrarDestino()" id="registroDestinoBtn">Registrar</button>
        <button type="button" class="btn btn-danger" onClick="eliminarDestino()" id="eliminarDestinoBtn" style="display:none">Eliminar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>