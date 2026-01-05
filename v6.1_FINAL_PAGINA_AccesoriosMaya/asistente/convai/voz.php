<?php
/**
 * VOZ.PHP - Versión Forzada para Microsoft Zira o Voz Femenina
 */
?>
<script>
    const mayaVoz = {
        pitch: 1.2,  // Un poco más agudo para asegurar feminidad
        rate: 1.4,   // Un poco más rápido como pediste
        voice: null,

        init() {
            const cargarVoces = () => {
                const voces = window.speechSynthesis.getVoices();
                
                // 1. BUSQUEDA PRIORITARIA: Buscamos específicamente a Zira o Sabina
                let seleccion = voces.find(v => v.name.includes('Zira') || v.name.includes('Sabina'));

                // 2. Si no está Zira, buscamos cualquier voz que sea "Female" en español
                if (!seleccion) {
                    seleccion = voces.find(v => 
                        v.lang.includes('es') && 
                        (v.name.toLowerCase().includes('female') || v.name.toLowerCase().includes('mujer'))
                    );
                }

                // 3. Si sigue sin encontrar, buscamos "Helena" o "Maria" (comunes en Windows)
                if (!seleccion) {
                    seleccion = voces.find(v => v.name.includes('Helena') || v.name.includes('Maria'));
                }

                this.voice = seleccion;
                
                // Imprimimos en consola para que tú mismo veas qué voz capturó
                console.log("Maya ha elegido la voz: ", this.voice ? this.voice.name : "No se encontró voz de mujer");
            };

            // Ejecutar carga
            cargarVoces();
            if (speechSynthesis.onvoiceschanged !== undefined) {
                speechSynthesis.onvoiceschanged = cargarVoces;
            }
        },

        decir(texto) {
            if (!texto) return;
            
            // Limpiar etiquetas HTML para que no las lea
            const textoLimpio = texto.replace(/<[^>]*>?/gm, '');
            window.speechSynthesis.cancel();

            const enunciado = new SpeechSynthesisUtterance(textoLimpio);
            
            // Forzamos la voz encontrada
            if (this.voice) {
                enunciado.voice = this.voice;
            }
            
            enunciado.pitch = this.pitch;
            enunciado.rate = this.rate;
            enunciado.lang = 'es-MX'; 

            window.speechSynthesis.speak(enunciado);
        }
    };

    // Inicialización inmediata
    mayaVoz.init();
</script>