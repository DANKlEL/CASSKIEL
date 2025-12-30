<div id="pagos" class="tab-content" style="display:none;">
    <h3>Métodos de Pago</h3>
    <p class="subtitle-p">Gestiona tus tarjetas guardadas. Los datos se cifran de forma segura.</p>

    <div class="card-container">
        <div class="credit-card" id="creditCard">
            <div class="card-front">
                <div class="card-chip"></div>
                <div class="card-logo" id="cardLogo"><i class="fa-solid fa-credit-card"></i></div>
                <div class="card-number-display" id="displayNumero">#### #### #### ####</div>
                <div class="card-details">
                    <div class="detail-group">
                        <label>Titular</label>
                        <div class="detail-name" id="displayName">NOMBRE DEL TITULAR</div>
                    </div>
                    <div class="detail-group">
                        <label>Expira</label>
                        <div class="detail-expiry" id="displayExp">MM/AA</div>
                    </div>
                </div>
            </div>
            <div class="card-back">
                <div class="card-bar"></div>
                <div class="card-cvv-section">
                    <label>CVV</label>
                    <div class="cvv-box" id="displayCVV">***</div>
                </div>
                <div class="card-text-back">Esta tarjeta es para uso exclusivo en Accesorios Maya.</div>
            </div>
        </div>
    </div>

    <div class="grid-form" style="margin-top: 20px;">
        <div class="form-group" style="grid-column: span 2;">
            <label>Número de Tarjeta</label>
            <input type="text" id="cardNum" maxlength="19" placeholder="0000 0000 0000 0000" oninput="actualizarTarjeta()">
        </div>
        <div class="form-group" style="grid-column: span 2;">
            <label>Nombre en la Tarjeta</label>
            <input type="text" id="cardName" placeholder="Ej. Juan Pérez" oninput="actualizarTarjeta()">
        </div>
        <div class="form-group">
            <label>Fecha de Expiración</label>
            <input type="text" id="cardExp" maxlength="5" placeholder="MM/AA" oninput="actualizarTarjeta()">
        </div>
        <div class="form-group">
            <label>CVV</label>
            <input type="text" id="cardCVV" maxlength="3" placeholder="123" 
                   onfocus="voltearTarjeta(true)" onblur="voltearTarjeta(false)" oninput="actualizarTarjeta()">
        </div>
    </div>

    <button class="btn-save" onclick="guardarPago()">
        <i class="fa-solid fa-shield-halved"></i> Guardar Método de Pago
    </button>
</div>