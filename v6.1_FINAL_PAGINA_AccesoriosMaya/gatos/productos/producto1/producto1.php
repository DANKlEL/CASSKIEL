<?php
$p1_nombre_base = "Torre Juguetero";
$p1_precio = 850.00;
?>

<script>
async function verDetallesProducto1() {
    const nombreBase = "<?php echo $p1_nombre_base; ?>";
    const precio = <?php echo $p1_precio; ?>;
    
    let colorSeleccionado = 'Amarillo';
    let imagenRuta = "productosGatos/producto1Amarillo.png";
    
    // Consultar cantidad actual en el carrito para el color inicial
    const cantInicial = obtenerCantDesdeCarrito(`${nombreBase} (${colorSeleccionado})`);

    Swal.fire({
        title: `<span style="font-family: 'Quicksand', sans-serif; font-weight: 700; color: #333;">${nombreBase}</span>`,
        html: `
            <div style="text-align: left; font-family: 'Quicksand', sans-serif;">
                <img id="swal-img-p1" src="/AccesoriosMaya/img/${imagenRuta}" style="width:100%; max-width:200px; display:block; margin: 0 auto 15px; border-radius:15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                
                <div style="text-align:center; margin-bottom:15px;">
                    <p style="font-weight:bold; margin-bottom:8px; font-size:0.9rem; color: #333;">Selecciona un color:</p>
                    <button onclick="cambiarColorP1('Amarillo')" style="width:30px; height:30px; border-radius:50%; background:#FFD700; border:2px solid #ccc; cursor:pointer;"></button>
                    <button onclick="cambiarColorP1('Azul')" style="width:30px; height:30px; border-radius:50%; background:#1E90FF; border:2px solid #ccc; cursor:pointer; margin-left:10px;"></button>
                    <p id="color-label-p1" style="font-size:0.85rem; color:#2c656d; margin-top:5px; font-weight:bold;">Color: Amarillo</p>
                </div>

                <div style="font-size: 0.85rem; color: #444; line-height: 1.5;">
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li>🐾 <b>Medidas:</b> 120cm Altura x 45cm Ancho.</li>
                        <li>🧶 <b>Material:</b> Madera reforzada y sisal natural.</li>
                        <li>🛡️ <b>Garantía:</b> 6 meses.</li>
                    </ul>
                </div>

                <p style="color: #2c656d; font-size: 1.5rem; font-weight: 700; text-align: center; margin: 15px 0;">
                    Total: $<span id="total-price-modal">${(precio * cantInicial).toFixed(2)}</span>
                </p>

                <div style="background: #f9f9f9; padding: 12px; border-radius: 12px; display: flex; align-items: center; justify-content: center; gap: 10px;">
                    <label style="font-weight: 600; color: #333;">Cantidad:</label>
                    <input type="number" id="swal-qty-p1" class="swal2-input" value="${cantInicial}" min="1" max="5" onkeydown="return false" style="width: 70px; margin: 0; height: 35px; border-radius: 8px;">
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Confirmar / Actualizar',
        confirmButtonColor: '#2c656d',
        cancelButtonText: 'Regresar',
        reverseButtons: true,
        didOpen: () => {
            // Inicializar lógica de productosGatos.js
            configurarModalDinamico(precio, nombreBase);
            
            window.cambiarColorP1 = (color) => {
                const info = cambiarColorModal(color, 'swal-img-p1', 'color-label-p1', 'producto1');
                colorSeleccionado = info.color;
                imagenRuta = info.nuevaRuta;
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const cant = document.getElementById('swal-qty-p1').value;
            const nombreFinal = `${nombreBase} (${colorSeleccionado})`;
            enviarAlCarritoGlobal(nombreFinal, precio, imagenRuta, cant);
        }
    });
}
</script>