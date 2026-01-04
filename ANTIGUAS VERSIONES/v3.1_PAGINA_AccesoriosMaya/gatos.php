<?php 
session_start();
include 'estructura/head.php'; 
?>

<link rel="stylesheet" href="/AccesoriosMaya/css/gatos.css">
<link rel="stylesheet" href="/AccesoriosMaya/css/producto/producto.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php include 'estructura/header.php'; ?>

<br>
<section class="main-sections">
    <div class="section">
        <img src="/AccesoriosMaya/img/cats.png" alt="Gatos" style="width: 100%;">
    </div>
</section>

<section class="sort-search-container">
    <div class="sort-buttons">
        <button>Más Vendidos</button>
        <button>Precio, menor a mayor</button>
        <button>Precio, mayor a menor</button>
    </div>
    <div class="search-box-container">
        <input type="text" placeholder="Buscar productos...">
    </div>
</section>

<section class="filter-container">
    <div class="filters">
        <div class="filter-group" style="background-color: #9ab4b9; border-radius: 25px; padding: 20px; margin-bottom: 15px; color: #333;">
            <h4 style="margin-bottom: 15px; font-weight: bold;">Rango de precio</h4>
            <label style="display: block; margin-bottom: 10px;"><input type="checkbox"> $0 - $100</label>
            <label style="display: block; margin-bottom: 10px;"><input type="checkbox"> $100 - $500</label>
            <label style="display: block;"><input type="checkbox"> $500 - $1000</label>
        </div>

        <div class="filter-group" style="background-color: #9ab4b9; border-radius: 25px; padding: 20px; color: #333;">
            <h4 style="margin-bottom: 15px; font-weight: bold;">Categoría</h4>
            <label style="display: block; margin-bottom: 10px;"><input type="checkbox"> Accesorios</label>
            <label style="display: block;"><input type="checkbox"> Juguetes</label>
        </div>
    </div>

    <div class="filter-images">
        <div class="product-grid">
            <div class="product-card">
                <div id="container-3d"></div> 
                <div class="product-info">
                    <h5>Torre Juguetero 3D</h5>
                    <p><strong>$850.00</strong></p>
                    <button class="btn-view" onclick="verDetalles('Torre Juguetero 3D', 850, 'productosGatos/producto1Amarillo.png')">Ver Detalles</button>
                </div>
            </div>

            <div class="product-card">
                <img src="/AccesoriosMaya/img/art5.png" alt="Producto" style="width:160px">
                <div class="product-info">
                    <h5>Cama Acolchada</h5>
                    <p><strong>$450.00</strong></p>
                    <button class="btn-view" onclick="verDetalles('Cama Acolchada', 450, 'art5.png')">Ver Detalles</button>
                </div>
            </div>

            <div class="product-card">
                <img src="/AccesoriosMaya/img/art6.png" alt="Producto" style="width:160px">
                <div class="product-info">
                    <h5>Rascador Premium</h5>
                    <p><strong>$320.00</strong></p>
                    <button class="btn-view" onclick="verDetalles('Rascador Premium', 320, 'art6.png')">Ver Detalles</button>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/FBXLoader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fflate@0.7.4/umd/index.min.js"></script>

