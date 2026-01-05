<?php include 'estructura/head.php'; ?>
<?php include 'estructura/header.php'; ?>
<?php include 'cursor.php'; ?>
<link rel="stylesheet" href="css/estilos_carrusel.css">

<section class="banner-carousel">
  <div id="scene">
    <div id="left-zone">
      <ul class="list">
        
        <li class="item">
          <input type="radio" id="radio_perros" name="basic_carousel" checked>
          <label class="label_perros" for="radio_perros">
            <span>P</span><span>e</span><span>r</span><span>r</span><span>o</span><span>s</span>
          </label>
          <div class="content content_perros">
            <span class="picto">
              <img src="img/perros.png" alt="Perros" style="width: 100%; height: 100%; object-fit: contain;">
            </span>
            <h1><span>P</span><span>e</span><span>r</span><span>r</span><span>o</span><span>s</span></h1>
            <p>Accesorios cómodos, resistentes y con estilo para tu fiel y mejor amigo.</p>
          </div>
        </li>

        <li class="item">
          <input type="radio" id="radio_gatos" name="basic_carousel">
          <label class="label_gatos" for="radio_gatos">
            <span>G</span><span>a</span><span>t</span><span>o</span><span>s</span>
          </label>
          <div class="content content_gatos">
            <span class="picto">
              <img src="img/gatos.png" alt="Gatos" style="width: 100%; height: 100%; object-fit: contain;">
            </span>
            <h1><span>G</span><span>a</span><span>t</span><span>o</span><span>s</span></h1>
            <p>Productos diseñados para el confort, juego y bienestar felino.</p>
          </div>
        </li>

        <li class="item">
          <input type="radio" id="radio_ofertas" name="basic_carousel">
          <label class="label_ofertas" for="radio_ofertas">
            <span>O</span><span>f</span><span>e</span><span>r</span><span>t</span><span>a</span><span>s</span>
          </label>
          <div class="content content_ofertas">
            <span class="picto">
              <img src="img/ofertas.png" alt="Ofertas" style="width: 100%; height: 100%; object-fit: contain;">
            </span>
            <h1><span>O</span><span>f</span><span>e</span><span>r</span><span>t</span><span>a</span><span>s</span></h1>
            <p>Descuentos especiales cada mes hasta el 50% de descuento.</p>
          </div>
        </li>

        <li class="item">
          <input type="radio" id="radio_nuevos" name="basic_carousel">
          <label class="label_nuevos" for="radio_nuevos">
            <span>A</span><span>d</span><span>o</span><span>p</span><span>c</span><span>i</span><span>ó</span><span>n</span>
          </label>
          <div class="content content_nuevos">
            <span class="picto">
              <img src="img/adopcion.png" alt="Adopción" style="width: 100%; height: 100%; object-fit: contain;">
            </span>
            <h1><span>A</span><span>d</span><span>o</span><span>p</span><span>c</span><span>i</span><span>ó</span><span>n</span></h1>
            <p>En Accesorios Maya apoyamos la adopción responsable.</p>
          </div>
        </li>

      </ul>
    </div>
    <div id="middle-border"></div>
    <div id="right-zone"></div>
  </div>
</section>
<br>
<section class="triple-box">
    <div class="triple-item">
        <img src="img/img1.png" alt="Imagen 1">
    </div>
    <div class="triple-text">
        <h2>“Todo para tus mascotas, al alcance de tus manos”</h2>
        <p>En Accesorios Maya cuidamos cada detalle para que tus perros y gatos tengan lo mejor.</p>
    </div>
    <div class="triple-item">
        <img src="img/img2.png" alt="Imagen 2">
    </div>
</section>

<section class="video-section">
  <div class="video-text">
    <h2>Nuestra comunidad Maya 🐾</h2>
    <p>
    Más que una tienda, somos una comunidad que ama y cuida a sus mascotas.
    Gracias por ser parte de Accesorios Maya.
    </p>
    <div class="video-text">

  <!-- IMAGEN DEBAJO DEL TEXTO -->
  <img src="img/lineadepatas.png" alt="Comunidad Maya" class="community-image">
</div>

  </div>

  <div class="video-wrapper">
    <video class="promo-video" controls muted loop>
      <source src="videos/video de bienvenida MAYA.mp4" type="video/mp4">
      Tu navegador no soporta videos.
    </video>
  </div>
</section>


<section class="featured-section">
  <h2>Lo más destacado de Accesorios Maya 🐾</h2>
  <p>Productos favoritos, promociones especiales y lo mejor para tu mascota.</p>
</section>

