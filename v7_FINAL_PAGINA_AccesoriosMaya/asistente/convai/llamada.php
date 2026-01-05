<div id="maya-call-ui" class="maya-call-container">
    <div class="maya-inner-chat">
        <div class="maya-call-body" style="background-image: url('asistente/convai/convai2.png');">
            
            <div class="maya-call-overlay">
                <div class="maya-call-info">
                    <span class="pulse-ring"></span>
                    <h3>Maya AI</h3>
                    <p id="call-status">Llamada de voz...</p>
                </div>

                <div class="maya-call-actions">
                    <button class="btn-call vol" onclick="toggleVolume(this)" title="Volumen">
                        <i class="fas fa-volume-up"></i>
                    </button>
                    
                    <button class="btn-call hangup" onclick="endCall()" title="Colgar">
                        <i class="fas fa-phone-slash"></i>
                    </button>
                    
                    <button class="btn-call video" onclick="toggleVideo(this)" title="Videollamada">
                        <i class="fas fa-video"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Funciones de los botones
function toggleVolume(btn) {
    const icon = btn.querySelector('i');
    if (icon.classList.contains('fa-volume-up')) {
        icon.className = 'fas fa-volume-mute';
        btn.style.background = 'rgba(255, 255, 255, 0.2)';
        console.log("Audio silenciado");
    } else {
        icon.className = 'fas fa-volume-up';
        btn.style.background = 'rgba(255, 255, 255, 0.3)';
        console.log("Audio activado");
    }
}

function toggleVideo(btn) {
    btn.classList.toggle('active-video');
    console.log("Cambiando modo de video");
}

function endCall() {
    document.getElementById('maya-call-ui').style.display = 'none';
    document.getElementById('call-status').innerText = "Llamada finalizada";
    // Podrías volver a mostrar el chat normal aquí si quisieras
    setTimeout(() => { toggleMayaSim(); }, 500);
}
</script>