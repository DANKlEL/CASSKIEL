<?php 
session_start();
include 'estructura/head.php'; 
?>

<link rel="stylesheet" href="/AccesoriosMaya/css/gatos.css"> 
<link rel="stylesheet" href="/AccesoriosMaya/css/producto/producto.css">
<link rel="stylesheet" href="/AccesoriosMaya/css/producto/productoGatos.css"> 

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php include 'estructura/header.php'; ?>

<br>
<section class="main-sections">
    <div class="section">
        <img src="/AccesoriosMaya/img/dogs.png" alt="Perros" style="width: 100%;">
    </div>
</section>

<section class="filter-container">
    <div class="filters">
        <div class="filter-group">
            <h4>Rango de precio</h4>
            <label><input type="checkbox" class="filter-precio" value="0-100" onchange="aplicarFiltros()"> $0 - $100</label>
            <label><input type="checkbox" class="filter-precio" value="100-500" onchange="aplicarFiltros()"> $100 - $500</label>
            <label><input type="checkbox" class="filter-precio" value="500-1000" onchange="aplicarFiltros()"> $500 - $1000</label>
            <label><input type="checkbox" class="filter-precio" value="1000-9999" onchange="aplicarFiltros()"> + $1000</label>
        </div>

        <div class="filter-group">
            <h4>Categoría</h4>
            <label><input type="checkbox" class="filter-cat" value="Accesorios" onchange="aplicarFiltros()"> Accesorios</label>
            <label><input type="checkbox" class="filter-cat" value="Juguetes" onchange="aplicarFiltros()"> Juguetes</label>
            <label><input type="checkbox" class="filter-cat" value="Hogar" onchange="aplicarFiltros()"> Hogar</label>
        </div>
    </div>

    <div class="filter-images">
        <div class="product-grid" id="product-grid">
            
            <div class="product-card" data-precio="120" data-categoria="Juguetes">
                <div id="container-3d-dog1" style="width: 100%; height: 250px; position: relative;"></div> 
                <div class="product-info">
                    <h5>Hueso Dental Pro</h5>
                    <p><strong>$120.00</strong></p>
                    <button class="btn-view" onclick="verDetallesProducto1()">Ver Detalles</button>
                </div>
            </div>

            <div class="product-card" data-precio="250" data-categoria="Accesorios">
                <div id="container-3d-dog2" style="width: 100%; height: 250px; position: relative;"></div> 
                <div class="product-info">
                    <h5>Collar Personalizable</h5>
                    <p><strong>$250.00</strong></p>
                    <button class="btn-view" onclick="verDetallesProducto2()">Ver Detalles</button>
                </div>
            </div>

            <div class="product-card" data-precio="2500" data-categoria="Hogar">
                <div id="container-3d-dog3" style="width: 100%; height: 250px; position: relative;"></div> 
                <div class="product-info">
                    <h5>Casa Térmica Gigante</h5>
                    <p><strong>$2,500.00</strong></p>
                    <button class="btn-view" onclick="verDetallesProducto3()">Ver Detalles</button>
                </div>
            </div>

            <div class="product-card" data-precio="150" data-categoria="Juguetes">
                <div id="container-3d-dog4" style="width: 100%; height: 250px; position: relative;"></div> 
                <div class="product-info">
                    <h5>Pelota Deportiva Mordible</h5>
                    <p><strong>$150.00</strong></p>
                    <button class="btn-view" onclick="verDetallesProducto4()">Ver Detalles</button>
                </div>
            </div>

        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/FBXLoader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/GLTFLoader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fflate@0.7.4/umd/index.min.js"></script>

<script src="/AccesoriosMaya/perros/productosPerros.js"></script>
<script src="/AccesoriosMaya/js/script.js"></script>

<script>
function aplicarFiltros() {
    const checkboxesPrecio = document.querySelectorAll('.filter-precio');
    const checkboxesCat = document.querySelectorAll('.filter-cat');
    const productos = document.querySelectorAll('.product-card');

    const rangosSeleccionados = Array.from(checkboxesPrecio).filter(i => i.checked).map(i => i.value);
    const catsSeleccionadas = Array.from(checkboxesCat).filter(i => i.checked).map(i => i.value);

    productos.forEach(producto => {
        const precio = parseFloat(producto.getAttribute('data-precio'));
        const categoria = producto.getAttribute('data-categoria');

        let cumplePrecio = rangosSeleccionados.length === 0;
        rangosSeleccionados.forEach(rango => {
            const [min, max] = rango.split('-').map(Number);
            // Lógica para "+1000" (9999 como tope infinito)
            if (precio >= min && (max ? precio <= max : true)) cumplePrecio = true;
        });

        let cumpleCat = catsSeleccionadas.length === 0 || catsSeleccionadas.includes(categoria);
        producto.style.display = (cumplePrecio && cumpleCat) ? "block" : "none";
    });
}
</script>

<?php 
    include 'perros/productos/producto1/producto1.php'; 
    include 'perros/productos/producto2/producto2.php'; 
    include 'perros/productos/producto3/producto3.php'; 
    include 'perros/productos/producto4/producto4.php'; 
?>

<script src="/AccesoriosMaya/perros/productos/producto1/producto1.js"></script>
<script src="/AccesoriosMaya/perros/productos/producto2/producto2.js"></script>
<script src="/AccesoriosMaya/perros/productos/producto3/producto3.js"></script>
<script src="/AccesoriosMaya/perros/productos/producto4/producto4.js"></script>

<?php include 'estructura/footer.php'; ?>