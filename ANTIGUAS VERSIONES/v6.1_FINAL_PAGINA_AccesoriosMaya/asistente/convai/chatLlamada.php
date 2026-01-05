<div id="mini-chat-llamada" class="chat-lateral-maya">
    <div class="chat-lateral-header">
        <span><i class="fas fa-keyboard"></i> Transcripción</span>
    </div>
    <div id="mini-chat-history" class="chat-lateral-messages"></div>
    <div class="chat-lateral-input">
        <input type="text" id="input-lateral" placeholder="Escribe a Maya..." onkeypress="if(event.key==='Enter') enviarTextoLateral()">
        <button onclick="enviarTextoLateral()">
            <i class="fas fa-paper-plane" style="color: #95b7bc;"></i>
        </button>
    </div>
</div>

<script>
/**
 * Función para enviar texto desde el panel lateral durante la llamada
 */
function enviarTextoLateral() {
    const input = document.getElementById('input-lateral');
    const history = document.getElementById('mini-chat-history');
    if (!input || input.value.trim() === "") return;

    const textoUsuario = input.value;
    
    // 1. Mostrar mensaje del usuario
    history.innerHTML += `<div style="text-align:right; margin-bottom:10px; font-family: 'Quicksand', sans-serif;"><b>Tú:</b> ${textoUsuario}</div>`;
    input.value = "";
    history.scrollTop = history.scrollHeight;

    // 2. Maya procesa y responde
    setTimeout(() => {
        // Usamos el motor de inteligencia que ya maneja navegación y diccionarios
        const respuesta = obtenerRespuestaMaya(textoUsuario);
        
        // Mostrar respuesta de Maya en el panel
        history.innerHTML += `<div style="text-align:left; color:#95b7bc; margin-bottom:10px; font-family: 'Quicksand', sans-serif;"><b>Maya:</b> ${respuesta}</div>`;
        history.scrollTop = history.scrollHeight;
        
        // --- LA CLAVE: Maya habla la respuesta en la llamada ---
        if (typeof mayaVoz !== 'undefined') {
            mayaVoz.decir(respuesta);
        }
        
    }, 600);
}
</script>