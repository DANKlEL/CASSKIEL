<?php
// compra/compra.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Pedidos - Accesorios Maya</title>
    <link rel="stylesheet" href="../css/styless.css">
    <link rel="stylesheet" href="../css/producto/producto.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        .tabs-container { display: flex; justify-content: center; margin: 20px 0; gap: 10px; }
        .tab-btn { padding: 10px 25px; border: none; border-radius: 20px; cursor: pointer; background: #eee; font-family: 'Poppins'; transition: 0.3s; }
        .tab-btn.active { background: #ff914d; color: white; font-weight: bold; }
        .content-section { padding: 20px; max-width: 1000px; margin: 0 auto; }
    </style>
</head>
<body>

<header>
    <div style="text-align:center; padding: 20px;">
        <a href="../index.html"><img src="../img/logo.png" width="150" alt="Logo"></a>
    </div>
</header>

<div class="tabs-container">
    <a href="?tab=actuales"><button class="tab-btn <?php echo (!isset($_GET['tab']) || $_GET['tab'] == 'actuales') ? 'active' : ''; ?>">Compras Actuales</button></a>
    <a href="?tab=historial"><button class="tab-btn <?php echo (isset($_GET['tab']) && $_GET['tab'] == 'historial') ? 'active' : ''; ?>">Historial de Compras</button></a>
</div>

<main class="content-section">
    <?php
    $tab = $_GET['tab'] ?? 'actuales';

    if ($tab == 'actuales') {
        include 'comprasActuales.php';
    } elseif ($tab == 'historial') {
        include 'historial.php';
    }
    ?>
</main>

</body>
</html>