<div id="pagos" class="tab-content" style="display:none;">
    <h3>Métodos de Pago</h3>
    <p class="subtitle-p">Gestiona tus tarjetas guardadas (Máximo 2). Los datos se cifran de forma segura.</p>

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
            <input type="text" id="cardNum" maxlength="19" placeholder="0000 0000 0000 0000" 
                   oninput="this.value = this.value.replace(/[^0-9]/g, ''); actualizarTarjeta();">
        </div>
        <div class="form-group" style="grid-column: span 2;">
            <label>Nombre en la Tarjeta</label>
            <input type="text" id="cardName" placeholder="Ej. Juan Pérez" 
                   oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ ]/g, ''); actualizarTarjeta();">
        </div>
        <div class="form-group">
            <label>Fecha de Expiración</label>
            <input type="text" id="cardExp" maxlength="5" placeholder="MM/AA" 
                   oninput="this.value = this.value.replace(/[^0-9/]/g, ''); actualizarTarjeta();">
        </div>
        <div class="form-group">
            <label>CVV</label>
            <input type="text" id="cardCVV" maxlength="3" placeholder="123" 
                   onfocus="voltearTarjeta(true)" onblur="voltearTarjeta(false)" 
                   oninput="this.value = this.value.replace(/[^0-9]/g, ''); actualizarTarjeta();">
        </div>
    </div>

    <button class="btn-save" onclick="intentarGuardarPago()">
        <i class="fa-solid fa-shield-halved"></i> Guardar Método de Pago
    </button>

    <div class="direcciones-guardadas-container" style="margin-top: 30px;">
        <h4>Tus Tarjetas (Máx. 2)</h4>
        <div id="listaTarjetas" class="direcciones-grid"></div>
    </div>
</div>

<script>
let tarjetasGuardadas = JSON.parse(localStorage.getItem('tarjetasMaya')) || [];

