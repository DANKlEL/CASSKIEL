<?php
// compraExitosa.php - Ubicado en la raíz del proyecto
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Compra Exitosa! - Maya Store</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root { --primary: #2c656d; --success: #27ae60; }
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background: #f8f9fa; color: #333; margin: 0; padding: 20px; }
        .main-container { max-width: 800px; margin: 0 auto; }
        .card-success { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); text-align: center; }
        .icon-box { width: 80px; height: 80px; background: #e8f5e9; color: var(--success); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 2.5rem; }
        .details-grid { text-align: left; margin: 30px 0; border: 1px solid #eee; border-radius: 12px; padding: 20px; }
        .product-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f9f9f9; }
        .btn-home { background: var(--primary); color: white; padding: 12px 30px; border-radius: 30px; text-decoration: none; display: inline-block; transition: 0.3s; }
        .btn-home:hover { opacity: 0.9; transform: translateY(-2px); }
        .divider-text { position: relative; text-align: center; margin: 40px 0; border-bottom: 1px solid #ddd; }
        .divider-text span { position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: #f8f9fa; padding: 0 15px; color: #888; font-size: 0.8rem; font-weight: bold; }
        .warn-php { background: #fff3cd; color: #856404; padding: 15px; border-radius: 10px; font-size: 0.85rem; border: 1px solid #ffeeba; text-align: left; }
    </style>
</head>
<body>

<div class="main-container">
    <div class="card-success">
        <div class="icon-box"><i class="fa-solid fa-check"></i></div>
        <h1>¡Gracias por tu confianza!</h1>
        <p>Tu pago ha sido procesado correctamente. Orden <span id="display-order-id" style="font-weight:bold;">#000000</span></p>

        <div class="details-grid">
            <h4 style="margin-top:0; color:var(--primary);"><i class="fa-solid fa-receipt"></i> Resumen del Pedido</h4>
            <div id="resumen-lista"></div>
            <div class="product-row" style="border-top: 2px solid #eee; font-weight: bold; margin-top: 10px; padding-top: 15px;">
                <span>Total Pagado:</span>
                <span id="display-total" style="color:var(--success); font-size: 1.2rem;">$0.00</span>
            </div>
        </div>
        <a href="index.php" class="btn-home">Seguir Comprando</a>
    </div>

    <div class="divider-text"><span>ESTADO ACTUAL</span></div>
    <?php 
        $path1 = 'compra/comprasActuales.php';
        if(file_exists($path1)) {
            include $path1;
        } else {
            echo "<div class='warn-php'><i class='fa-solid fa-circle-exclamation'></i> No se encontró <b>$path1</b> en D:\XAMPP\htdocs\AccesoriosMaya\compra\</div>";
        }
    ?>

    <div class="divider-text"><span>HISTORIAL RECIENTE</span></div>
    <?php 
        $path2 = 'compra/historial.php';
        if(file_exists($path2)) {
            include $path2;
        } else {
            echo "<div class='warn-php'><i class='fa-solid fa-circle-exclamation'></i> No se encontró <b>$path2</b> en la carpeta compra.</div>";
        }
    ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Recuperar el respaldo del pedido guardado en authValidarPago.js
    const pedido = JSON.parse(localStorage.getItem('ultimoPedidoMaya')) || [];
    const contenedor = document.getElementById('resumen-lista');
    let totalAcumulado = 0;

    if (pedido.length > 0) {
        pedido.forEach(item => {
            const sub = item.precio * item.cantidad;
            totalAcumulado += sub;
            contenedor.innerHTML += `
                <div class="product-row">
                    <span>${item.nombre} (x${item.cantidad})</span>
                    <span>$${sub.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</span>
                </div>
            `;
        });
        document.getElementById('display-total').innerText = '$' + totalAcumulado.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    } else {
        contenedor.innerHTML = '<p style="color:#888;">No hay detalles disponibles del pedido.</p>';
    }
    
    // ID de orden aleatorio
    document.getElementById('display-order-id').innerText = '#' + Math.floor(Math.random()*900000+100000);
});
</script>
</body>
</html>