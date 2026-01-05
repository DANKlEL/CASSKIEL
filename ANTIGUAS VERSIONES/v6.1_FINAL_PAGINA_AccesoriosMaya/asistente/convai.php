<?php 
/**
 * CONVAI.PHP - El Asistente Maya
 * Se han actualizado las rutas para que funcionen desde cualquier subcarpeta (como /perfil/).
 */

// Definimos la ruta base del asistente para los includes de PHP
$basePathMaya = __DIR__ . '/'; 
// Definimos la ruta web para los recursos (CSS, Imágenes)
$webPathMaya = '/AccesoriosMaya/asistente/convai/';
?>

<link rel="stylesheet" href="<?php echo $webPathMaya; ?>convai.css">
<link rel="stylesheet" href="<?php echo $webPathMaya; ?>llamadaCurso.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<?php 
    // Inclusión segura de la lógica del asistente usando rutas absolutas de servidor
    if (file_exists($basePathMaya . 'llamadaCurso.php')) include_once $basePathMaya . 'llamadaCurso.php'; 
    if (file_exists($basePathMaya . 'voz.php')) include_once $basePathMaya . 'voz.php'; 
    if (file_exists($basePathMaya . 'microfono.php')) include_once $basePathMaya . 'microfono.php'; 
?>

<div id="maya-wrapper" class="maya-main-wrapper" style="display: none;">
    <div class="maya-inner-content">
        
        <div id="screen-chat" style="display: flex; flex-direction: column; height: 100%;">
            <div class="maya-header" style="border-bottom: 2px solid #2c656d;">
                <div class="maya-profile">
                    <img src="<?php echo $webPathMaya; ?>convai.png" class="maya-avatar-img" alt="Maya AI">
                    <span class="maya-name" style="color: #2c656d;">Maya AI</span>
                </div>
                <button onclick="startCall()" title="Llamar a Maya" style="background:none; border:none; color:#2c656d; cursor:pointer; font-size:18px;">
                    <i class="fas fa-phone-alt"></i>
                </button>
            </div>

            <div id="maya-history">
                <div class="msg msg-maya">¡Hola! Soy Maya de Accesorios Maya. ¿Buscas algo para un perro o un gato?</div>
            </div>

            <div class="maya-input-area">
                <button onclick="mayaMicro.escuchar()" class="btn-micro-maya" title="Hablar con Maya" style="background:none; border:none; color:#2c656d; cursor:pointer; font-size:18px; margin-right: 8px; transition: 0.3s;">
                    <i class="fas fa-microphone"></i>
                </button>

                <input type="text" id="maya-input" placeholder="Escribe o habla aquí..." onkeypress="if(event.key==='Enter') processText()">
                
                <button class="btn-send-sim" onclick="processText()" style="color: #2c656d;">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>

        <div id="screen-call" class="maya-call-screen" style="background-image: url('<?php echo $webPathMaya; ?>convai2.png'); display: none;">
            <div class="call-overlay"></div>
            <div class="call-info">
                <div class="pulse-effect" style="border: 2px solid #2c656d;"></div>
                <h2 style="color: white;">Maya AI</h2>
                <p id="status-text" style="color: white;">Llamando...</p>
            </div>

            <div class="call-actions">
                <button class="btn-action btn-tool" onclick="this.classList.toggle('active')"><i class="fas fa-volume-up"></i></button>
                <button class="btn-action btn-hangup" onclick="endCall()" style="background-color: #ff4d4d;"><i class="fas fa-phone-slash"></i></button>
                <button class="btn-action btn-tool" onclick="this.classList.toggle('active')"><i class="fas fa-video"></i></button>
            </div>
        </div>
    </div>
</div>

<div id="maya-launcher" onclick="toggleMayaMain()" style="position: fixed; bottom: 20px; right: 20px; width: 65px; height: 65px; background: #2c656d; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; cursor: pointer; z-index: 1000000; box-shadow: 0 5px 15px rgba(44, 101, 109, 0.4);">
    <i class="fas fa-robot" id="launcher-icon" style="font-size: 28px;"></i>
