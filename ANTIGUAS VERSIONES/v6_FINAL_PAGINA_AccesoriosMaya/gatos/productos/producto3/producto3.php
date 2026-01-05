<?php
$p3_nombre_base = "Poste Rascador";
$p3_precio = 350.00;
?>

<script>
async function verDetallesProducto3() {
    const nombreBase = "<?php echo $p3_nombre_base; ?>";
    const precio = <?php echo $p3_precio; ?>;
    
    // Ruta de la imagen para el producto 3
    let imagenRuta = "productosGatos/producto3.png";
    
    // Consultar cantidad actual
    const cantInicial = obtenerCantDesdeCarrito(nombreBase);

    Swal.fire({
        title: `<span style="font-family: 'Quicksand', sans-serif; font-weight: 700; color: #333;">${nombreBase}</span>`,
        html: `
            <div style="text-align: left; font-family: 'Quicksand', sans-serif;">
                <img id="swal-img-p3" src="/AccesoriosMaya/img/${imagenRuta}" style="width:100%; max-width:200px; display:block; margin: 0 auto 15px; border-radius:15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                
                <div style="font-size: 0.85rem; color: #444; line-height: 1.5;">
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li>🐾 <b>Diseño:</b> Poste vertical ergonómico.</li>
                        <li>🧶 <b>Material:</b> Sisal natural de alta resistencia.</li>
                        <li>🛡️ <b>Base:</b> Reforzada para mayor estabilidad.</li>
                    </ul>
                </div>

                <p style="color: #2c656d; font-size: 1.5rem; font-weight: 700; text-align: center; margin: 15px 0;">
                    Total: $<span id="total-price-modal">${(precio * cantInicial).toFixed(2)}</span>
                </p>

                <div style="background: #f9f9f9; padding: 12px; border-radius: 12px; display: flex; align-items: center; justify-content: center; gap: 10px;">
                    <label style="font-weight: 600; color: #333;">Cantidad:</label>
                    <input type="number" id="swal-qty-p3" class="swal2-input" value="${cantInicial}" min="1" max="5" onkeydown="return false" style="width: 70px; margin: 0; height: 35px; border-radius: 8px;">
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Confirmar / Actualizar',
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