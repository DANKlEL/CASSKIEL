<?php
session_start();

if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $action = $_GET['action'];

    if (isset($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $key => $product) {
            if ($product['id'] == $id) {
                if ($action == 'incrementar') {
                    $_SESSION['carrito'][$key]['cant'] += 1;
                } 
                elseif ($action == 'decrementar') {
                    if ($_SESSION['carrito'][$key]['cant'] > 1) {
                        $_SESSION['carrito'][$key]['cant'] -= 1;
                    } else {
                        unset($_SESSION['carrito'][$key]);
                    }
                } 
                elseif ($action == 'eliminar') {
                    unset($_SESSION['carrito'][$key]);
                }
                break;
            }
        }
        $_SESSION['carrito'] = array_values($_SESSION['carrito']);
    }
}

// ESTA ES LA CLAVE: Limpiamos el localStorage mediante un pequeño script antes de redireccionar
echo "<script>
    localStorage.setItem('carritoMaya', '" . json_encode($_SESSION['carrito']) . "');
    window.location.href = 'carrito.php';
</script>";
exit();