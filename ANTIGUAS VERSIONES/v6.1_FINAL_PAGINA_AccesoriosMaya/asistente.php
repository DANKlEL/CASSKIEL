<?php 
    /**
     * ASISTENTE.PHP - Controlador Global de IAs (Dankiel y Maya)
     * Detecta la página actual para auto-desactivarse en la sección de Perfil.
     */
    
    // Obtener el nombre del archivo actual
    $pagina_actual = basename($_SERVER['PHP_SELF']);

    // Si estamos en perfil.php, detenemos la ejecución de este archivo por completo
    if ($pagina_actual === 'perfil.php') {
        return; 
    }

    // --- Lógica normal de carga si NO es perfil.php ---
    
    // Conectamos todos los cerebros de Dankiel
    include_once 'asistente/preguntas1.php'; 
    include_once 'asistente/preguntas2.php'; 
    include_once 'asistente/preguntas3.php'; 
    include_once 'asistente/productos.php'; 

    // Conexión con el asistente de voz Maya
    include_once 'asistente/convai.php'; 
?>

<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    /* Contenedor Principal del Chat de Dankiel */
    #chat-window {
        font-family: 'Quicksand', sans-serif !important;
        display: none; 
        position: fixed !important; 
        bottom: 95px !important; 
        left: 20px !important; 
        width: 350px; 
        height: 520px; 
        background: #ffffff; 
        border-radius: 20px; 
        flex-direction: column; 
        box-shadow: 0 12px 40px rgba(0,0,0,0.25); 
        z-index: 2000000 !important; 
        overflow: hidden; 
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
    }

    /* Botón Flotante de Dankiel (Izquierda) */
    #btn-asistente {
        position: fixed !important; 
        bottom: 20px !important; 
        left: 20px !important; 
        width: 65px; 
        height: 65px; 
        background: #2c656d; 
        border-radius: 50%; 
        display: flex !important; 
        align-items: center; 
        justify-content: center; 
        color: white; 
        cursor: pointer; 
        z-index: 2000000 !important; 
        box-shadow: 0 5px 20px rgba(44, 101, 109, 0.4);
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    #btn-asistente:hover { transform: scale(1.1) rotate(5deg); }

    /* Burbujas de Chat */
    .bubble-bot { 
        background: #343a40; 
        color: white; 
        padding: 12px 15px; 
        border-radius: 18px 18px 18px 0; 
        max-width: 85%; 
        font-size: 0.95rem; 
        line-height: 1.4;
    }
    .bubble-user { 
        background: #f0f2f5; 
        color: #333; 
        padding: 12px 15px; 
        border-radius: 18px 18px 0 18px; 
        max-width: 85%; 
        font-size: 0.95rem; 
        align-self: flex-end; 
        border: 1px solid #dee2e6;
    }

    .card-dankiel {
        background: #fff; 
        border: 1px solid #eee; 
        border-radius: 15px;
        padding: 12px; 
        margin-top: 10px; 
        text-align: center;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
</style>

<div id="btn-asistente" onclick="toggleDankiel()">
    <i class="fas fa-paw" style="font-size: 28px;"></i>
</div>

<div id="chat-window">
    <div style="background: #2c3e50; color: white; padding: 18px; display: flex; align-items: center; justify-content: space-between;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <img src="asistente/img/mapache.PNG" style="width: 45px; height: 45px; border-radius: 50%; border: 2px solid #fff; background: #fff; object-fit: cover;">
            <div>
                <strong style="display: block; font-size: 1.1rem;">Dankiel</strong>
                <small style="color: #2ecc71; font-size: 0.75rem;">● Experto en Tesoros</small>
            </div>
        </div>
        <span onclick="toggleDankiel()" style="cursor: pointer; font-size: 26px; line-height: 1;">&times;</span>
    </div>

    <div id="chat-body" style="flex: 1; padding: 20px; overflow-y: auto; background: #fdfdfd; display: flex; flex-direction: column; gap: 15px;">
        <div class="bubble-bot">
            ¡Hola! Soy <b>Dankiel</b>. 🦝 He estado husmeando por el almacén y encontré cosas increíbles. ¿Qué buscamos hoy, algo para un Perro o un Gato?
        </div>
    </div>

    <div style="padding: 15px; border-top: 1px solid #eee; display: flex; gap: 8px; background: white;">
        <input type="text" id="chat-input" placeholder="Pregúntale algo a Dankiel..." style="flex: 1; border: 1px solid #ddd; padding: 12px; border-radius: 12px; outline: none; font-size: 0.9rem;">
        <button onclick="enviarMensajeDankiel()" style="background: #2c3e50; color: white; border: none; padding: 0 18px; border-radius: 12px; cursor: pointer; font-weight: 600;">Enviar</button>
    </div>
</div>

<script>
const SABER_DANKIEL = { 
    ...BASE_PREGUNTAS_EXTENSA, 
    ...BASE_PREGUNTAS_V2, 
    ...PREGUNTAS_COMICAS 
};

function toggleDankiel() {
    const win = document.getElementById('chat-window');
    const mayaWin = document.getElementById('maya-wrapper'); 
    
    if (win.style.display === 'none' || win.style.display === '') {
        if(mayaWin) mayaWin.style.display = 'none';
        win.style.display = 'flex';
    } else {
        win.style.display = 'none';
    }
}

// Intercepción de Maya para cerrar a Dankiel
const originalToggleMaya = typeof toggleMayaMain === "function" ? toggleMayaMain : null;
window.toggleMayaMain = function() {
    const winDankiel = document.getElementById('chat-window');
    if(winDankiel) winDankiel.style.display = 'none';
    
    const wrapper = document.getElementById('maya-wrapper');
    const icon = document.getElementById('launcher-icon');
    if (wrapper.style.display === 'none' || wrapper.style.display === '') {
        wrapper.style.display = 'block';
        if(icon) icon.className = 'fas fa-times';
    } else {
        wrapper.style.display = 'none';
        if(icon) icon.className = 'fas fa-robot';
        if(typeof endCall === "function") endCall();
    }
};

function addBubble(text, sender) {
    const body = document.getElementById('chat-body');
    if(!body) return;
    const div = document.createElement('div');
    div.className = sender === 'bot' ? 'bubble-bot' : 'bubble-user';
    div.innerHTML = text;
    body.appendChild(div);
    body.scrollTop = body.scrollHeight;
}

function enviarMensajeDankiel() {
    const input = document.getElementById('chat-input');
    const rawMsg = input.value.trim();
    const msg = rawMsg.toLowerCase();
    
    if (!msg) return;

    addBubble(rawMsg, 'user');
    input.value = '';

    setTimeout(() => {
        let resp = "";
        // Lógica de respuestas (perros/gatos/etc)
        if (msg.includes("perro")) {
            resp = "¡Los perros aman nuestros accesorios! 🐕 ¿Te gustaría que te lleve a ver su sección?";
        } else if (msg.includes("gato")) {
            resp = "¡Miau! Tengo rascadores que les fascinan. 🐈 ¿Quieres ver la sección de gatos?";
        } else {
            let encontrado = false;
            for (let id in SABER_DANKIEL) {
                if (SABER_DANKIEL[id].keywords.some(k => msg.includes(k))) {
                    resp = SABER_DANKIEL[id].respuesta;
                    encontrado = true;
                    break;
                }
            }
            if (!encontrado) resp = "Dankiel está husmeando... 🤔 No encontré eso, pero pregúntame por secciones o productos.";
        }
        if (resp) addBubble(resp, 'bot');
    }, 650);
}

document.getElementById('chat-input').addEventListener('keypress', (e) => {
    if (e.key === 'Enter') enviarMensajeDankiel();
});
</script>