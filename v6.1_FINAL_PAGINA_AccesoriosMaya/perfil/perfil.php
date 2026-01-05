<?php 
/**
 * PERFIL.PHP 
 * Página de gestión de usuario de Accesorios Maya.
 * Se han deshabilitado los asistentes de IA para esta sección.
 */
include '../estructura/head.php'; 
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="/AccesoriosMaya/css/perfil/perfil.css">

<style>
    /* Ocultar lanzadores y ventanas de Maya AI y Dankiel */
    #maya-wrapper, 
    #maya-launcher, 
    #chat-window, 
    #chat-launcher-dankiel,
    .launcher-dankiel { 
        display: none !important; 
    }
    
    /* Ajuste de color global según tu nueva identidad visual */
    :root {
        --color-primario: #2c656d;
    }
</style>

<?php include '../estructura/header.php'; ?>

<div class="perfil-container">
    <div class="perfil-sidebar">
        <div class="user-info-header">
            <img src="/AccesoriosMaya/img/perfil.png" alt="Usuario" class="avatar-perfil">
            <h2 id="saludoUsuario">Mi Perfil</h2>
        </div>
        <nav class="perfil-tabs">
            <button class="tab-btn active" id="defaultOpen" onclick="openTab(event, 'cuenta')">
                <i class="fa-solid fa-user-gear"></i> Información de Cuenta
            </button>
            <button class="tab-btn" onclick="openTab(event, 'direcciones')">
                <i class="fa-solid fa-truck-fast"></i> Direcciones de Envío
            </button>
            <button class="tab-btn" onclick="openTab(event, 'pagos')">
                <i class="fa-solid fa-credit-card"></i> Información de Pago
            </button>
            <button class="tab-btn btn-logout" onclick="cerrarSesion()">
                <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión
            </button>
        </nav>
    </div>

    <div class="perfil-content">
        <?php 
            // Inclusión de componentes de pestañas
            include 'infoCuenta.php'; 
            include 'direcciones.php'; 
            include 'pagos.php'; 
        ?>
    </div>
</div>

<?php include '../estructura/footer.php'; ?>

<script>
let map, marker;

document.addEventListener('DOMContentLoaded', () => {
    // 1. Verificar sesión activa
    const usuarioActivo = JSON.parse(localStorage.getItem('usuarioActivo'));
    if (!usuarioActivo) { 
        window.location.href = '/AccesoriosMaya/login.php'; 
        return; 
    }
    
    // 2. Cargar datos iniciales del perfil
    document.getElementById('saludoUsuario').innerText = `Hola, ${usuarioActivo.nombre.split(' ')[0]}`;
    if(document.getElementById('perfilNombre')) document.getElementById('perfilNombre').value = usuarioActivo.nombre;
    if(document.getElementById('perfilEmail')) document.getElementById('perfilEmail').value = usuarioActivo.email;
    if(document.getElementById('currentPass')) document.getElementById('currentPass').value = usuarioActivo.password;

    // 3. Mostrar pestaña por defecto
    document.getElementById('cuenta').style.display = "block";
    
    // 4. Inicializar datos de direcciones
    if (typeof cargarDireccionesVisuales === "function") {
        cargarDireccionesVisuales();
    }

    // 5. Observer para el mapa (Solo se carga si el elemento existe y se muestra)
    const tabDirecciones = document.getElementById('direcciones');
    if (tabDirecciones) {
        const observer = new MutationObserver(() => {
            if (tabDirecciones.style.display !== 'none') {
                if (!map && typeof L !== 'undefined') { 
                    initLeafletMap(); 
                } else if (map) { 
                    map.invalidateSize(); 
                }
            }
        });
        observer.observe(tabDirecciones, { attributes: true, attributeFilter: ['style'] });
    }
});

/* --- NAVEGACIÓN ENTRE PESTAÑAS --- */
function openTab(evt, tabName) {
    let content = document.getElementsByClassName("tab-content");
    for (let i = 0; i < content.length; i++) {
        content[i].style.display = "none";
    }
    let links = document.getElementsByClassName("tab-btn");
    for (let i = 0; i < links.length; i++) {
        links[i].classList.remove("active");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.classList.add("active");
}

/* --- VISIBILIDAD DE CONTRASEÑAS --- */
function toggleVisibility(id, btn) {
    const input = document.getElementById(id);
    const icon = btn.querySelector('i');
    if (input.type === "password") {
        input.type = "text";
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = "password";
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

/* --- LÓGICA DE MAPAS (LEAFLET) --- */
function initLeafletMap() {
    const lat = 19.4326, lng = -99.1332;
    if (!document.getElementById('map')) return;

    map = L.map('map').setView([lat, lng], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
    marker = L.marker([lat, lng], { draggable: true }).addTo(map);

    marker.on('dragend', () => updateFieldsFromMap(marker.getLatLng().lat, marker.getLatLng().lng));
    map.on('click', (e) => { 
        marker.setLatLng(e.latlng); 
        updateFieldsFromMap(e.latlng.lat, e.latlng.lng); 
    });
}

async function updateFieldsFromMap(lat, lng) {
    try {
        const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`);
        const data = await res.json();
        if (data.address) {
            if(document.getElementById('dirCalle'))
                document.getElementById('dirCalle').value = (data.address.road || '') + ' ' + (data.address.house_number || '');
            if(document.getElementById('dirCiudad'))
                document.getElementById('dirCiudad').value = data.address.city || data.address.town || data.address.state || '';
            if(document.getElementById('dirCP'))
                document.getElementById('dirCP').value = data.address.postcode || '';
        }
    } catch (error) {
        console.error("Error en geocodificación inversa:", error);
    }
}

/* --- CIERRE DE SESIÓN --- */
function cerrarSesion() {
    Swal.fire({
        title: '¿Cerrar sesión?',
        text: "Tendrás que ingresar tus credenciales de nuevo.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#2c656d',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, salir',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            localStorage.removeItem('usuarioActivo');
            window.location.href = '/AccesoriosMaya/index.php';
        }
    });
}
</script>