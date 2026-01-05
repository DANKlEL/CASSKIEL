<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<header>
    <div class="header-container">
        <img src="/AccesoriosMaya/img/logo.png" alt="Logo" class="logo">
        <nav>
            <ul>
                <li><a href="/AccesoriosMaya/index.php">Inicio</a></li>
                <li class="dropdown">
                    <a href="#">Mascotas</a>
                    <ul class="dropdown-menu">
                        <li><a href="/AccesoriosMaya/gatos.php">Gatos</a></li>
                        <li><a href="/AccesoriosMaya/perros.php">Perros</a></li>
                    </ul>
                </li>
                <li><a href="/AccesoriosMaya/quienes-somos.html">¿Quienes Somos?</a></li>
            </ul>
        </nav>
        <div class="search-container">
            <div class="search-box">
                <input type="text" placeholder="Buscar...">
                <div class="cart-container-dropdown">
                    <a href="/AccesoriosMaya/carrito.php" class="cart-link">
                        <img src="/AccesoriosMaya/img/carrito.png" alt="Carrito" class="icon-header">
                        <span id="cart-count" class="cart-badge">0</span>
                    </a>
                    <div class="cart-dropdown-panel">
                        <h4 style="text-align: center; margin-bottom: 15px; font-family: 'Quicksand';">Mi Carrito</h4>
                        <div id="cart-items-container"></div>
                        <hr style="border:0; border-top:1px solid #eee; margin:15px 0;">
                        <div style="display:flex; justify-content:space-between; font-weight:bold; margin-bottom:15px;">
                            <span>Total:</span>
                            <span style="color:#2c656d;">$<span id="cart-total-price">0.00</span></span>
                        </div>
                        <a href="/AccesoriosMaya/carrito.php" class="btn-buy-mini">Ir a pagar / Ver Carrito</a>
                    </div>
                </div>
                <a href="/AccesoriosMaya/perfil/perfil.php"><img src="/AccesoriosMaya/img/perfil.png" class="icon-header"></a>
            </div>
        </div>
    </div>
</header>

<style>
/* Estilos base que ya tenías */
.cart-container-dropdown { position: relative; display: inline-block; }
.cart-dropdown-panel { 
    display: none; position: absolute; top: 40px; right: 0; width: 300px; 
    background: white; border-radius: 20px; padding: 20px; z-index: 1000;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 1px solid #eee;
}
.cart-container-dropdown:hover .cart-dropdown-panel { display: block; }
.cart-badge { 
    position: absolute; top: -8px; right: -8px; background: #ff4d4d; color: white;
    border-radius: 50%; padding: 2px 6px; font-size: 11px; font-weight: bold; border: 2px solid white;
}
.mini-cart-item { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; border-bottom: 1px solid #f9f9f9; padding-bottom: 10px; }
.mini-cart-item img { width: 45px; height: 45px; border-radius: 8px; object-fit: cover; }
.btn-delete-mini { background: #fdf0f0; border: none; color: #ff4d4d; cursor: pointer; border-radius: 50%; width: 22px; height: 22px; margin-left: 5px; }
.btn-buy-mini { display: block; background: #2c656d; color: white !important; text-align: center; padding: 10px; border-radius: 10px; text-decoration: none; font-weight: bold; }

/* Nuevos estilos para los controles de cantidad */
.mini-qty-selector {
    display: flex;
    align-items: center;
    gap: 5px;
    margin-top: 5px;
}
.btn-qty-mini {
    background: #eee;
    border: none;
    width: 20px;
    height: 20px;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 0.2s;
}
.btn-qty-mini:hover { background: #2c656d; color: white; }
.qty-value { font-weight: bold; color: #333; min-width: 15px; text-align: center; }
</style>

<script>
function actualizarMiniCarrito() {
    fetch('/AccesoriosMaya/logica/obtener_carrito_json.php?t=' + Date.now())
    .then(res => res.json())
    .then(data => {
        const container = document.getElementById('cart-items-container');
        const badge = document.getElementById('cart-count');
        const totalDisp = document.getElementById('cart-total-price');
        
        let html = ''; let total = 0; let cantTotal = 0;

        if (!data.items || data.items.length === 0) {
            html = '<p style="text-align:center; color:#888; font-size:0.8rem;">Tu carrito está vacío 🐾</p>';
        } else {
            data.items.forEach(item => {
                let subtotal = item.precio * item.cant;
                total += subtotal;
                cantTotal += parseInt(item.cant);
                html += `
                <div class="mini-cart-item">
                    <img src="/AccesoriosMaya/img/${item.img}">
                    <div style="flex-grow:1; font-size:0.85rem;">
                        <div style="font-weight:bold;">${item.nombre}</div>
                        <div style="color:#2c656d; font-weight: bold;">$${item.precio}</div>
                        <div class="mini-qty-selector">
                            <button class="btn-qty-mini" onclick="cambiarCantMini('${item.nombre}', 'restar')">-</button>
                            <span class="qty-value">${item.cant}</span>
                            <button class="btn-qty-mini" onclick="cambiarCantMini('${item.nombre}', 'sumar')">+</button>
                        </div>
                    </div>
                    <button class="btn-delete-mini" onclick="eliminarDelMiniCarrito('${item.nombre}')">&times;</button>
                </div>`;
            });
        }
        container.innerHTML = html;
        totalDisp.innerText = total.toFixed(2);
        badge.innerText = cantTotal;
        badge.style.display = cantTotal > 0 ? 'block' : 'none';
    });
}

function cambiarCantMini(nombre, accion) {
    const fd = new FormData();
    fd.append('nombre', nombre);
    fd.append('accion', accion);

    fetch('/AccesoriosMaya/logica/gestionar_carrito.php', { method: 'POST', body: fd })
    .then(res => res.json())
    .then(() => {
        actualizarMiniCarrito();
        // Si tienes abierto el SweetAlert de ese producto, esta línea lo mantendría sincronizado
        if (typeof verDetalles === 'function') {
            // Nota: Aquí podrías disparar un evento si necesitas actualizar el modal abierto
        }
    });
}

function eliminarDelMiniCarrito(nombre) {
    const fd = new FormData();
    fd.append('nombre', nombre);
    fd.append('accion', 'eliminar');

    fetch('/AccesoriosMaya/logica/gestionar_carrito.php', { method: 'POST', body: fd })
    .then(() => actualizarMiniCarrito());
}

document.addEventListener('DOMContentLoaded', actualizarMiniCarrito);
</script>