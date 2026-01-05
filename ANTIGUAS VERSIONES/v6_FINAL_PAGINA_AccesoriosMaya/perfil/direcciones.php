<div id="direcciones" class="tab-content" style="display:none;">
    <h3>Direcciones de Envío</h3>
    <p class="subtitle-p">Puedes guardar hasta 3 direcciones. Selecciona una con el círculo para usarla como predeterminada.</p>

    <div class="map-container-wrapper" style="margin-bottom: 20px;">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <div id="map" style="width: 100%; height: 300px; border-radius: 12px; border: 1px solid #ddd; z-index: 1; background-color: #f8f9fa;"></div>
        <p style="font-size: 0.75rem; color: #666; margin-top: 5px;"><i class="fa-solid fa-circle-info"></i> Mueve el marcador azul para autocompletar la dirección.</p>
    </div>

    <div class="grid-form">
        <div class="form-group">
            <label>Ciudad / Estado</label>
            <input type="text" id="dirCiudad" placeholder="Ej: Ciudad de México" class="input-address">
        </div>
        <div class="form-group">
            <label>Código Postal</label>
            <input type="text" id="dirCP" placeholder="15420" class="input-address">
        </div>
        <div class="form-group">
            <label>Calle y Número</label>
            <input type="text" id="dirCalle" placeholder="C. Transvaal 15" class="input-address">
        </div>
        <div class="form-group">
            <label>Tipo de Vivienda</label>
            <select id="dirDepto" class="input-address" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
                <option value="">Selecciona una opción...</option>
                <option value="Casa">Casa</option>
                <option value="Departamento">Departamento</option>
                <option value="Oficina">Oficina</option>
                <option value="Local">Local Comercial</option>
            </select>
        </div>
    </div>

    <button class="btn-save" onclick="intentarGuardarDireccion()">
        <i class="fa-solid fa-plus"></i> Guardar Nueva Dirección
    </button>

    <div class="direcciones-guardadas-container" style="margin-top: 30px;">
        <h4>Tus Direcciones (Máx. 3)</h4>
        <div id="listaDirecciones" class="direcciones-grid"></div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
// --- GESTIÓN DE PERSISTENCIA ---
// Esta función asegura que siempre leamos lo último que hay en el navegador
function obtenerDireccionesDeStorage() {
    return JSON.parse(localStorage.getItem('direccionesMaya')) || [];
}

let mapaPrincipal = null;
let marcadorPrincipal = null;

// --- AUTO-RELLENO ---
async function obtenerDireccionDesdeCoords(lat, lng) {
    try {
        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`);
        const data = await response.json();
        
        if (data.address) {
            const calle = data.address.road || data.address.pedestrian || "";
            const numero = data.address.house_number || "";
            const ciudad = data.address.city || data.address.town || data.address.state || "";
            const cp = data.address.postcode || "";

            document.getElementById('dirCalle').value = (calle + " " + numero).trim();
            document.getElementById('dirCiudad').value = ciudad;
            document.getElementById('dirCP').value = cp;
        }
    } catch (error) {
        console.error("Error al obtener dirección:", error);
    }
}

// --- MAPA ---
function initMapaDirecciones() {
    if (mapaPrincipal) {
        setTimeout(() => mapaPrincipal.invalidateSize(), 200);
        return;
    }

    const latInit = 19.4326, lngInit = -99.1332;
    mapaPrincipal = L.map('map').setView([latInit, lngInit], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(mapaPrincipal);

    marcadorPrincipal = L.marker([latInit, lngInit], { draggable: true }).addTo(mapaPrincipal);

    marcadorPrincipal.on('dragend', function(e) {
        const coords = e.target.getLatLng();
        obtenerDireccionDesdeCoords(coords.lat, coords.lng);
    });

    mapaPrincipal.on('click', function(e) {
        marcadorPrincipal.setLatLng(e.latlng);
        obtenerDireccionDesdeCoords(e.latlng.lat, e.latlng.lng);
    });

    setTimeout(() => mapaPrincipal.invalidateSize(), 300);
}

// --- ACCIONES ---
function intentarGuardarDireccion() {
    const ciudad = document.getElementById('dirCiudad').value.trim();
    const cp = document.getElementById('dirCP').value.trim();
    const calle = document.getElementById('dirCalle').value.trim();
    const depto = document.getElementById('dirDepto').value;
    const coords = marcadorPrincipal.getLatLng();

    if (!ciudad || !cp || !calle) {
        Swal.fire('Atención', 'Datos incompletos. Mueve el marcador en el mapa.', 'warning');
        return;
    }

    let ds = obtenerDireccionesDeStorage();

    if (ds.length >= 3) {
        Swal.fire('Límite', 'Máximo 3 direcciones permitidas.', 'info');
        return;
    }

    ds.push({ id: Date.now(), ciudad, cp, calle, depto, lat: coords.lat, lng: coords.lng });
    localStorage.setItem('direccionesMaya', JSON.stringify(ds));

    ['dirCiudad', 'dirCP', 'dirCalle', 'dirDepto'].forEach(id => document.getElementById(id).value = '');
    renderDirecciones();
    Swal.fire('Éxito', 'Dirección guardada correctamente', 'success');
}

function renderDirecciones() {
    const container = document.getElementById('listaDirecciones');
    if (!container) return;
    
    const ds = obtenerDireccionesDeStorage();
    container.innerHTML = '';

    ds.forEach(d => {
        container.innerHTML += `
            <div class="direccion-card" style="display:flex; justify-content:space-between; align-items:center; padding:15px; border:1px solid #eee; margin-bottom:10px; border-radius:10px; background:#fff;">
                <div>
                    <strong style="color:#2c656d; display:block;">${d.calle}</strong>
                    <small style="color:#666;">${d.ciudad}, CP ${d.cp} ${d.depto ? ' • ' + d.depto : ''}</small>
                </div>
                <button onclick="confirmarEliminar(${d.id})" style="background:#fff5f5; border:none; color:#ff4d4d; border-radius:50%; width:32px; height:32px; cursor:pointer;">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </div>
        `;
    });
}

function confirmarEliminar(id) {
    Swal.fire({
        title: '¿Eliminar dirección?',
        text: "Se borrará de tu cuenta permanentemente.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#2c656d',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            let ds = obtenerDireccionesDeStorage();
            ds = ds.filter(d => d.id !== id);
            localStorage.setItem('direccionesMaya', JSON.stringify(ds));
            renderDirecciones();
            Swal.fire('Borrado', 'Dirección eliminada.', 'success');
        }
    });
}

// --- CARGA INICIAL ---
document.addEventListener('DOMContentLoaded', () => {
    // Al cargar la página, dibujar lo que ya esté en localStorage
    renderDirecciones();

    const observer = new MutationObserver((mutations) => {
        mutations.forEach((m) => {
            if (m.target.id === 'direcciones' && window.getComputedStyle(m.target).display !== 'none') {
                initMapaDirecciones();
                renderDirecciones(); // Re-renderizar al entrar a la pestaña para asegurar frescura
            }
        });
    });
    observer.observe(document.getElementById('direcciones'), { attributes: true });
});
</script>