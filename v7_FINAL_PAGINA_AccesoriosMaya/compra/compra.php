<?php 
session_start(); 
// Seguridad: Si no hay productos, redirigir al carrito para evitar pagos de $0
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    header("Location: ../carrito.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmar Pago - Accesorios Maya</title>
    <link rel="stylesheet" href="../css/styless.css">
    <link rel="stylesheet" href="../css/validacion/validacion.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body style="background-color: #f0f4f4;">

<div style="text-align:center; padding: 20px;">
    <a href="../index.php"><img src="../img/logo.png" width="120" alt="Logo"></a>
</div>

<div style="max-width: 600px; margin: 30px auto; text-align: center; background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
    <h2 style="font-family: 'Fredoka One'; color: #2c656d;">Resumen de Compra</h2>
    <p>Tienes <strong><?php echo count($_SESSION['carrito']); ?></strong> producto(s) listos para envío.</p>
    
    <div style="margin: 20px 0; border-top: 1px solid #eee; padding-top: 20px;">
        <button class="btn-save" onclick="iniciarFlujoPago()" style="padding: 20px 50px; font-size: 1.2rem; cursor: pointer; width: 100%;">
            <i class="fa-solid fa-credit-card"></i> PAGAR AHORA
        </button>
        <br><br>
        <a href="../carrito.php" style="color: #666; text-decoration: none; font-size: 0.9rem;"> <i class="fa-solid fa-arrow-left"></i> Modificar carrito</a>
    </div>
</div>

<?php include 'validacionCompra.php'; ?>

</body>
</html>