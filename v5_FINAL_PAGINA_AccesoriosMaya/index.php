<?php include 'estructura/head.php'; ?>
<?php include 'estructura/header.php'; ?>

<section class="banner-carousel">
  <div id="scene">
    <div id="left-zone">
      <ul class="list">
        <li class="item">
          <input type="radio" id="radio_perros" name="basic_carousel" checked>
          <label class="label_perros" for="radio_perros">Perros</label>
          <div class="content content_perros">
            <span class="picto"></span>
            <h1>Perros</h1>
            <p>Accesorios cómodos, resistentes y con estilo para tu fiel y mejor amigo.</p>
          </div>
        </li>
        <li class="item">
          <input type="radio" id="radio_gatos" name="basic_carousel">
          <label class="label_gatos" for="radio_gatos">Gatos</label>
          <div class="content content_gatos">
            <span class="picto"></span>
            <h1>Gatos</h1>
            <p>Productos diseñados para el confort, juego y bienestar felino.</p>
          </div>
        </li>
        <li class="item">
          <input type="radio" id="radio_ofertas" name="basic_carousel">
          <label class="label_ofertas" for="radio_ofertas">Ofertas</label>
          <div class="content content_ofertas">
            <span class="picto"></span>
            <h1>Ofertas</h1>
            <p>Descuentos especiales cada mes hasta el 50% de descuento.</p>
          </div>
        </li>
        <li class="item">
          <input type="radio" id="radio_nuevos" name="basic_carousel">
          <label class="label_nuevos" for="radio_nuevos">Adopción</label>
          <div class="content content_nuevos">
            <span class="picto"></span>
            <h1>Adopción</h1>
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
    <img src="img/fondo-video.png" class="video-bg" alt="Fondo del video">
    <video class="promo-video" controls muted loop>
        <source src="videos/video de bienvenida MAYA.mp4" type="video/mp4">
        Tu navegador no soporta videos.
    </video>
</div>

<section class="why-maya">
  <h2>¿Por qué elegir Accesorios Maya?</h2>
  <div class="why-cards">
    <div class="why-card">
      <img src="img/icon-quality.png" alt="Calidad garantizada">
      <h3>Calidad Garantizada</h3>
      <p>Seleccionamos materiales seguros, resistentes y cómodos.</p>
    </div>
    <div class="why-card">
      <img src="img/icon-love.png" alt="Diseñado con amor">
      <h3>Diseñado con Amor</h3>
      <p>Cada accesorio está pensado para el bienestar de tu mascota.</p>
    </div>
    <div class="why-card">
      <img src="img/icon-shipping.png" alt="Envíos confiables">
      <h3>Envíos Confiables</h3>
      <p>Recibe tus productos de forma segura y rápida.</p>
    </div>
    <div class="why-card">
      <img src="img/icon-support.png" alt="Atención personalizada">
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
                        <img src="img/<?php echo $i; ?>.png" alt="Image <?php echo $i; ?>">
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
    document.addEventListener('DOMContentLoaded', function () {
        const swipers = document.querySelectorAll('.swiper');
        swipers.forEach(swiperElement => {
            new Swiper(swiperElement, {
                loop: true,
                autoplay: { delay: 3000, disableOnInteraction: false },
                slidesPerView: 1,
            });
        });
    });
</script>

</body>
</html>