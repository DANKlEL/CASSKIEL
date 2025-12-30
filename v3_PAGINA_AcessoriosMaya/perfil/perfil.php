<?php include '../estructura/head.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="/AccesoriosMaya/css/perfil/perfil.css">

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
        <?php include 'infoCuenta.php'; ?>
        <?php include 'direcciones.php'; ?>
        <?php include 'pagos.php'; ?>
    </div>
</div>

<?php include '../estructura/footer.php'; ?>

<script>
let map, marker;

document.addEventListener('DOMContentLoaded', () => {
    // Verificar sesión
    const usuarioActivo = JSON.parse(localStorage.getItem('usuarioActivo'));
    if (!usuarioActivo) { 
        window.location.href = '/AccesoriosMaya/login.php'; 
        return; 
    }
    
    // Cargar datos en los inputs
    document.getElementById('saludoUsuario').innerText = `Hola, ${usuarioActivo.nombre.split(' ')[0]}`;
    document.getElementById('perfilNombre').value = usuarioActivo.nombre;
    document.getElementById('perfilEmail').value = usuarioActivo.email;
    document.getElementById('currentPass').value = usuarioActivo.password;

    // CORRECCIÓN: Mostrar pestaña de cuenta por defecto al entrar
    document.getElementById('cuenta').style.display = "block";
    
    cargarDireccionesVisuales();

    // Observer para inicializar el mapa solo cuando se vea la pestaña
    const observer = new MutationObserver(() => {
        if (document.getElementById('direcciones').style.display !== 'none') {
            if (!map) { 
                initLeafletMap(); 
            } else { 
                map.invalidateSize(); 
            }
        }
    });
    observer.observe(document.getElementById('direcciones'), { attributes: true, attributeFilter: ['style'] });
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

/* --- CORRECCIÓN: VISIBILIDAD DE CONTRASEÑAS (OJOS) --- */
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

/* --- LÓGICA DE MAPAS --- */
function initLeafletMap() {
    const lat = 19.4326, lng = -99.1332;
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
            document.getElementById('dirCalle').value = (data.address.road || '') + ' ' + (data.address.house_number || '');
            document.getElementById('dirCiudad').value = data.address.city || data.address.town || data.address.state || '';
            document.getElementById('dirCP').value = data.address.postcode || '';
        }
    } catch (error) {
        console.error("Error en geocodificación inversa:", error);
    }
}

/* --- GESTIÓN DE DIRECCIONES --- */
function cargarDireccionesVisuales() {
    const usuario = JSON.parse(localStorage.getItem('usuarioActivo'));
    const contenedor = document.getElementById('listaDirecciones');
    if(!contenedor) return;
    contenedor.innerHTML = '';

    (usuario.direcciones || []).forEach(dir => {
        contenedor.innerHTML += `
            <div class="card-direccion ${dir.seleccionada ? 'active' : ''}" onclick="seleccionarDireccion(${dir.id})">
                <div class="check-circle">
                    <i class="fa-solid ${dir.seleccionada ? 'fa-circle-check' : 'fa-regular fa-circle'}"></i>
                </div>
                <div class="info-dir">
                    <p><strong>${dir.calle}</strong></p>
                    <p>${dir.ciudad}, CP ${dir.cp}</p>
                </div>
                <button class="btn-delete-dir" onclick="eliminarDireccion(event, ${dir.id})">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </div>`;
    });
}

function seleccionarDireccion(id) {
    let usuario = JSON.parse(localStorage.getItem('usuarioActivo'));
    usuario.direcciones = usuario.direcciones.map(d => ({ ...d, seleccionada: d.id === id }));
    localStorage.setItem('usuarioActivo', JSON.stringify(usuario));
    cargarDireccionesVisuales();
}

function eliminarDireccion(e, id) {
    e.stopPropagation();
    let usuario = JSON.parse(localStorage.getItem('usuarioActivo'));
    usuario.direcciones = usuario.direcciones.filter(d => d.id !== id);
    localStorage.setItem('usuarioActivo', JSON.stringify(usuario));
    cargarDireccionesVisuales();
}

/* --- LÓGICA DE TARJETA DE PAGO --- */
function actualizarTarjeta() {
    const num = document.getElementById('cardNum');
    const name = document.getElementById('cardName');
    const exp = document.getElementById('cardExp');
    const cvv = document.getElementById('cardCVV');

    // Formateo automático
    num.value = num.value.replace(/\D/g, '').replace(/(\d{4})(?=\d)/g, '$1 ').trim();
    exp.value = exp.value.replace(/\D/g, '').replace(/(\d{2})(?=\d)/g, '$1/').trim();

    document.getElementById('displayNumero').innerText = num.value || "#### #### #### ####";
    document.getElementById('displayName').innerText = name.value.toUpperCase() || "NOMBRE DEL TITULAR";
    document.getElementById('displayExp').innerText = exp.value || "MM/AA";
    document.getElementById('displayCVV').innerText = cvv.value || "***";

    const logo = document.getElementById('cardLogo');
    if (num.value.startsWith('4')) logo.innerHTML = '<i class="fa-brands fa-cc-visa"></i>';
    else if (num.value.startsWith('5')) logo.innerHTML = '<i class="fa-brands fa-cc-mastercard"></i>';
    else logo.innerHTML = '<i class="fa-solid fa-credit-card"></i>';
}

function voltearTarjeta(isBack) {
    document.getElementById('creditCard').classList.toggle('flipped', isBack);
}

/* --- CIERRE DE SESIÓN --- */
function cerrarSesion() {
    Swal.fire({
        title: '¿Cerrar sesión?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#2c656d',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, salir'
    }).then((result) => {
        if (result.isConfirmed) {
            localStorage.removeItem('usuarioActivo');
            // Redirección absoluta corregida
            window.location.href = '/AccesoriosMaya/auth/login.php';
        }
    });
}
</script>