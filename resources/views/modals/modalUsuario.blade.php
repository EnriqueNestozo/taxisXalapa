<div class="modal fade" role="dialog" id="modalDatosUsuario" aria-hidden="true" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Datos de usuario</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="datosUsuarioForm">

          <div class="container">
            <input type="text" style="display:none" id="idUsuario" name="idUsuario">
            
            <div class="form-group" id="nameDiv">
              <label for="name" class="col-form-label">Nombre:</label>
              <input type="text" class="form-control is-invalid" id="name" name="name" style="padding-top:20px">
              <span id="name-error" class="error text-danger" for="name" style="display:none">Campo faltante</span>
            </div>
            <div class="form-group" id="emailDiv">
              <label for="email" class="col-form-label">Correo:</label>
              <input type="email" class="form-control is-invalid" id="email" name="email" style="padding-top:20px">
              <span id="email-error" class="error text-danger" for="email" style="display:none">Campo faltante</span>
            </div>
            <div class="form-group" id="passwordDiv">
              <label for="password" class="col-form-label">Contraseña:</label>
              <input type="password" class="form-control is-invalid" id="password" name="password" style="padding-top:20px">
              <span id="password-error" class="error text-danger" for="password" style="display:none">Campo faltante</span>
            </div>
            <div class="form-group" id="rolDiv">
                <label for="rol" class="col-form-label">Rol:</label>
                <select class="form-control" id="rolSelect" name="rolSelect" style="width: 100%">
                    <option value="">Seleccione un rol...</option>
                    <option value="admin">Administrador</option>
                    <option value="capturista">Capturista</option>
                </select>  
              <span id="rol-error" class="error text-danger" for="rol" style="display:none">Campo faltante</span>
            </div>
            <div class="form-group" id="turnoDiv" style="display:none">
                <label for="turno" class="col-form-label">Turno:</label>
                <select class="form-control" id="turnoSelect" name="turno_id" style="width: 100%">
                    <option value="">Seleccione un turno...</option>
                    <option value="1">Turno 1 (6:00 - 14:00)</option>
                    <option value="2">Turno 2 (14:00 - 22:00)</option>
                    <option value="3">Turno 3 (22:00 - 6:00)</option>
                </select>   
              <span id="turno-error" class="error text-danger" for="turno" style="display:none">Campo faltante</span>
            </div>
            <div class="form-group" id="baseDiv" style="display:none">
                <label for="base" class="col-form-label">base:</label>
                <select class="form-control" id="baseSelect" name="base" style="width: 100%">
                    <option value="">Seleccione un base...</option>
                    <option value="1">Base 1 (001 - 100)</option>
                    <option value="2">Base 2 (101 - 200)</option>
                </select>   
              <span id="base-error" class="error text-danger" for="base" style="display:none">Campo faltante</span>
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-primary" onClick="guardarDatosUsuario()" id="registroUsuariobtn">Registrar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>