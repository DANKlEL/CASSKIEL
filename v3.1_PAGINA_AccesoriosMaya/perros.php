<?php 
// Incluimos el head (metadatos y estilos globales)
include 'estructura/head.php'; 
?>

<link rel="stylesheet" href="/AccesoriosMaya/css/perros.css">
<link rel="stylesheet" href="/AccesoriosMaya/css/producto/producto.css">

<?php 
// Incluimos el header unificado
include 'estructura/header.php'; 
?>

<br>
<section class="main-sections">
    <div class="section">
        <img src="/AccesoriosMaya/img/dogs.png" alt="Perros" style="width: 100%;">
    </div>
</section>

<br>

<section class="sort-search-container">
    <div class="sort-buttons">
        <button>Más Vendidos</button>
        <button>Precio, menor a mayor</button>
        <button>Precio, mayor a menor</button>
        <button>Alfabéticamente, A-Z</button>
    </div>
    <div class="search-box-container">
        <input type="text" placeholder="Buscar productos...">
    </div>
</section>

<section class="filter-container">
    <aside class="filters">
        <div class="filter-group">
            <h4>Rango de precio</h4>
            <label><input type="checkbox" name="price"> $0 - $100</label>
            <label><input type="checkbox" name="price"> $100 - $500</label>
            <label><input type="checkbox" name="price"> $500 - $1000</label>
        </div>
        <div class="filter-group">
            <h4>Marca</h4>
            <label><input type="checkbox" name="brand"> Marca 1</label>
            <label><input type="checkbox" name="brand"> Marca 2</label>
            <label><input type="checkbox" name="brand"> Marca 3</label>
        </div>
        <div class="filter-group">
            <h4>Categoría</h4>
            <label><input type="checkbox" name="category"> Accesorios</label>
            <label><input type="checkbox" name="category"> Juguetes</label>
            <label><input type="checkbox" name="category"> Alimento</label>
        </div>
        <div class="filter-group">
            <h4>Tamaño de la raza</h4>
            <label><input type="checkbox" name="size"> Pequeño</label>
            <label><input type="checkbox" name="size"> Mediano</label>
            <label><input type="checkbox" name="size"> Grande</label>
        </div>
    </aside>

    <div class="filter-images">
        <div class="product-grid">
            
            <div class="product-card">
                <div id="container-3d-perros" style="width:100%; height:280px; background:#f9f9f9; border-radius:10px; display:flex; align-items:center; justify-content:center;">
                    <img src="/AccesoriosMaya/img/art1.png" alt="Producto 1" style="width:160px">
                </div>
                <div class="product-info">
                    <h5>Cama Ortopédica</h5>
                    <p><strong>$950.00</strong></p>
                    <button class="btn-view" onclick="verDetalles('Cama Ortopédica Premium')">Ver Detalles</button>
                </div>
            </div>

            <div class="product-card">
                <img src="/AccesoriosMaya/img/art2.png" alt="Producto 2" style="width:160px">
                <div class="product-info">
                    <h5>Correa Resistente</h5>
                    <p><strong>$250.00</strong></p>
                    <button class="btn-view" onclick="verDetalles('Correa de Entrenamiento')">Ver Detalles</button>
                </div>
            </div>

            <div class="product-card">
                <img src="/AccesoriosMaya/img/art3.png" alt="Producto 3" style="width:160px">
                <div class="product-info">
                    <h5>Plato Acero Inox</h5>
                    <p><strong>$180.00</strong></p>
                    <button class="btn-view" onclick="verDetalles('Plato Antideslizante')">Ver Detalles</button>
                </div>
            </div>

            <div class="product-card">
                <img src="/AccesoriosMaya/img/art4.png" alt="Producto 4" style="width:160px">
                <div class="product-info">
                    <h5>Juguete Mordedera</h5>
                    <p><strong>$120.00</strong></p>
                    <button class="btn-view" onclick="verDetalles('Mordedera de Caucho')">Ver Detalles</button>
                </div>
            </div>

        </div>
    </div>
</section>

<div class="chat-icon" id="chatIcon" onclick="toggleChat()">💬</div>
<div class="chat-container" id="chatContainer">
  <div class="chat-header">
    <span class="thin-text">¿En qué puedo ayudarte?</span>
    <button class="close-button" onclick="toggleChat()">×</button>
  </div>    
  <div class="avatar-container">
    <video id="avatar" loop muted>
      <source src="/AccesoriosMaya/videos/2.mp4" type="video/mp4">
    </video>
  </div>
  <div id="chatbox" class="chatbox"></div>
  <div class="input-container">
    <input type="text" id="userInput" placeholder="Escribe tu mensaje aquí...">
    <button id="sendButton">Enviar</button>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function verDetalles(producto) {
        Swal.fire({
            title: producto,
            text: '¡Este accesorio es ideal para la comodidad de tu perro!',
            icon: 'info',
            confirmButtonColor: '#ff914d'
        });
    }
</script>

<script src="/AccesoriosMaya/js/script.js"></script>

<?php 
// Incluimos el footer unificado
include 'estructura/footer.php'; 
?>