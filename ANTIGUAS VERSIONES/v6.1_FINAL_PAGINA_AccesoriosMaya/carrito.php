<?php
session_start();

// Simulación de productos en el carrito con rutas corregidas
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [
        [
            'id' => 1, 
            'nombre' => 'Torre Juguetero (Amarillo)', 
            'precio' => 850, 
            // Ruta actualizada a la carpeta específica de gatos
            'img' => 'productosGatos/producto1Amarillo.png', 
            'cant' => 2
        ],
        [
            'id' => 2, 
            'nombre' => 'Torre Juguetero (Azul)', 
            'precio' => 850, 
            // Ruta actualizada a la carpeta específica de gatos
            'img' => 'productosGatos/producto1Azul.png', 
            'cant' => 1
        ]
    ];
}

$total_final = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras - Accesorios Maya</title>
    
    <link rel="stylesheet" href="css/styless.css">
    <link rel="stylesheet" href="css/producto/producto.css">
    <link rel="stylesheet" href="css/validacion/validacion.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .cart-main-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }
        .cart-header {
            border-bottom: 2px solid #f1f1f1;
            padding-bottom: 15px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .cart-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #f9f9f9;
            transition: 0.3s;
        }
        .cart-item:hover { background: #fcfcfc; }
        .cart-item img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            background: #fdfdfd;
            border-radius: 10px;
            margin-right: 20px;
        }
        .item-details { flex-grow: 1; }
        .item-details h4 { margin: 0; font-family: 'Poppins'; color: #333; }
        .item-price { color: #2c656d; font-weight: bold; font-size: 1.1rem; }
        .cart-summary {
            margin-top: 30px;
            padding: 20px;
            background: #fdfdfd;
            border-radius: 10px;
            text-align: right;
        }
        .btn-buy {
            background: #2c656d;
            color: white;
            padding: 15px 50px;
            border: none;
            border-radius: 30px;
            font-family: 'Fredoka One';
            font-size: 1.3rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(44, 101, 109, 0.3);
        }
        .btn-buy:hover {
            background: #2c656d;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 145, 77, 0.4);
        }
    </style>
</head>
<body>

<header>
    <div style="text-align:center; padding: 20px;">
        <a href="index.php"><img src="img/logo.png" width="150" alt="Logo"></a>
    </div>
</header>

<main class="cart-main-container">
    <div class="cart-header">
        <h2 style="font-family: 'Fredoka One'; color: #2c656d; margin: 0;">Mi Carrito</h2>
        <span style="font-weight: 600; color: #666;">
            <?php echo count($_SESSION['carrito']); ?> artículos
        </span>
    </div>

    <div class="cart-items-list">
        <?php foreach ($_SESSION['carrito'] as $item): 
            $subtotal = $item['precio'] * $item['cant'];
            $total_final += $subtotal;
        ?>
        <div class="cart-item">
            <img src="img/<?php echo $item['img']; ?>" alt="<?php echo $item['nombre']; ?>">
            <div class="item-details">
                <h4><?php echo $item['nombre']; ?></h4>
                <p style="color: #888;">Cantidad: <strong><?php echo $item['cant']; ?></strong></p>
            </div>
            <div class="item-price">
                $<?php echo number_format($subtotal, 2); ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="cart-summary">
        <h3 style="font-family: 'Poppins'; color: #666; margin-bottom: 20px;">
            Total a pagar: <span style="color: #2c656d; font-size: 1.8rem;">$<?php echo number_format($total_final, 2); ?></span>
        </h3>
        
        <button onclick="iniciarFlujoPago()" class="btn-buy">
            <i class="fa-solid fa-bag-shopping"></i> COMPRAR AHORA
        </button>
    </div>
</main>

<footer style="text-align: center; padding: 40px; color: #999;">
    <p>© 2025 Accesorios Maya - Carrito de compras seguro</p>
</footer>

<script>
    // Guardamos el carrito en localStorage para que authValidarPago.js pueda leerlo
    const carritoParaJS = [
        <?php foreach($_SESSION['carrito'] as $item): ?>
        {
            nombre: '<?php echo $item['nombre']; ?>',
            precio: <?php echo $item['precio']; ?>,
            cantidad: <?php echo $item['cant']; ?>
        },
        <?php endforeach; ?>
    ];
    localStorage.setItem('carritoMaya', JSON.stringify(carritoParaJS));
</script>

<?php include 'compra/validacionCompra.php'; ?>

</body>
</html>