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
        <img src="/AccesoriosMaya/img/cats.png" alt="Gatos" style="width: 100%;">
    </div>
</section>

<section class="filter-container">
    <div class="filters">
        <div class="filter-group">
            <h4>Rango de precio</h4>
            <label><input type="checkbox"> $0 - $100</label>
            <label><input type="checkbox"> $100 - $500</label>
            <label><input type="checkbox"> $500 - $1000</label>
        </div>

        <div class="filter-group">
            <h4>Categoría</h4>
            <label><input type="checkbox"> Accesorios</label>
            <label><input type="checkbox"> Juguetes</label>
        </div>
    </div>

    <div class="filter-images">
        <div class="product-grid">
            <div class="product-card">
                <div id="container-3d" style="width: 100%; height: 250px;"></div> 
                <div class="product-info">
                    <h5>Torre Juguetero</h5>
                    <p><strong>$850.00</strong></p>
                    <button class="btn-view" onclick="verDetallesProducto1()">Ver Detalles</button>
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

<?php include 'gatos/productos/producto1/producto1.php'; ?>

<script src="/AccesoriosMaya/js/script.js"></script>
<script src="/AccesoriosMaya/gatos/productos/producto1/producto1.js"></script>

<?php include 'estructura/footer.php'; ?>