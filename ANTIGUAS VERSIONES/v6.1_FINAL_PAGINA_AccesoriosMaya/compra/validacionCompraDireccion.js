/* ================================================================
   MODULO: GESTIÓN DE ENVÍOS (AUTO-RELLENO Y PERSISTENCIA)
   ================================================================ */

let idDireccionSeleccionada = null; 
let mapaModal = null;
let marcadorModal = null;

/**
 * Función de Geocodificación Inversa (Auto-relleno)
 */
async function obtenerDireccionDesdeCoordsM(lat, lng) {
    try {
        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`);
        const data = await response.json();
        
        if (data.address) {
            const calle = data.address.road || data.address.pedestrian || "";
            const numero = data.address.house_number || "";
            const ciudad = data.address.city || data.address.town || data.address.state || "";
            const cp = data.address.postcode || "";

            document.getElementById('dirCalleM').value = (calle + " " + numero).trim();
            document.getElementById('dirCiudadM').value = ciudad;
            document.getElementById('dirCPM').value = cp;
        }
    } catch (error) {
        console.error("Error al obtener dirección en modal:", error);
    }
}

/**
 * Renderiza las direcciones guardadas manteniendo la selección visual
 */
function renderDireccionesM() {
    const contenedor = document.getElementById('listaDireccionesModal');
    const direcciones = JSON.parse(localStorage.getItem('direccionesMaya')) || [];
    if (!contenedor) return;
    contenedor.innerHTML = '';

    direcciones.forEach(d => {
        const esSeleccionada = (idDireccionSeleccionada == d.id) ? 'selected' : '';
        
        contenedor.innerHTML += `
            <div class="item-selection ${esSeleccionada}" id="dir_item_${d.id}" onclick="seleccionarD('${d.id}')">
                <div class="info">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <i class="fa-solid fa-location-dot" style="color:#2c656d;"></i>
                        <strong>${d.calle}</strong>
                    </div>
                    <span>${d.ciudad}, CP ${d.cp} ${d.depto ? ' • ' + d.depto : ''}</span>
                </div>
                <button class="btn-delete-card-modal" onclick="event.stopPropagation(); eliminarD_M(${d.id})">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </div>
        `;
    });

    const info = document.getElementById('infoLimiteDir');
    const btnGuardar = document.getElementById('btnGuardarD');
    
    // Verificamos si la selección actual es la temporal para mantener el estilo al re-renderizar
    const formN = document.getElementById('formNuevaD');
    if(idDireccionSeleccionada === 'temporal' && formN) {
        formN.classList.add('selected');
    }

    if (direcciones.length >= 3) {
        if (info) info.innerHTML = `<div class="limit-msg-info" style="color:#856404; background:#fff3cd; padding:8px; border-radius:10px; font-size:0.7rem; margin-bottom:10px; border:1px solid #ffeeba;"><i class="fa-solid fa-circle-info"></i> Límite de 3 alcanzado. Esta ubicación se usará solo para este pedido.</div>`;
        if (btnGuardar) btnGuardar.innerHTML = '<i class="fa-solid fa-check"></i> Usar esta ubicación';
    } else {
        if (info) info.innerHTML = '';
        if (btnGuardar) btnGuardar.innerHTML = '<i class="fa-solid fa-plus"></i> Guardar y Usar';
    }
}

/**
 * Selecciona una dirección (Guardada o Temporal)
 */
function seleccionarD(id) {
    idDireccionSeleccionada = id;
    
    // Limpiar todas las selecciones de la lista
    document.querySelectorAll('#listaDireccionesModal .item-selection').forEach(el => el.classList.remove('selected'));
    
    // Limpiar selección del formulario manual
    const formN = document.getElementById('formNuevaD');
    if (formN) formN.classList.remove('selected');

    if (id === 'temporal') {
        if (formN) formN.classList.add('selected');
    } else {
        const item = document.getElementById('dir_item_' + id);
        if (item) item.classList.add('selected');
    }

    marcarCheckEnvio(true); 
}

/**
 * Valida la nueva dirección
 */
function validarNuevaD() {
    const ciudad = document.getElementById('dirCiudadM').value.trim();
    const cp = document.getElementById('dirCPM').value.trim();
    const calle = document.getElementById('dirCalleM').value.trim();
    const depto = document.getElementById('dirDeptoM').value;
    const coords = marcadorModal.getLatLng();

    if (!ciudad || !cp || !calle) {
        Swal.showValidationMessage('Mueve el marcador para obtener la dirección');
        return;
    }

    let direcciones = JSON.parse(localStorage.getItem('direccionesMaya')) || [];

    if (direcciones.length < 3) {
        const nueva = { id: Date.now(), ciudad, cp, calle, depto, lat: coords.lat, lng: coords.lng };
        direcciones.push(nueva);
        localStorage.setItem('direccionesMaya', JSON.stringify(direcciones));
        renderDireccionesM();
        seleccionarD(nueva.id);
        toggleNuevaD(); // Se cierra pero la lista mostrará el nuevo ítem seleccionado
    } else {
        // USO TEMPORAL: No se cierra el formulario, se queda abierto y se contornea
        seleccionarD('temporal');
        Swal.resetValidationMessage();
        // Opcional: Desplazar el scroll hacia el formulario para que el usuario vea que se seleccionó
        document.getElementById('formNuevaD').scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

/**
 * Inicializa el mapa del modal
 */
function initMapaModal() {
    if (mapaModal) {
        setTimeout(() => mapaModal.invalidateSize(), 100);
        return;
    }

    const latInit = 19.4326, lngInit = -99.1332;
    mapaModal = L.map('mapModal').setView([latInit, lngInit], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(mapaModal);
    marcadorModal = L.marker([latInit, lngInit], { draggable: true }).addTo(mapaModal);

    marcadorModal.on('dragend', function(e) {
        const coords = e.target.getLatLng();
        obtenerDireccionDesdeCoordsM(coords.lat, coords.lng);
    });

    mapaModal.on('click', function(e) {
        marcadorModal.setLatLng(e.latlng);
        obtenerDireccionDesdeCoordsM(e.latlng.lat, e.latlng.lng);
    });

    setTimeout(() => mapaModal.invalidateSize(), 400);
}

function toggleNuevaD() {
    const f = document.getElementById('formNuevaD');
    if (!f) return;
    const estaOculto = (f.style.display === 'none' || f.style.display === '');
    f.style.display = estaOculto ? 'block' : 'none';
    
    // Si cerramos el formulario manualmente y estaba seleccionado como temporal, 
    // quitamos la selección de envío completado para evitar errores.
    if (!estaOculto && idDireccionSeleccionada === 'temporal') {
        idDireccionSeleccionada = null;
        marcarCheckEnvio(false);
    }

    if (estaOculto) initMapaModal();
}

function eliminarD_M(id) {
    let ds = JSON.parse(localStorage.getItem('direccionesMaya')) || [];
    ds = ds.filter(x => x.id !== id);
    localStorage.setItem('direccionesMaya', JSON.stringify(ds));
    
    if (idDireccionSeleccionada == id) {
        idDireccionSeleccionada = null;
        marcarCheckEnvio(false);
    }
    renderDireccionesM();
}