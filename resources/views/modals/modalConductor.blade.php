<div class="modal fade" role="dialog" id="modalDatosConductor" aria-hidden="true" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Datos del conductor</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="datosUnidadForm">

            <input type="text" style="display:none" id="idConductor" name="idConductor">
            <div class="row">
            
                <div class="form-group col-lg-6 col-md-6 col-sm-6" id="turnoDiv">
                    <label for="turnoSelect" class="col-form-label">Turno:</label>
                        <select class="special_select" id="turnoSelect" name="turnoSelect" style="width: 100%">
                            <option value="1">Mañana</option>
                            <option value="2">Tarde</option>
                        </select>
                    <span id="turno-error" class="error text-danger" for="turno" style="display:none">Campo faltante</span>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="col-12">
                        <img id="blah" src="http://placehold.it/250" alt="your image" />
                    
                    </div>
                    <div class="col-12">
                        <input type='file' onchange="readURL(this);" id="fotoPersona"/> 
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12" id="nombreDiv">
                        <label for="nombre" class="col-form-label">Nombre:</label>
                        <input type="text" class="form-control is-invalid" id="nombre" name="nombre" style="padding-top:20px">
                        <span id="nombre-error" class="error text-danger" for="nombre" style="display:none">Campo faltante</span>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12" id="domicilioDiv">
                        <label for="domicilio" class="col-form-label">Domicilio:</label>
                        <input type="text" class="form-control is-invalid" id="domicilio" name="domicilio" style="padding-top:20px">
                        <span id="domicilio-error" class="error text-danger" for="domicilio" style="display:none">Campo faltante</span>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12" id="coloniaDiv">
                        <label for="colonia" class="col-form-label">Colonia:</label>
                        <input type="text" class="form-control" id="colonia" maxlength="100" name="colonia" style="padding-top:20px">
                        <span id="colonia-error" class="error text-danger" for="colonia" style="display:none">Campo faltante</span>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12" id="ciudadDiv">
                        <label for="ciudad" class="col-form-label">Ciudad:</label>
                        <input type="text" class="form-control" id="ciudad" maxlength="100" name="ciudad" style="padding-top:20px">
                        <span id="ciudad-error" class="error text-danger" for="ciudad" style="display:none">Campo faltante</span>
                    </div>
                    <div class="form-group" id="telefonoDiv">
                        <label for="telefono" class="col-form-label">Teléfono:</label>
                        <input type="text" class="form-control" id="telefono" maxlength="100" name="telefono" style="padding-top:20px">
                        <span id="telefono-error" class="error text-danger" for="telefono" style="display:none">Campo faltante</span>
                    </div>
                    <div class="form-group" id="celularDiv">
                        <label for="celular" class="col-form-label">Celular:</label>
                        <input type="text" class="form-control" id="celular" maxlength="100" name="celular" style="padding-top:20px">
                        <span id="celular-error" class="error text-danger" for="celular" style="display:none">Campo faltante</span>
                    </div>
                    <div class="row" style="padding-left:1em;">
                        <div class="form-group col-6" id="licenciaDiv">
                            <label for="licencia" class="col-form-label">Licencia tipo:</label>
                            <input type="text" class="form-control" id="licencia" maxlength="100" name="licencia" style="padding-top:20px">
                            <span id="licencia-error" class="error text-danger" for="licencia" style="display:none">Campo faltante</span>
                        </div>
                        <div class="form-group col-6" id="vencimientoDiv">
                            <label for="vencimiento" class="col-form-label">Vencimiento:</label>
                            <input type="text" class="form-control" id="vencimiento" maxlength="100" name="vencimiento" style="padding-top:20px">
                            <span id="vencimiento-error" class="error text-danger" for="vencimiento" style="display:none">Campo faltante</span>
                        </div>
                    
                    </div>
                    <div class="form-group" id="tipoSangreDiv">
                        <label for="tipoSangre" class="col-form-label">Tipo de sangre:</label>
                        <input type="text" class="form-control" id="tipoSangre" maxlength="100" name="tipoSangre" style="padding-top:20px">
                        <span id="tipoSangre-error" class="error text-danger" for="tipoSangre" style="display:none">Campo faltante</span>
                    </div>
                </div>
            </div>
            <br>
            <div class="row" style="padding-left:1em;">
                <div class="form-group col-6" id="nombreReferenciaDiv">
                    <label for="nombreReferencia" class="col-form-label">Nombre de la esposa y/o referencia:</label>
                    <input type="text" class="form-control" id="nombreReferencia" maxlength="100" name="nombreReferencia" style="padding-top:20px">
                    <span id="nombreReferencia-error" class="error text-danger" for="nombreReferencia" style="display:none">Campo faltante</span>
                </div>
                <div class="form-group col-6" id="telefonoReferenciaDiv">
                    <label for="telefonoReferencia" class="col-form-label">Teléfono referencia:</label>
                    <input type="text" class="form-control" id="telefonoReferencia" maxlength="100" name="telefonoReferencia" style="padding-top:20px">
                    <span id="telefonoReferencia-error" class="error text-danger" for="telefonoReferencia" style="display:none">Campo faltante</span>
                </div>
            </div>

            <div class="row" style="padding-left:1em;">
                <div class="form-group col-6" id="avisarADiv">
                    <label for="avisarA" class="col-form-label">En emergencia avisar a:</label>
                    <input type="text" class="form-control" id="avisarA" maxlength="100" name="avisarA" style="padding-top:20px">
                    <span id="avisarA-error" class="error text-danger" for="avisarA" style="display:none">Campo faltante</span>
                </div>
                <div class="form-group col-6" id="telefonoAvisarDiv">
                    <label for="telefonoAvisar" class="col-form-label">Teléfono emergencia:</label>
                    <input type="text" class="form-control" id="telefonoAvisar" maxlength="100" name="telefonoAvisar" style="padding-top:20px">
                    <span id="telefonoAvisar-error" class="error text-danger" for="telefonoAvisar" style="display:none">Campo faltante</span>
                </div>
            
            </div>
            
            <div class="row">
                <div class="form-group col-6" id="imgElectorDiv">
                    <label for="imgElector" class="col-form-label">Credencial de elector:</label>
                    <input type="file" id="imgElector" maxlength="100" name="imgElector" style="padding-top:20px">
                    <div class="col-12">
                            <img id="previewElector" src="http://placehold.it/250" alt="your image" />
                    </div>
                    <span id="imgElector-error" class="error text-danger" for="imgElector" style="display:none">Campo faltante</span>
                </div>

                <div class="form-group col-6" id="imgLicenciaDiv">
                    <label for="imgLicencia" class="col-form-label">Licencia:</label>
                    <input type="file" class="form-control" id="imgLicencia" maxlength="100" name="imgLicencia" style="padding-top:20px">
                    <div class="col-12">
                            <img id="previewLicencia" src="http://placehold.it/250" alt="your image" />
                    </div>
                    <span id="imgLicencia-error" class="error text-danger" for="imgLicencia" style="display:none">Campo faltante</span>
                </div>
                <div class="form-group col-6" id="imgReversoElectorDiv">
                    <label for="imgReversoElector" class="col-form-label">Reverso de credencial elector:</label>
                    <input type="file" class="form-control" id="imgReversoElector" maxlength="100" name="imgReversoElector" style="padding-top:20px">
                    <div class="col-12">
                            <img id="previewReversoElector" src="http://placehold.it/250" alt="your image" />
                    </div>
                    <span id="imgReversoElector-error" class="error text-danger" for="imgReversoElector" style="display:none">Campo faltante</span>
                </div>
                <div class="form-group col-6" id="imgReversoLicenciaDiv">
                    <label for="imgReversoLicencia" class="col-form-label">Reverso de licencia:</label>
                    <input type="file" class="form-control" id="imgReversoLicencia" maxlength="100" name="imgReversoLicencia" style="padding-top:20px">
                    <div class="col-12">
                            <img id="previewReversoLicencia" src="http://placehold.it/250" alt="your image" />
                    </div>
                    <span id="imgReversoLicencia-error" class="error text-danger" for="imgReversoLicencia" style="display:none">Campo faltante</span>
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