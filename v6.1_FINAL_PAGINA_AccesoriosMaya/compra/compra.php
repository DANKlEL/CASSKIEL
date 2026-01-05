<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Pedidos - Accesorios Maya</title>
    <link rel="stylesheet" href="../css/styless.css">
    <link rel="stylesheet" href="../css/validacion/validacion.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div style="max-width: 1000px; margin: 50px auto; text-align: center;">
    <button class="btn-save" onclick="iniciarFlujoPago()" style="padding: 20px 50px; font-size: 1.2rem;">
        <i class="fa-solid fa-cart-shopping"></i> PAGAR AHORA
    </button>
</div>

<?php include 'validacionCompra.php'; ?>

</body>
</html>