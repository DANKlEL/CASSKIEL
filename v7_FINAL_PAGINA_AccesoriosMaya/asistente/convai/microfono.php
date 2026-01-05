<?php
/**
 * MICROFONO.PHP - Reconocimiento de Voz para Maya
 */
?>
<script>
    const mayaMicro = {
        recognition: null,
        isListening: false,

        init() {
            // Verificamos si el navegador soporta reconocimiento de voz
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            if (!SpeechRecognition) {
                console.error("Este navegador no soporta reconocimiento de voz.");
                return;
            }

            this.recognition = new SpeechRecognition();
            this.recognition.lang = 'es-MX';
            this.recognition.continuous = false; // Se detiene al terminar de hablar
            this.recognition.interimResults = false; // Solo resultados finales

            // Evento cuando Maya escucha algo
            this.recognition.onresult = (event) => {
                const textoEscuchado = event.results[0][0].transcript;
                const inputChat = document.getElementById('maya-input');
                const inputLateral = document.getElementById('input-lateral');

                // Llenamos el input que esté visible
                if (inputChat && inputChat.offsetParent !== null) {
                    inputChat.value = textoEscuchado;
                    processText(); // Procesa automáticamente el texto
                } else if (inputLateral) {
                    inputLateral.value = textoEscuchado;
                    enviarTextoLateral(); // Procesa en la llamada
                }
            };

            this.recognition.onend = () => {
                this.isListening = false;
                this.actualizarIconos(false);
            };

            this.recognition.onerror = (event) => {
                console.error("Error en micrófono:", event.error);
                this.isListening = false;
                this.actualizarIconos(false);
            };
        },

        escuchar() {
            if (this.isListening) {
                this.recognition.stop();
            } else {
                this.recognition.start();
                this.isListening = true;
                this.actualizarIconos(true);
            }
        },

        actualizarIconos(escuchando) {
            const btns = document.querySelectorAll('.btn-micro-maya');
            btns.forEach(btn => {
                if (escuchando) {
                    btn.style.color = "#ff4d4d"; // Rojo mientras escucha
                    btn.classList.add('pulse-red');
                } else {
                    btn.style.color = "#95b7bc"; // Color original
                    btn.classList.remove('pulse-red');
                }
            });
        }
    };

    // Inicializar al cargar
    mayaMicro.init();
</script>

<style>
    .pulse-red {
        animation: pulseMicro 1s infinite;
    }
    @keyframes pulseMicro {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.2); opacity: 0.7; }
        100% { transform: scale(1); opacity: 1; }
    }
</style>