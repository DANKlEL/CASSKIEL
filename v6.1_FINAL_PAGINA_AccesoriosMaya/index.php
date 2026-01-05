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

<div class="video-wrapper">
    <img src="img/fondo-video.png" class="video-bg" alt="">
    <video class="promo-video" controls muted loop>
        <source src="videos/video de bienvenida MAYA.mp4" type="video/mp4">
        Tu navegador no soporta videos.
    </video>
</div>

<section class="why-maya">
  <h2>¿Por qué elegir Accesorios Maya?</h2>
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

<section class="circle-section-wrapper">
    <div class="circle-section">
        <div class="carousel">
            <div class="carousel-track">
                <?php for($i=1; $i<=9; $i++): ?>
                <div class="carousel-item">
                    <div class="circle" data-label="Producto Maya">
                        <img src="img/<?php echo $i; ?>.png" alt="Producto <?php echo $i; ?>">
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</section>

<section class="comments">
    <h2>Comentarios de los Clientes</h2>
    <div class="comments-container">
        <div class="comment-box"><p>"Excelente servicio y calidad."</p><span>- Juan Pérez</span></div>
        <div class="comment-box"><p>"Mis mascotas están felices."</p><span>- Ana Gómez</span></div>
        <div class="comment-box"><p>"Muy recomendable."</p><span>- Carlos López</span></div>
        <div class="comment-box"><p>"Artículos muy accesibles."</p><span>- Alejandro Mejía</span></div>
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