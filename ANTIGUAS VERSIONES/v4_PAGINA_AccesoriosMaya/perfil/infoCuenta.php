<div id="cuenta" class="tab-content active">
    <h3>Configuración de la Cuenta</h3>
    
    <div class="form-group">
        <label>Nombre Completo (Solo lectura)</label>
        <input type="text" id="perfilNombre" readonly class="input-blocked">
    </div>

    <div class="form-group">
        <label>Correo Electrónico</label>
        <input type="email" id="perfilEmail">
    </div>
    
    <hr class="separator">
    
    <h3>Seguridad</h3>
    
    <div class="form-group">
        <label>Contraseña Actual</label>
        <div class="input-password-wrapper">
            <input type="password" id="currentPass" readonly class="input-blocked">
            <button type="button" class="toggle-pass" onclick="toggleVisibility('currentPass', this)">
                <i class="fa-solid fa-eye"></i>
            </button>
        </div>
    </div>

    <div class="form-group">
        <label>Nueva Contraseña</label>
        <div class="input-password-wrapper">
            <input type="password" id="newPass" placeholder="Nueva contraseña">
            <button type="button" class="toggle-pass" onclick="toggleVisibility('newPass', this)">
                <i class="fa-solid fa-eye"></i>
            </button>
        </div>
    </div>

    <div class="form-group">
        <label>Confirmar Nueva Contraseña</label>
        <div class="input-password-wrapper">
            <input type="password" id="confirmNewPass" placeholder="Repite la contraseña">
            <button type="button" class="toggle-pass" onclick="toggleVisibility('confirmNewPass', this)">
                <i class="fa-solid fa-eye"></i>
            </button>
        </div>
    </div>

    <button class="btn-save" onclick="guardarCambiosCuenta()">Guardar Cambios</button>
</div>