function actualizarTarjeta() {
    // 1. Formatear Número de Tarjeta (grupos de 4)
    let numInput = document.getElementById('cardNum');
    let numValue = numInput.value.replace(/\s+/g, '');
    let formattedNum = numValue.match(/.{1,4}/g)?.join(' ') || '';
    numInput.value = formattedNum;
    document.getElementById('displayNumero').innerText = formattedNum || "#### #### #### ####";
    
    // 2. Nombre (Solo visualización)
    document.getElementById('displayName').innerText = document.getElementById('cardName').value.toUpperCase() || "NOMBRE DEL TITULAR";
    
    // 3. Formatear Expiración (MM/AA)
    let expInput = document.getElementById('cardExp');
    let expValue = expInput.value.replace(/\//g, '');
    if (expValue.length > 2) {
        expValue = expValue.substring(0, 2) + '/' + expValue.substring(2, 4);
    }
    expInput.value = expValue;
    document.getElementById('displayExp').innerText = expValue || "MM/AA";
    
    // 4. CVV
    document.getElementById('displayCVV').innerText = document.getElementById('cardCVV').value || "***";
}

function voltearTarjeta(lado) {
    const card = document.getElementById('creditCard');
    if (lado) card.classList.add('flipped');
    else card.classList.remove('flipped');
}

function intentarGuardarPago() {
    const num = document.getElementById('cardNum').value.replace(/\s/g, '');
    const nombre = document.getElementById('cardName').value.trim();
    const exp = document.getElementById('cardExp').value;
    const cvv = document.getElementById('cardCVV').value;

    if (num.length < 16) {
        Swal.fire('Error', 'El número de tarjeta debe tener 16 dígitos', 'error');
        return;
    }
    if (nombre.length < 5) {
        Swal.fire('Error', 'Por favor ingresa el nombre completo del titular', 'error');
        return;
    }
    if (exp.length < 5) {
        Swal.fire('Error', 'Formato de expiración inválido (MM/AA)', 'error');
        return;
    }
    if (cvv.length < 3) {
        Swal.fire('Error', 'El CVV debe tener 3 dígitos', 'error');
        return;
    }

    if (tarjetasGuardadas.length >= 2) {
        Swal.fire('Límite alcanzado', 'Solo puedes guardar un máximo de 2 tarjetas.', 'warning');
        return;
    }

    const nuevaTarjeta = {
        id: Date.now(),
        numero: "**** **** **** " + num.slice(-4),
        nombre: nombre.toUpperCase(),
        exp: exp
    };

    tarjetasGuardadas.push(nuevaTarjeta);
    localStorage.setItem('tarjetasMaya', JSON.stringify(tarjetasGuardadas));
    
    // Limpiar campos
    document.getElementById('cardNum').value = '';
    document.getElementById('cardName').value = '';
    document.getElementById('cardExp').value = '';
    document.getElementById('cardCVV').value = '';
    actualizarTarjeta();
    
    renderTarjetas();
    Swal.fire('Éxito', 'Tarjeta guardada de forma segura', 'success');
}

function renderTarjetas() {
    const container = document.getElementById('listaTarjetas');
    if (!container) return;
    container.innerHTML = '';

    tarjetasGuardadas.forEach(t => {
        container.innerHTML += `
            <div class="direccion-card">
                <div style="display:flex; align-items:center; gap:10px;">
                    <i class="fa-solid fa-credit-card" style="color:#2c656d; font-size:1.5rem;"></i>
                    <div>
                        <strong style="display:block;">${t.numero}</strong>
                        <small style="color:#666;">${t.nombre} | Exp: ${t.exp}</small>
                    </div>
                </div>
                <button class="btn-delete-mini" onclick="eliminarTarjeta(${t.id})" style="margin-left:auto; background: #fee; border-radius: 50%; border: none; width: 25px; height: 25px; color: red; cursor: pointer;">&times;</button>
            </div>
        `;
    });
}

function eliminarTarjeta(id) {
    tarjetasGuardadas = tarjetasGuardadas.filter(t => t.id !== id);
    localStorage.setItem('tarjetasMaya', JSON.stringify(tarjetasGuardadas));
    renderTarjetas();
}

document.addEventListener('DOMContentLoaded', renderTarjetas);
</script>

<style>
/* Estilos necesarios para la tarjeta */
.credit-card { width: 320px; height: 190px; perspective: 1000px; margin: 0 auto; position: relative; color: white; }
.card-front, .card-back { width: 100%; height: 100%; background: linear-gradient(135deg, #2c656d, #4a9ea8); border-radius: 15px; position: absolute; backface-visibility: hidden; transition: transform 0.6s; padding: 20px; box-sizing: border-box; box-shadow: 0 8px 15px rgba(0,0,0,0.2); }
.card-back { transform: rotateY(180deg); background: linear-gradient(135deg, #1e464b, #2c656d); }
.credit-card.flipped .card-front { transform: rotateY(180deg); }
.credit-card.flipped .card-back { transform: rotateY(0deg); }
.card-chip { width: 45px; height: 35px; background: linear-gradient(135deg, #ffd700, #b8860b); border-radius: 5px; margin-bottom: 20px; }
.card-number-display { font-family: 'Courier New', Courier, monospace; font-size: 1.25rem; letter-spacing: 2px; margin-bottom: 20px; text-shadow: 1px 1px 2px rgba(0,0,0,0.5); }
.card-details { display: flex; justify-content: space-between; font-family: 'Poppins', sans-serif; }
.detail-group label { font-size: 0.6rem; text-transform: uppercase; opacity: 0.8; display: block; }
.detail-name, .detail-expiry { font-size: 0.85rem; font-weight: 600; }
.card-bar { background: #111; width: 115%; height: 45px; margin: 0 -20px 20px -20px; }
.card-cvv-section { background: white; color: black; padding: 8px; border-radius: 4px; text-align: right; width: 80%; margin: 0 auto; }
.card-text-back { font-size: 0.5rem; text-align: center; margin-top: 20px; opacity: 0.7; }
</style>