</div>

<script>
let contextoMascota = ""; 

function toggleMayaMain() {
    const wrapper = document.getElementById('maya-wrapper');
    const winDankiel = document.getElementById('chat-window'); 
    const icon = document.getElementById('launcher-icon');
    
    if (wrapper.style.display === 'none' || wrapper.style.display === '') {
        if(winDankiel) winDankiel.style.display = 'none'; 
        wrapper.style.display = 'block';
        if(icon) icon.className = 'fas fa-times';
    } else {
        wrapper.style.display = 'none';
        if(icon) icon.className = 'fas fa-robot';
        endCall(); 
    }
}

function startCall() {
    document.getElementById('screen-chat').style.display = 'none';
    document.getElementById('screen-call').style.display = 'flex';
    if (typeof iniciarSecuenciaLlamada === "function") iniciarSecuenciaLlamada();
}

function endCall() {
    document.getElementById('screen-call').style.display = 'none';
    document.getElementById('screen-chat').style.display = 'flex';
    
    const miniChat = document.getElementById('mini-chat-llamada');
    if (miniChat) miniChat.style.display = 'none';
    
    if(typeof detenerSonidosMaya === "function") {
        detenerSonidosMaya();
    } else {
        window.speechSynthesis.cancel();
    }

    if (typeof mayaMicro !== 'undefined' && mayaMicro.isListening) {
        mayaMicro.recognition.stop();
    }
}

function processText() {
    const input = document.getElementById('maya-input');
    const history = document.getElementById('maya-history');
    if (input.value.trim() === "") return;

    const userText = input.value.toLowerCase();
    history.innerHTML += `<div class="msg msg-user">${input.value}</div>`;
    input.value = "";
    history.scrollTop = history.scrollHeight;

    setTimeout(() => {
        let resp = "";
        
        if (userText === "si" || userText === "claro" || userText.includes("por favor")) {
            if (contextoMascota === "perros") {
                resp = "¡Excelente! Te llevo a la sección de perros ahora mismo.";
                history.innerHTML += `<div class="msg msg-maya">${resp} 🐕</div>`;
                if(typeof mayaVoz !== 'undefined') mayaVoz.decir(resp);
                setTimeout(() => window.location.href = "/AccesoriosMaya/perros.php", 1500);
                return;
            } else if (contextoMascota === "gatos") {
                resp = "¡Miau! Vamos a ver todo para los michis inmediatamente.";
                history.innerHTML += `<div class="msg msg-maya">${resp} 🐈</div>`;
                if(typeof mayaVoz !== 'undefined') mayaVoz.decir(resp);
                setTimeout(() => window.location.href = "/AccesoriosMaya/gatos.php", 1500);
                return;
            }
            resp = "¿Qué te gustaría ver? Tengo accesorios para perros y gatos.";
        } 
        else if (userText.includes("perro")) {
            resp = "¡Los perros son geniales! ¿Quieres que te muestre nuestro catálogo para ellos?";
            contextoMascota = "perros";
        }
        else if (userText.includes("gato")) {
            resp = "¡Miau! Tenemos rascadores y camas increíbles. ¿Quieres ir a la sección de gatos?";
            contextoMascota = "gatos";
        }
        else {
            // Intentar usar la función externa de respuestas si existe
            resp = (typeof obtenerRespuestaMaya === "function") ? obtenerRespuestaMaya(userText) : "Entiendo, cuéntame más sobre lo que buscas."; 
        }

        history.innerHTML += `<div class="msg msg-maya">${resp}</div>`;
        history.scrollTop = history.scrollHeight;
        
        if(typeof mayaVoz !== 'undefined') {
            mayaVoz.decir(resp); 
        }
    }, 700);
}
</script>