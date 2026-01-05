/* ================================================================
   MODULO: GESTIÓN DE PAGOS (TARJETAS) - JavaScript Puro
   ================================================================ */

let idTarjetaTemporal = null;

function renderTarjetasM() {
    const contenedor = document.getElementById('listaTarjetasModal');
    const tarjetas = JSON.parse(localStorage.getItem('tarjetasMaya')) || [];
    if (!contenedor) return;
    contenedor.innerHTML = '';

    tarjetas.forEach(t => {
        contenedor.innerHTML += `
            <div class="item-selection" id="card_item_${t.id}" onclick="seleccionarG('${t.id}')">
                <div class="info">
                    <strong>${t.numero}</strong>
                    <span>${t.nombre}</span>
                </div>
                <button class="btn-delete-card-modal" onclick="event.stopPropagation(); eliminarT_M(${t.id})">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </div>
        `;
    });

    const info = document.getElementById('infoLimite');
    const chk = document.getElementById('guardarT');
    
    if(tarjetas.length >= 2 && !idTarjetaTemporal) {
        if(info) info.innerHTML = '<div class="limit-msg-info"><i class="fa-solid fa-circle-info"></i> Límite de 2 tarjetas alcanzado.</div>';
        if(chk) { chk.checked = false; chk.disabled = true; }
    } else {
        if(info) info.innerHTML = '';
        if(chk) chk.disabled = false;
    }
}

function manejarGuardadoAutomatico() {
    const chk = document.getElementById('guardarT');
    const n = document.getElementById('cn').value.replace(/\s/g,'');
    const t = document.getElementById('ct').value;
    const e = document.getElementById('ce').value;
    let tarjetas = JSON.parse(localStorage.getItem('tarjetasMaya')) || [];

    if (chk && chk.checked) {
        if (n.length < 16 || t.length < 3) {
            Swal.showValidationMessage('Ingresa número y nombre para pre-guardar');
            chk.checked = false;
            return;
        }
        idTarjetaTemporal = Date.now();
        const nueva = { id: idTarjetaTemporal, numero: "**** **** **** " + n.slice(-4), nombre: t.toUpperCase(), exp: e };
        tarjetas.push(nueva);
        localStorage.setItem('tarjetasMaya', JSON.stringify(tarjetas));
        renderTarjetasM();
        seleccionarG(idTarjetaTemporal);
    } else {
        if (idTarjetaTemporal) {
            tarjetas = tarjetas.filter(x => x.id !== idTarjetaTemporal);
            localStorage.setItem('tarjetasMaya', JSON.stringify(tarjetas));
            idTarjetaTemporal = null;
            renderTarjetasM();
            marcarCheck(false);
        }
    }
    if(typeof renderTarjetas === 'function') renderTarjetas();
}

function seleccionarG(id) {
    document.querySelectorAll('.item-selection').forEach(el => el.classList.remove('selected'));
    const formN = document.getElementById('formNuevaT');
    if(formN) formN.classList.remove('selected');
    
    const item = document.getElementById('card_item_'+id);
    if(item) item.classList.add('selected');
    marcarCheck(true);
}

function validarNuevaT() {
    const n = document.getElementById('cn').value.replace(/\s/g,'');
    const t = document.getElementById('ct').value;
    if(n.length < 16 || t.length < 3) {
        Swal.showValidationMessage('Datos de tarjeta incompletos');
        return;
    }
    document.querySelectorAll('.item-selection').forEach(el => el.classList.remove('selected'));
    if(idTarjetaTemporal) {
        const item = document.getElementById('card_item_' + idTarjetaTemporal);
        if(item) item.classList.add('selected');
    }
    const formN = document.getElementById('formNuevaT');
    if(formN) formN.classList.add('selected');
    marcarCheck(true);
    Swal.resetValidationMessage();
}

function eliminarT_M(id) {
    Swal.fire({
        title: '¿Eliminar tarjeta?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#2c656d',
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar'
    }).then((r) => {
        if(r.isConfirmed) {
            let ts = JSON.parse(localStorage.getItem('tarjetasMaya')) || [];
            ts = ts.filter(x => x.id !== id);
            localStorage.setItem('tarjetasMaya', JSON.stringify(ts));
            if(id === idTarjetaTemporal) idTarjetaTemporal = null;
            if(typeof renderTarjetas === 'function') renderTarjetas();
        }
        if(typeof mostrarModalPrincipal === 'function') mostrarModalPrincipal();
    });
}

function formatT(i) {
    if(i.id==='cn'){ 
        i.value=i.value.replace(/\D/g,'').match(/.{1,4}/g)?.join(' ')||''; 
        const vn = document.getElementById('vn');
        if(vn) vn.innerText=i.value||"#### #### #### ####"; 
    }
    if(i.id==='ct'){ 
        i.value=i.value.replace(/[0-9]/g, ''); 
        const vt = document.getElementById('vt');
        if(vt) vt.innerText=i.value.toUpperCase()||"TITULAR"; 
    }
    if(i.id==='ce'){ 
        let v=i.value.replace(/\D/g,''); if(v.length>2) v=v.substring(0,2)+'/'+v.substring(2,4); i.value=v; 
        const ve = document.getElementById('ve');
        if(ve) ve.innerText=v||"MM/AA"; 
    }
    if(i.id==='cc'){ 
        i.value=i.value.replace(/\D/g,''); 
        const vc = document.getElementById('vc');
        if(vc) vc.innerText=i.value||"***"; 
    }
}

function flip(b) { 
    const card = document.getElementById('cardVisual');
    if(card) card.style.transform = b ? 'rotateY(180deg)' : 'rotateY(0deg)'; 
}

function toggleNuevaT() { 
    const f = document.getElementById('formNuevaT'); 
    if(f) f.style.display = (f.style.display === 'none' || f.style.display === '') ? 'block' : 'none'; 
}