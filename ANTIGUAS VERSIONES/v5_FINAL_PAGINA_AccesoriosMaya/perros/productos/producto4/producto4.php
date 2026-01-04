<?php
$p4_nombre_base = "Pelota Deportiva Mordible";
$p4_precio = 150.00;
?>

<script>
async function verDetallesProducto4() {
    const nombreBase = "<?php echo $p4_nombre_base; ?>";
    const precio = <?php echo $p4_precio; ?>;
    // Imagen fija solicitada
    let imagenRuta = "productosPerros/producto4.png"; 
    const cantInicial = obtenerCantDesdeCarrito(nombreBase);

    Swal.fire({
        title: `<span style="font-family: 'Quicksand', sans-serif; font-weight: 700; color: #333;">${nombreBase}</span>`,
        html: `
            <div style="text-align: left; font-family: 'Quicksand', sans-serif;">
                <img id="swal-img-p4" src="/AccesoriosMaya/img/${imagenRuta}" style="width:100%; max-width:180px; display:block; margin: 0 auto 15px; border-radius:15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                
                <div style="font-size: 0.85rem; color: #444; line-height: 1.5; background: #fdfdfd; padding: 10px; border-radius: 10px; border: 1px solid #eee;">
                    <p>🎾 <b>Diversión:</b> Material de alta resistencia para morder y rebotar.</p>
                    <p>🦷 <b>Dental:</b> Ayuda a masajear las encías durante el juego y limpiar el sarro.</p>
                </div>

                <p style="color: #2c656d; font-size: 1.5rem; font-weight: 700; text-align: center; margin: 15px 0;">
                    Total: $<span id="total-price-modal">${(precio * cantInicial).toFixed(2)}</span>
                </p>

                <div style="background: #f4f4f4; padding: 12px; border-radius: 12px; display: flex; align-items: center; justify-content: center; gap: 10px;">
                    <label style="font-weight: 600;">Cantidad:</label>
                    <input type="number" id="swal-qty-p4" class="swal2-input" value="${cantInicial}" min="1" max="10" onkeydown="return false" style="width: 70px; margin: 0; height: 35px; border-radius: 8px;">
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Añadir al Carrito',
        confirmButtonColor: '#2c656d',
        cancelButtonText: 'Regresar',
        reverseButtons: true,
        didOpen: () => {
            // Lógica para actualizar el precio si el usuario cambia la cantidad
            const inputQty = document.getElementById('swal-qty-p4');
            const totalSpan = document.getElementById('total-price-modal');
            inputQty.addEventListener('input', () => {
                totalSpan.innerText = (precio * inputQty.value).toFixed(2);
            });
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const cant = document.getElementById('swal-qty-p4').value;
            enviarAlCarritoGlobal(nombreBase, precio, imagenRuta, cant);
        }
    });
}
</script>