<script>
    /**
     * Abre el modal de SweetAlert sincronizado con el carrito real
     */
    async function verDetalles(nombre, precio, imagenNombre) {
        let cantidadActual = 0;
        try {
            // Consultamos al servidor la cantidad real antes de mostrar el modal
            const response = await fetch(`/AccesoriosMaya/logica/gestionar_carrito.php?consultar=${encodeURIComponent(nombre)}&t=${Date.now()}`);
            const data = await response.json();
            cantidadActual = parseInt(data.cantidadActual) || 0;
        } catch (e) { 
            console.error("Error al sincronizar con el carrito:", e); 
        }

        let valorInicial = (cantidadActual > 0) ? cantidadActual : 1;

        Swal.fire({
            title: `<span style="font-family: 'Quicksand', sans-serif; font-weight: 700;">${nombre}</span>`,
            html: `
                <div style="text-align: left; font-family: 'Quicksand', sans-serif;">
                    <img src="/AccesoriosMaya/img/${imagenNombre}" style="width:100%; max-width:220px; display:block; margin: 0 auto 15px; border-radius:15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                    <p style="font-size: 0.95rem; color: #555; line-height: 1.4;">Accesorio Maya de alta calidad diseñado para el confort de tu mascota.</p>
                    <p style="color: #ff914d; font-size: 1.6rem; font-weight: 700; text-align: center; margin: 15px 0;">
                        Total: $<span id="total-price">${(precio * valorInicial).toFixed(2)}</span>
                    </p>
                    <div style="background: #f9f9f9; padding: 15px; border-radius: 12px; display: flex; align-items: center; justify-content: center; gap: 10px;">
                        <label style="font-weight: 600;">Cantidad:</label>
                        <input type="number" id="swal-qty" class="swal2-input" value="${valorInicial}" min="1" max="5" 
                               onkeydown="return false" 
                               style="width: 70px; margin: 0; height: 35px; border-radius: 8px; cursor: default;">
                        <span style="font-size: 0.8rem; color: #888;">(Máx. 5)</span>
                    </div>
                    <p id="max-limit-msg" style="text-align:center; font-size:0.8rem; color:#ff4d4d; margin-top:10px; display: ${valorInicial >= 5 ? 'block' : 'none'};">
                        ¡Ya tienes el máximo permitido!
                    </p>
                </div>
            `,
            didOpen: () => {
                const inputQty = document.getElementById('swal-qty');
                const displayTotal = document.getElementById('total-price');
                const limitMsg = document.getElementById('max-limit-msg');
                const confirmBtn = Swal.getConfirmButton();

                inputQty.addEventListener('input', () => {
                    const cant = parseInt(inputQty.value);
                    displayTotal.innerText = (precio * cant).toFixed(2);

                    if (cant >= 5) {
                        limitMsg.style.display = 'block';
                        confirmBtn.innerText = 'Mantener en Carrito';
                        confirmBtn.style.backgroundColor = '#2c656d';
                    } else {
                        limitMsg.style.display = 'none';
                        confirmBtn.innerText = 'Añadir/Actualizar';
                        confirmBtn.style.backgroundColor = '#ff914d';
                    }
                });
            },
            showCancelButton: true,
            confirmButtonText: valorInicial >= 5 ? 'Mantener en Carrito' : 'Añadir/Actualizar',
            confirmButtonColor: valorInicial >= 5 ? '#2c656d' : '#ff914d',
            cancelButtonText: 'Regresar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                const nuevaCant = document.getElementById('swal-qty').value;
                agregarAlCarrito(nombre, precio, imagenNombre, nuevaCant, true);
            }
        });
    }

    /**
     * Envía los datos al servidor y refresca el mini carrito del header
     */
    function agregarAlCarrito(nombre, precio, img, cantidad, esSustitucion) {
        const formData = new FormData();
        formData.append('nombre', nombre);
        formData.append('precio', precio);
        formData.append('img', img);
        formData.append('cantidad', cantidad);
        formData.append('sustituir', esSustitucion);

        fetch('/AccesoriosMaya/logica/gestionar_carrito.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // 1. Refrescamos el mini-carrito del header para que aparezcan las imágenes
            if (typeof actualizarMiniCarrito === 'function') {
                actualizarMiniCarrito();
            }

            // 2. Feedback visual
            Swal.fire({ 
                toast: true, 
                position: 'top-end', 
                icon: 'success', 
                title: 'Carrito actualizado', 
                showConfirmButton: false, 
                timer: 1500 
            });
        });
    }
</script>

<script src="/AccesoriosMaya/gatos/productos/producto1/producto1.js"></script>
<script src="/AccesoriosMaya/js/script.js"></script>

<?php include 'estructura/footer.php'; ?>