<section class="circle-section-wrapper">
    <div class="circle-section with-side-images">

        <!-- Imagen izquierda -->
        <div class="side-image left">
            <img src="img/cat.png" alt="Decoración izquierda">
        </div>

        <!-- Carrusel -->
        <div class="carousel">
            <div class="carousel-track">
                <?php
                $labels = [
                    "Promoción del mes 🔥",
                    "Nuevos productos 🆕",
                    "Favoritos Maya 🐾",
                    "Descuentos especiales 💸",
                    "Lo más vendido ⭐",
                    "Accesorios para perros 🐶",
                    "Accesorios para gatos 🐱",
                    "Edición limitada ✨",
                    "Recomendado para ti ❤️"
                ];

                for($i = 1; $i <= 9; $i++):
                ?>
                <div class="carousel-item">
                    <div class="circle" data-label="<?php echo $labels[$i-1]; ?>">
                        <img src="img/<?php echo $i; ?>.png" alt="<?php echo $labels[$i-1]; ?>">
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </div>

        <!-- Imagen derecha -->
        <div class="side-image right">
            <img src="img/dog.png" alt="Decoración derecha">
        </div>

    </div>
</section>

<section class="why-maya">
  <h2>¿Por qué elegir Accesorios Maya? 🐾</h2>
  <br>
  <div class="why-cards">
    <div class="why-card">
      <img src="img/icon-quality.png" alt="Calidad">
      <h3>Calidad Garantizada</h3>
      <p>Seleccionamos materiales seguros, resistentes y cómodos.</p>
    </div>
    <div class="why-card">
      <img src="img/icon-love.png" alt="Amor">
      <h3>Diseñado con Amor</h3>
      <p>Cada accesorio está pensado para el bienestar de tu mascota.</p>
    </div>
    <div class="why-card">
      <img src="img/icon-shipping.png" alt="Envío">
      <h3>Envíos Confiables</h3>
      <p>Recibe tus productos de forma segura y rápida.</p>
    </div>
    <div class="why-card">
      <img src="img/icon-support.png" alt="Soporte">
      <h3>Atención Personalizada</h3>
      <p>Estamos para ayudarte en todo momento.</p>
    </div>
  </div>
</section>

<section class="comments">
    <h2>Comentarios de los Clientes 🐾</h2>

    <div class="comments-container">

        <!-- Comentario 1 -->
        <div class="comment-box">
            <div class="comment-header">
                <div class="comment-avatar">
                    <img src="img/juan.png" alt="Juan Pérez">
                </div>
                <div class="comment-info">
                    <strong>Juan Pérez</strong>
                    <div class="stars">★★★★★</div>
                </div>
            </div>
            <p>"Excelente servicio y calidad. Mi perro ama sus nuevos accesorios."</p>
        </div>

        <!-- Comentario 2 -->
        <div class="comment-box">
            <div class="comment-header">
                <div class="comment-avatar">
                    <img src="img/ana.png" alt="Ana Gómez">
                </div>
                <div class="comment-info">
                    <strong>Ana Gómez</strong>
                    <div class="stars">★★★★☆</div>
                </div>
            </div>
            <p>"Muy buenos productos y entrega rápida. Definitivamente volveré a comprar."</p>
        </div>

        <!-- Comentario 3 -->
        <div class="comment-box">
            <div class="comment-header">
                <div class="comment-avatar">
                    <img src="img/carlos.png" alt="Carlos López">
                </div>
                <div class="comment-info">
                    <strong>Carlos López</strong>
                    <div class="stars">★★★★★</div>
                </div>
            </div>
            <p>"Calidad excelente y atención muy amable. Súper recomendado."</p>
        </div>

        <!-- Comentario 4 -->
        <div class="comment-box">
            <div class="comment-header">
                <div class="comment-avatar">
                    <img src="img/alejandro.png" alt="Alejandro Mejía">
                </div>
                <div class="comment-info">
                    <strong>Alejandro Mejía</strong>
                    <div class="stars">★★★★☆</div>
                </div>
            </div>
            <p>"Precios accesibles y productos muy bonitos. Mis gatos están felices."</p>
        </div>

    </div>
</section>

<?php include 'estructura/footer.php'; ?>

<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="js/script.js"></script>
<script src="Javascript/menu.js"></script>
<script src="js/carrusel.js"></script>
<?php include 'asistente.php'; ?>

<script>
    // Reiniciar animación Schitt's Creek al hacer clic
    document.querySelectorAll('#left-zone label').forEach(label => {
        label.addEventListener('click', () => {
            const spans = label.querySelectorAll('span');
            spans.forEach(span => {
                span.style.animation = 'none';
                void span.offsetWidth; // Forzar reflow
                span.style.animation = null;
            });
        });
    });

    // Swiper Config (Asegurarse que no choque con lo demás)
    document.addEventListener('DOMContentLoaded', function () {
        const swiperContainers = document.querySelectorAll('.carousel');
        swiperContainers.forEach(container => {
           // Si usas swiper.js aquí, configura tus parámetros
        });
    });
</script>

</body>
</html>