function procesarPagoFinal() {
    // Respaldamos los datos del carrito para que la página de éxito los lea
    const carritoActual = localStorage.getItem('carritoMaya');
    if (carritoActual) {
        localStorage.setItem('ultimoPedidoMaya', carritoActual);
    }

    Swal.fire({
        title: 'Procesando Pago',
        html: `
            <div style="margin-top: 20px;">
                <i class="fa-solid fa-shield-halved fa-beat-fast" style="font-size: 3rem; color: #2c656d;"></i>
                <p style="margin-top: 20px; font-weight: 500;">Validando seguridad...</p>
                <div style="width: 100%; background: #eee; height: 8px; border-radius: 4px; overflow: hidden; margin-top: 10px;">
                    <div id="pago-progress" style="width: 0%; background: #2c656d; height: 100%; transition: width 5s linear;"></div>
                </div>
            </div>
        `,
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
            setTimeout(() => {
                const bar = document.getElementById('pago-progress');
                if(bar) bar.style.width = '100%';
            }, 100);

            setTimeout(() => {
                Swal.fire({
                    icon: 'success',
                    title: '¡Pago Exitoso!',
                    timer: 2000,
                    showConfirmButton: false,
                    willClose: () => {
                        localStorage.removeItem('carritoMaya'); // Borrar carrito original
                        window.location.href = 'compraExitosa.php';
                    }
                });
            }, 5000);
        }
    });
}