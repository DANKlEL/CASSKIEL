<?php
$p3_nombre_base = "Casa Térmica Gigante";
$p3_precio = 2500.00;
?>

<script>
async function verDetallesProducto3() {
    const nombreBase = "<?php echo $p3_nombre_base; ?>";
    const precio = <?php echo $p3_precio; ?>;
    let imagenRuta = "productosPerros/producto3.png";
    const cantInicial = obtenerCantDesdeCarrito(nombreBase);

    Swal.fire({
        title: `<span style="font-family: 'Quicksand', sans-serif; font-weight: 700; color: #333;">${nombreBase}</span>`,
        html: `
            <div style="text-align: left; font-family: 'Quicksand', sans-serif;">
                <img id="swal-img-p3" src="/AccesoriosMaya/img/${imagenRuta}" style="width:100%; max-width:200px; display:block; margin: 0 auto 15px; border-radius:15px;">
                
                <div style="font-size: 0.85rem; color: #444; line-height: 1.5;">
                    <p>🏡 <b>Dimensiones:</b> Ideal para San Bernardo o Gran Danés.</p>
                    <p>🌡️ <b>Térmica:</b> Mantiene 18°C constantes en el interior.</p>
                </div>

                <p style="color: #2c656d; font-size: 1.5rem; font-weight: 700; text-align: center; margin: 15px 0;">
                    Total: $<span id="total-price-modal">${(precio * cantInicial).toFixed(2)}</span>
                </p>

                <div style="background: #f9f9f9; padding: 12px; border-radius: 12px; display: flex; align-items: center; justify-content: center; gap: 10px;">
                    <label style="font-weight: 600;">Cantidad:</label>
                    <input type="number" id="swal-qty-p3" class="swal2-input" value="${cantInicial}" min="1" max="3" onkeydown="return false" style="width: 70px; margin: 0;">
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Añadir al Carrito',
        confirmButtonColor: '#2c656d',
        cancelButtonText: 'Regresar',
        reverseButtons: true,
        didOpen: () => {
            configurarModalDinamico(precio, nombreBase);
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const cant = document.getElementById('swal-qty-p3').value;
            enviarAlCarritoGlobal(nombreBase, precio, imagenRuta, cant);
        }
    });
}
</script>