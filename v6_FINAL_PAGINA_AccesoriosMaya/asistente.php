<?php 
    // Conectamos todos los cerebros de Dankiel
    include_once 'asistente/preguntas1.php'; 
    include_once 'asistente/preguntas2.php'; 
    include_once 'asistente/preguntas3.php'; 
    include_once 'asistente/productos.php'; 

    // AGREGADO: Conexión con el nuevo asistente de voz Maya
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
        left: 20px !important; /* Lado opuesto a Maya */
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
        left: 20px !important; /* Maya está a la derecha (right: 20px) */
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
        box-shadow: 2px 2px 5px rgba(0,0,0,0.05);
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

    /* Tarjetas de Productos */
    .card-dankiel {
        background: #fff; 
        border: 1px solid #eee; 
        border-radius: 15px;
        padding: 12px; 
        margin-top: 10px; 
        text-align: center;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        transition: transform 0.2s;
    }
    .card-dankiel:hover { transform: translateY(-3px); }
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
// Unimos todos los conocimientos de Dankiel
const SABER_DANKIEL = { 
    ...BASE_PREGUNTAS_EXTENSA, 
    ...BASE_PREGUNTAS_V2, 
    ...PREGUNTAS_COMICAS 
};

/**
 * Función Toggle Corregida:
 * Cierra a Maya si se abre a Dankiel para evitar ruidos visuales.
 */
function toggleDankiel() {
    const win = document.getElementById('chat-window');
    const mayaWin = document.getElementById('maya-wrapper'); // Contenedor de Maya
    
    if (win.style.display === 'none' || win.style.display === '') {
        // Si Maya está abierta, la cerramos
        if(mayaWin) mayaWin.style.display = 'none';
        win.style.display = 'flex';
    } else {
        win.style.display = 'none';
    }
}

// Sobrescribimos o añadimos la función de Maya para que también cierre a Dankiel
// Esto asegura una convivencia perfecta
const originalToggleMaya = typeof toggleMayaMain === "function" ? toggleMayaMain : null;
window.toggleMayaMain = function() {
    const winDankiel = document.getElementById('chat-window');
    if(winDankiel) winDankiel.style.display = 'none';
    
    // Ejecuta la lógica original de Maya
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

        if (msg.includes("ayuda") || msg.includes("disponible") || msg.includes("catalogo") || msg.includes("productos")) {
            addBubble("¡Entendido! Dankiel ha seleccionado estas joyas:", 'bot');
            if(typeof CATALOGO_REAL !== 'undefined') {
                CATALOGO_REAL.perros.slice(0,2).forEach(p => showProduct(p));
                CATALOGO_REAL.gatos.slice(0,2).forEach(p => showProduct(p));
            }
            resp = "¿Qué te parecen? ¿Quieres ir a la sección completa de <b>Perros</b> o <b>Gatos</b>?";
        } 
        else if (msg === "si" || msg === "claro" || msg.includes("por favor")) {
            if (contextoMascota === "perros") {
                addBubble("¡Guau! ¡Dankiel te guía al paraíso canino!", 'bot');
                setTimeout(() => window.location.href = "perros.php", 1000);
                return;
            } else if (contextoMascota === "gatos") {
                addBubble("¡Miau-ravilloso! Vamos directo a la sección felina.", 'bot');
                setTimeout(() => window.location.href = "gatos.php", 1000);
                return;
            }
            resp = "¡Dankiel está listo! Pero dime... ¿buscamos algo para un perro o un gato? 🦝";
        }
        else if (msg.includes("perro")) {
            resp = "¡Los perros aman nuestros accesorios! 🐕 ¿Te gustaría que te lleve a ver su sección?";
            contextoMascota = "perros";
        }
        else if (msg.includes("gato")) {
            resp = "¡Miau! Tengo rascadores que les fascinan. 🐈 ¿Quieres ver la sección de gatos?";
            contextoMascota = "gatos";
        }
        else {
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

function showProduct(p) {
    const body = document.getElementById('chat-body');
    const card = document.createElement('div');
    card.className = 'card-dankiel';
    card.innerHTML = `
        <img src="${p.img}" style="width: 100px; height: 100px; object-fit: contain; margin-bottom: 8px;">
        <div style="font-weight: 700; color: #333; font-size: 0.9rem;">${p.nombre}</div>
        <div style="color: #2c656d; font-weight: 800; margin: 5px 0;">$${p.precio}</div>
        <a href="${p.link}" style="display: inline-block; background: #2c3e50; color: white; text-decoration: none; padding: 6px 15px; border-radius: 8px; font-size: 0.75rem; font-weight: bold;">Ver Detalles</a>
    `;
    body.appendChild(card);
    body.scrollTop = body.scrollHeight;
}

document.getElementById('chat-input').addEventListener('keypress', (e) => {
    if (e.key === 'Enter') enviarMensajeDankiel();
});
</script>