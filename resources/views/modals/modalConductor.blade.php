<div class="modal fade" role="dialog" id="modalRegistroConductor" aria-hidden="true" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Datos del conductor</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="datosConductorForm">
            <input type="text" style="display:none" id="idConductor" name="idConductor">
            <div class="row"> 
                <div class="form-group col-lg-6 col-md-6 col-sm-6" id="turnoDiv">
                    <label for="turno" class="col-form-label">Turno:</label>
                        <select class="custom-select" id="turno" name="turno" style="width: 100%">
                            <option value="1">Mañana</option>
                            <option value="2">Tarde</option>
                        </select>
                    <span id="turno-error" class="error text-danger" for="turno" style="display:none">Campo faltante</span>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="col-12">
                        <img id="previewFotoPersona" src="http://placehold.it/250" alt="your image" />
                    </div>
                    <div class="col-12">
                        <input type='file' onchange="readURL(this,'previewFotoPersona');" id="fotoPersona"/> 
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12" id="nombreDiv">
                        <label for="nombre" class="col-form-label">Nombre:</label>
                        <input type="text" class="form-control is-invalid" id="nombre" name="nombre" style="padding-top:20px">
                        <span id="nombre-error" class="error text-danger" for="nombre" style="display:none">Campo faltante</span>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12" id="primer_apellidoDiv">
                        <label for="primer_apellido" class="col-form-label">Apellido Paterno:</label>
                        <input type="text" class="form-control is-invalid" id="primer_apellido" name="primer_apellido" style="padding-top:20px">
                        <span id="primer_apellido-error" class="error text-danger" for="primer_apellido" style="display:none">Campo faltante</span>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12" id="segundo_apellidoDiv">
                        <label for="segundo_apellido" class="col-form-label">Apellido Materno:</label>
                        <input type="text" class="form-control is-invalid" id="segundo_apellido" name="segundo_apellido" style="padding-top:20px">
                        <span id="segundo_apellido-error" class="error text-danger" for="segundo_apellido" style="display:none">Campo faltante</span>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12" id="calleDiv">
                        <label for="calle" class="col-form-label">Calle:</label>
                        <input type="text" class="form-control is-invalid" id="calle" name="calle" style="padding-top:20px">
                        <span id="calle-error" class="error text-danger" for="calle" style="display:none">Campo faltante</span>
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
                    <div class="form-group col-lg-12 col-md-12 col-sm-12" id="telefono_fijoDiv">
                        <label for="telefono_fijo" class="col-form-label">Teléfono:</label>
                        <input type="text" class="form-control" id="telefono_fijo" maxlength="100" name="telefono_fijo" style="padding-top:20px">
                        <span id="telefono_fijo-error" class="error text-danger" for="telefono_fijo" style="display:none">Campo faltante</span>
                    </div>
                    <div class="form-group col-lg-12 col-md-12 col-sm-12" id="celularDiv">
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
                    <div class="form-group col-lg-12 col-md-12 col-sm-12" id="tipo_sangreDiv">
                        <label for="tipo_sangre" class="col-form-label">Tipo de sangre:</label>
                        <input type="text" class="form-control" id="tipo_sangre" maxlength="100" name="tipo_sangre" style="padding-top:20px">
                        <span id="tipo_sangre-error" class="error text-danger" for="tipo_sangre" style="display:none">Campo faltante</span>
                    </div>
                </div>
            </div>
            <br>
            <div class="row" style="padding-left:1em;">
                <div class="form-group col-6" id="persona_referenciaDiv">
                    <label for="persona_referencia" class="col-form-label">Nombre de la esposa y/o referencia:</label>
                    <input type="text" class="form-control" id="persona_referencia" maxlength="100" name="persona_referencia" style="padding-top:20px">
                    <span id="persona_referencia-error" class="error text-danger" for="persona_referencia" style="display:none">Campo faltante</span>
                </div>
                <div class="form-group col-6" id="telefono_referenciaDiv">
                    <label for="telefono_referencia" class="col-form-label">Teléfono referencia:</label>
                    <input type="text" class="form-control" id="telefono_referencia" maxlength="100" name="telefono_referencia" style="padding-top:20px">
                    <span id="telefono_referencia-error" class="error text-danger" for="telefono_referencia" style="display:none">Campo faltante</span>
                </div>
            </div>

            <div class="row" style="padding-left:1em;">
                <div class="form-group col-6" id="emergencia_referenciaDiv">
                    <label for="emergencia_referencia" class="col-form-label">En emergencia avisar a:</label>
                    <input type="text" class="form-control" id="emergencia_referencia" maxlength="100" name="emergencia_referencia" style="padding-top:20px">
                    <span id="emergencia_referencia-error" class="error text-danger" for="emergencia_referencia" style="display:none">Campo faltante</span>
                </div>
                <div class="form-group col-6" id="telefono_emergencia_referenciaDiv">
                    <label for="telefono_emergencia_referencia" class="col-form-label">Teléfono emergencia:</label>
                    <input type="text" class="form-control" id="telefono_emergencia_referencia" maxlength="100" name="telefono_emergencia_referencia" style="padding-top:20px">
                    <span id="telefono_emergencia_referencia-error" class="error text-danger" for="telefono_emergencia_referencia" style="display:none">Campo faltante</span>
                </div>
            
            </div>
            
            <div class="row">
                <div class="col-6" id="imgElectorDiv">
                    <label for="imgElector" class="col-form-label">Credencial de elector:</label>
                    <div class="col-12">
                        <img id="previewElector" src="http://placehold.it/250" alt="your image" />
                    </div>
                    <div class="col-12">
                        <input type='file' onchange="readURL(this,'previewElector');" id="fotoElector"/> 
                    </div>
                    <span id="imgElector-error" class="error text-danger" for="imgElector" style="display:none">Campo faltante</span>
                </div>

                <div class="col-6" id="imgLicenciaDiv">
                    <label for="imgLicencia" class="col-form-label">Licencia:</label>
                    <div class="col-12">
                        <img id="previewLicencia" src="http://placehold.it/250" alt="your image" />
                    </div>
                    <div class="col-12">
                        <input type='file' onchange="readURL(this,'previewLicencia');" id="fotoLicencia"/> 
                    </div>
                    <span id="imgLicencia-error" class="error text-danger" for="imgLicencia" style="display:none">Campo faltante</span>
                </div>
                <div class="col-6" id="imgReversoElectorDiv">
                    <label for="imgReversoElector" class="col-form-label">Reverso de credencial elector:</label>
                    <div class="col-12">
                        <img id="previewReversoElector" src="http://placehold.it/250" alt="your image" />
                    </div>
                    <div class="col-12">
                        <input type='file' onchange="readURL(this,'previewReversoElector');" id="fotoElectorReverso"/> 
                    </div>
                    <span id="imgReversoElector-error" class="error text-danger" for="imgReversoElector" style="display:none">Campo faltante</span>
                </div>
                <div class="col-6" id="imgReversoLicenciaDiv">
                    <label for="imgReversoLicencia" class="col-form-label">Reverso de licencia:</label>
                    <div class="col-12">
                        <img id="previewReversoLicencia" src="http://placehold.it/250" alt="your image" />
                    </div>
                    <div class="col-12">
                        <input type='file' onchange="readURL(this,'previewReversoLicencia');" id="fotoLicenciaReverso"/> 
                    </div>
                    <span id="imgReversoLicencia-error" class="error text-danger" for="imgReversoLicencia" style="display:none">Campo faltante</span>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-primary" onClick="registrarDatosConductor()" id="registroConductorbtn">Registrar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>