<?php
$p2_nombre_base = "Collar Personalizable Maya";
$p2_precio = 250.00;
?>

<script>
async function verDetallesProducto2() {
    const nombreBase = "<?php echo $p2_nombre_base; ?>";
    const precio = <?php echo $p2_precio; ?>;
    // Imagen fija solicitada
    let imagenRuta = "productosPerros/producto2.png"; 
    const cantInicial = obtenerCantDesdeCarrito(nombreBase);

    Swal.fire({
        title: `<span style="font-family: 'Quicksand', sans-serif; font-weight: 700; color: #333;">${nombreBase}</span>`,
        html: `
            <div style="text-align: left; font-family: 'Quicksand', sans-serif;">
                <img id="swal-img-p2" src="/AccesoriosMaya/img/${imagenRuta}" style="width:100%; max-width:200px; display:block; margin: 0 auto 15px; border-radius:15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                
                <div style="font-size: 0.85rem; color: #444; line-height: 1.5; background: #fdfdfd; padding: 12px; border-radius: 10px; border: 1px solid #eee;">
                    <p>🆔 <b>Personalización:</b> Incluye grabado láser de nombre y teléfono en placa de acero.</p>
                    <p>🛡️ <b>Material:</b> Nylon reforzado de alta resistencia con broche de seguridad.</p>
                </div>

                <p style="color: #2c656d; font-size: 1.5rem; font-weight: 700; text-align: center; margin: 15px 0;">
                    Total: $<span id="total-price-modal">${(precio * cantInicial).toFixed(2)}</span>
                </p>

                <div style="background: #f4f4f4; padding: 12px; border-radius: 12px; display: flex; align-items: center; justify-content: center; gap: 10px;">
                    <label style="font-weight: 600; color: #333;">Cantidad:</label>
                    <input type="number" id="swal-qty-p2" class="swal2-input" value="${cantInicial}" min="1" max="5" onkeydown="return false" style="width: 70px; margin: 0; height: 35px; border-radius: 8px;">
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Añadir al Carrito',
        confirmButtonColor: '#2c656d',
        cancelButtonText: 'Regresar',
        reverseButtons: true,
        didOpen: () => {
            const inputQty = document.getElementById('swal-qty-p2');
            const totalSpan = document.getElementById('total-price-modal');
            inputQty.addEventListener('input', () => {
                totalSpan.innerText = (precio * inputQty.value).toFixed(2);
            });
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const cant = document.getElementById('swal-qty-p2').value;
            enviarAlCarritoGlobal(nombreBase, precio, imagenRuta, cant);
        }
    });
}
</script>