<?php
/**
 * CONTROLADOR CENTRAL DE VALIDACIÓN DE COMPRA
 * Integra validacionCompraPagos.js, validacionCompraDireccion.js y authValidarPago.js
 */
?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script src="compra/validacionCompraPagos.js"></script>
<script src="compra/validacionCompraDireccion.js"></script>
<script src="compra/authValidarPago.js"></script>

<script>
    /* ============================================================
       ESTADO GLOBAL Y CONTROLADOR DE FLUJO
       ============================================================ */
    let pagoCompletado = false;
    let envioCompletado = false;

    /**
     * Inicia el proceso de Checkout
     */
    function iniciarFlujoPago() {
        pagoCompletado = false;
        envioCompletado = false;
        mostrarModalPrincipal();
    }

    /**
     * Modal Principal de SweetAlert2 (Checkout Multi-pestaña)
     */
    function mostrarModalPrincipal() {
        Swal.fire({
            title: '<span style="font-size: 1.4rem; font-weight: 700;">Finalizar Pedido</span>',
            html: `
                <div class="checkout-tabs-container">
                    <div class="checkout-tabs">
                        <button class="tab-btn-check active" id="tab1" onclick="cambiarPestaña(1)">
                            <span id="dotPago" class="step-dot">1</span> Pago
                        </button>
                        <button class="tab-btn-check" id="tab2" onclick="cambiarPestaña(2)">
                            <span id="dotEnvio" class="step-dot">2</span> Envío
                        </button>
                    </div>

                    <div id="pestaña1">
                        <div class="lista-items-check" id="listaTarjetasModal"></div>
                        <div id="infoLimite"></div>
                        
                        <button class="btn-add-new" onclick="toggleNuevaT()" style="background:none; border:1px dashed #ccc; padding:8px; width:100%; border-radius:20px; cursor:pointer; font-size:0.75rem; color:#888; margin-bottom:10px;">
                            <i class="fa-solid fa-plus"></i> Usar otra tarjeta
                        </button>

                        <div id="formNuevaT" class="form-dinamico-check" style="display:none;">
                            <div class="flex-pago">
                                <div class="col-card">
                                    <div class="credit-card" id="cardVisual">
                                        <div class="card-front">
                                            <div class="card-chip"></div>
                                            <div class="card-number-display" id="vn">#### #### #### ####</div>
                                            <div style="display:flex; justify-content:space-between; font-size:0.65rem;">
                                                <span id="vt">TITULAR</span>
                                                <span id="ve">MM/AA</span>
                                            </div>
                                        </div>
                                        <div class="card-back" style="transform: rotateY(180deg);">
                                            <div style="background:#111; height:20px; width:100%; margin-top:8px;"></div>
                                            <div style="background:white; color:black; text-align:right; padding:2px; margin-top:10px; border-radius:3px; font-size:0.75rem;" id="vc">***</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-inputs">
                                    <input type="text" id="cn" class="custom-input" placeholder="Número de Tarjeta" maxlength="19" oninput="formatT(this)">
                                    <input type="text" id="ct" class="custom-input" placeholder="Nombre del Titular" oninput="formatT(this)">
                                    <div style="display:flex; gap:8px;">
                                        <input type="text" id="ce" class="custom-input" placeholder="MM/AA" maxlength="5" oninput="formatT(this)">
                                        <input type="text" id="cc" class="custom-input" placeholder="CVV" maxlength="3" oninput="formatT(this)" onfocus="flip(true)" onblur="flip(false)">
                                    </div>
                                    <div style="margin:6px 0; font-size:0.7rem; display:flex; align-items:center; gap:5px; justify-content:center;">
                                        <input type="checkbox" id="guardarT" onchange="manejarGuardadoAutomatico()"> 
                                        <label for="guardarT" style="cursor:pointer;">Guardar para futuras compras</label>
                                    </div>
                                    <button type="button" class="btn-use-this" onclick="validarNuevaT()">Utilizar esta tarjeta</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="pestaña2" style="display:none;">
                        <div class="lista-items-check" id="listaDireccionesModal"></div>
                        <div id="infoLimiteDir"></div>
                        
                        <button class="btn-add-new" onclick="toggleNuevaD()" style="background:none; border:1px dashed #ccc; padding:8px; width:100%; border-radius:20px; cursor:pointer; font-size:0.75rem; color:#888; margin-bottom:10px;">
                            <i class="fa-solid fa-plus"></i> Usar otra ubicación
                        </button>

                        <div id="formNuevaD" class="form-dinamico-check" style="display:none;">
                            <div id="mapModal" style="width:100%; height:180px; border-radius:10px; margin-bottom:10px; border:1px solid #ddd; background:#f9f9f9;"></div>
                            <div class="grid-form-modal">
                                <input type="text" id="dirCiudadM" class="custom-input" placeholder="Ciudad / Estado">
                                <input type="text" id="dirCPM" class="custom-input" placeholder="Código Postal">
                                <input type="text" id="dirCalleM" class="custom-input" placeholder="Calle y Número">
                                
                                <select id="dirDeptoM" class="custom-input" style="background: white;">
                                    <option value="">Tipo de Vivienda...</option>
                                    <option value="Casa">Casa</option>
                                    <option value="Departamento">Departamento</option>
                                    <option value="Oficina">Oficina</option>
                                    <option value="Local">Local Comercial</option>
                                </select>
                            </div>
                            <button type="button" id="btnGuardarD" class="btn-use-this" onclick="validarNuevaD()">Confirmar ubicación</button>
                        </div>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Finalizar Compra',
            cancelButtonText: 'Regresar',
            buttonsStyling: false,
            customClass: {
                confirmButton: 'swal2-confirm btn-confirm-custom',
                cancelButton: 'swal2-cancel btn-cancel-custom'
            },
            didOpen: () => {
                // Inicialización de datos guardados en LocalStorage
                renderTarjetasM();
                renderDireccionesM();
                checkBotonConfirmar();
            },
            preConfirm: () => {
                // Validación de que ambos pasos estén completados
                if(!pagoCompletado || !envioCompletado) {
                    Swal.showValidationMessage('Debes seleccionar un método de pago y una dirección');
                    return false;
                }
                return true;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Función en authValidarPago.js que gestiona el backup y la redirección
                procesarPagoFinal();
            }
        });
    }

    /**
     * Maneja el cambio visual y lógico de las pestañas
     */
    function cambiarPestaña(num) {
        const p1 = document.getElementById('pestaña1');
        const p2 = document.getElementById('pestaña2');
        const t1 = document.getElementById('tab1');
        const t2 = document.getElementById('tab2');

        if(num === 1) {
            p1.style.display = 'block';
            p2.style.display = 'none';
            t1.classList.add('active');
            t2.classList.remove('active');
            renderTarjetasM();
        } else {
            p1.style.display = 'none';
            p2.style.display = 'block';
            t1.classList.remove('active');
            t2.classList.add('active');
            renderDireccionesM();
        }
    }

    /**
     * Actualiza el estado del paso 1 (Pago)
     */
    function marcarCheck(val) {
        pagoCompletado = val;
        actualizarDot('dotPago', val, '1');
        checkBotonConfirmar();
    }

    /**
     * Actualiza el estado del paso 2 (Envío)
     */
    function marcarCheckEnvio(val) {
        envioCompletado = val;
        actualizarDot('dotEnvio', val, '2');
        checkBotonConfirmar();
    }

    /**
     * Cambia visualmente el número del paso por un Check verde
     */
    function actualizarDot(id, completed, originalText) {
        const dot = document.getElementById(id);
        if(!dot) return;
        dot.classList.toggle('completed', completed);
        dot.innerHTML = completed ? '<i class="fa-solid fa-check"></i>' : originalText;
    }

    /**
     * Habilita/Deshabilita el botón de Finalizar según el progreso
     */
    function checkBotonConfirmar() {
        const btn = Swal.getConfirmButton();
        if(!btn) return;
        
        if(pagoCompletado && envioCompletado) {
            btn.style.opacity = "1";
            btn.style.pointerEvents = "auto";
            btn.style.filter = "none";
            btn.classList.remove('disabled');
        } else {
            btn.style.opacity = "0.5";
            btn.style.pointerEvents = "none";
            btn.style.filter = "grayscale(1)";
            btn.classList.add('disabled');
        }
    }
</script>