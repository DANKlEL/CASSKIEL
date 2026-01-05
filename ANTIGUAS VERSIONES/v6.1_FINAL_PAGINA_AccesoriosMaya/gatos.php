<?php 
session_start();
include 'estructura/head.php'; 
?>

<link rel="stylesheet" href="/AccesoriosMaya/css/gatos.css">
<link rel="stylesheet" href="/AccesoriosMaya/css/producto/producto.css">
<link rel="stylesheet" href="/AccesoriosMaya/css/producto/productoGatos.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php include 'estructura/header.php'; ?>
<?php include 'cursor.php'; ?>

<br>
<section class="main-sections">
    <div class="section">
        <img src="/AccesoriosMaya/img/cats.png" alt="Gatos" style="width: 100%;">
    </div>
</section>

<section class="filter-container">
    <div class="filters">
        <div class="filter-group">
            <h4>Rango de precio</h4>
            <label><input type="checkbox" class="filter-precio" value="0-100" onchange="aplicarFiltros()"> $0 - $100</label>
            <label><input type="checkbox" class="filter-precio" value="100-500" onchange="aplicarFiltros()"> $100 - $500</label>
            <label><input type="checkbox" class="filter-precio" value="500-1000" onchange="aplicarFiltros()"> $500 - $1000</label>
        </div>

        <div class="filter-group">
            <h4>Categoría</h4>
            <label><input type="checkbox" class="filter-cat" value="Accesorios" onchange="aplicarFiltros()"> Accesorios</label>
            <label><input type="checkbox" class="filter-cat" value="Juguetes" onchange="aplicarFiltros()"> Juguetes</label>
        </div>
    </div>

    <div class="filter-images">
        <div class="product-grid" id="product-grid">
            
            <div class="product-card" data-precio="850" data-categoria="Juguetes">
                <div id="container-3d" style="width: 100%; height: 250px; position: relative;"></div> 
                <div class="product-info">
                    <h5>Torre Juguetero</h5>
                    <p><strong>$850.00</strong></p>
                    <button class="btn-view" onclick="verDetallesProducto1()">Ver Detalles</button>
                </div>
            </div>

            <div class="product-card" data-precio="650" data-categoria="Accesorios">
                <div id="container-3d-p2" style="width: 100%; height: 250px; position: relative;"></div> 
                <div class="product-info">
                    <h5>Collar Elegante</h5>
                    <p><strong>$650.00</strong></p>
                    <button class="btn-view" onclick="verDetallesProducto2()">Ver Detalles</button>
                </div>
            </div>

            <div class="product-card" data-precio="350" data-categoria="Accesorios">
                <div id="container-3d-p3" style="width: 100%; height: 250px; position: relative;"></div> 
                <div class="product-info">
                    <h5>Poste Rascador</h5>
                    <p><strong>$350.00</strong></p>
                    <button class="btn-view" onclick="verDetallesProducto3()">Ver Detalles</button>
                </div>
            </div>

            <div class="product-card" data-precio="420" data-categoria="Accesorios">
                <div id="container-3d-p4" style="width: 100%; height: 250px; position: relative;"></div> 
                <div class="product-info">
                    <h5>Comedero Ergonómico</h5>
                    <p><strong>$420.00</strong></p>
                    <button class="btn-view" onclick="verDetallesProducto4()">Ver Detalles</button>
                </div>
            </div>

            <div class="product-card" data-precio="550" data-categoria="Accesorios">
                <div id="container-3d-p5" style="width: 100%; height: 250px; position: relative;"></div> 
                <div class="product-info">
                    <h5>Cama Confort Pro</h5>
                    <p><strong>$550.00</strong></p>
                    <button class="btn-view" onclick="verDetallesProducto5()">Ver Detalles</button>
                </div>
            </div>

        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/FBXLoader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fflate@0.7.4/umd/index.min.js"></script>

<script src="/AccesoriosMaya/gatos/productosGatos.js"></script>
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
            if (precio >= min && (max ? precio <= max : true)) cumplePrecio = true;
        });

        let cumpleCat = catsSeleccionadas.length === 0 || catsSeleccionadas.includes(categoria);

        producto.style.display = (cumplePrecio && cumpleCat) ? "block" : "none";
    });
}
</script>

<?php 
    // Inclusión de modales PHP
    include 'gatos/productos/producto1/producto1.php'; 
    include 'gatos/productos/producto2/producto2.php'; 
    include 'gatos/productos/producto3/producto3.php'; 
    include 'gatos/productos/producto4/producto4.php'; 
    include 'gatos/productos/producto5/producto5.php'; 
?>

<script src="/AccesoriosMaya/gatos/productos/producto1/producto1.js"></script>
<script src="/AccesoriosMaya/gatos/productos/producto2/producto2.js"></script>
<script src="/AccesoriosMaya/gatos/productos/producto3/producto3.js"></script>
<script src="/AccesoriosMaya/gatos/productos/producto4/producto4.js"></script>
<script src="/AccesoriosMaya/gatos/productos/producto5/producto5.js"></script>

<?php include 'estructura/footer.php'; ?>