<?php 
// Carga de diccionarios
include 'diccionario/preguntas1.php';
include 'diccionario/preguntas2.php';
include 'diccionario/preguntas3.php';
include 'chatLlamada.php'; 
?>

<script>
// RUTA ACTUALIZADA: relativa a la raíz del proyecto para evitar fallos de carga
const sonidoLlamada = new Audio('asistente/convai/sounds/llamada.mp3');
sonidoLlamada.loop = true;

/**
 * MOTOR DE INTELIGENCIA UNIFICADO
 */
function obtenerRespuestaMaya(textoUsuario) {
    const input = textoUsuario.toLowerCase().trim();
    
    if (input === "si" || input === "claro" || input.includes("por favor")) {
        if (contextoMascota === "perros") {
            const resp = "¡Excelente! Te estoy llevando a la sección de perros ahora mismo.";
            setTimeout(() => window.location.href = "perros.php", 1500);
            return resp;
        } else if (contextoMascota === "gatos") {
            const resp = "¡Miau! Un segundo, nos movemos a la sección de gatos.";
            setTimeout(() => window.location.href = "gatos.php", 1500);
            return resp;
        }
    }

    if (input.includes("perro") && !input.includes("juguete") && !input.includes("collar")) {
        contextoMascota = "perros";
        return "¡Los perros son lo máximo! 🐕 ¿Te gustaría que te lleve a ver los productos para ellos?";
    }
    if (input.includes("gato") && !input.includes("juguete") && !input.includes("collar")) {
        contextoMascota = "gatos";
        return "¡Miau! Los michis mandan. 🐈 ¿Quieres ver la sección de gatos ahora?";
    }

    const todosLosDiccionarios = [BASE_PREGUNTAS_EXTENSA, BASE_PREGUNTAS_V2, PREGUNTAS_COMICAS];
    for (let diccionario of todosLosDiccionarios) {
        for (let clave in diccionario) {
            const intencion = diccionario[clave];
            if (intencion.keywords.some(k => input.includes(k))) {
                return intencion.respuesta;
            }
        }
    }
    return "Maya está procesando... 🤔 No encontré eso exactamente, pero puedes preguntarme por juguetes, envíos, o decirme si buscas algo para un perro o un gato.";
}

/**
 * SECUENCIA DE CONEXIÓN
 */
function iniciarSecuenciaLlamada() {
    // Iniciar el sonido de llamada con la nueva ruta
    sonidoLlamada.currentTime = 0;
    sonidoLlamada.play().catch(e => console.error("Error al reproducir audio:", e));

    setTimeout(() => {
        sonidoLlamada.pause(); // Detener al contestar

        const status = document.getElementById('status-text');
        if(status) {
            status.innerText = "En línea con Maya";
            status.style.color = "#2ecc71";
        }

        const chatLateral = document.getElementById('mini-chat-llamada');
        if(chatLateral) chatLateral.style.display = "flex";
        
        const history = document.getElementById('mini-chat-history');
        const bienvenida = "¡Hola! Ya estoy conectada. ¿Cómo va todo por ahí?";
        
        if(history) {
            history.innerHTML = `<div style="margin-bottom:10px; color:#95b7bc; font-family: 'Quicksand', sans-serif;"><b>Maya:</b> ${bienvenida}</div>`;
            history.scrollTop = history.scrollHeight;
        }

        if (typeof mayaVoz !== 'undefined') {
            mayaVoz.decir(bienvenida);
        }
    }, 5000); 
}

function detenerSonidosMaya() {
    sonidoLlamada.pause();
    sonidoLlamada.currentTime = 0;
    window.speechSynthesis.cancel();
}
</script>