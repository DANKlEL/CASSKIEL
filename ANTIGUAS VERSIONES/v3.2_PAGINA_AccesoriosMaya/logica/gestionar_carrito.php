<?php
session_start();
if (!isset($_SESSION['carrito'])) { $_SESSION['carrito'] = []; }

$nombre = $_POST['nombre'] ?? '';
$precio = $_POST['precio'] ?? 0;
$img = $_POST['img'] ?? '';
$cantidad = intval($_POST['cantidad'] ?? 1);
$accion = $_POST['accion'] ?? '';
$sustituir = $_POST['sustituir'] ?? 'false';

// Eliminar
if ($accion === 'eliminar') {
    unset($_SESSION['carrito'][$nombre]);
} 
// Sumar/Restar desde mini-carrito
elseif ($accion === 'sumar' || $accion === 'restar') {
    if (isset($_SESSION['carrito'][$nombre])) {
        if ($accion === 'sumar') {
            $_SESSION['carrito'][$nombre]['cant'] = min(5, $_SESSION['carrito'][$nombre]['cant'] + 1);
        } else {
            $_SESSION['carrito'][$nombre]['cant'] -= 1;
            if ($_SESSION['carrito'][$nombre]['cant'] <= 0) unset($_SESSION['carrito'][$nombre]);
        }
    }
}
// Agregar/Sustituir desde modal
else {
    if (isset($_SESSION['carrito'][$nombre])) {
        if ($sustituir === 'true') {
            $_SESSION['carrito'][$nombre]['cant'] = $cantidad;
        } else {
            $_SESSION['carrito'][$nombre]['cant'] = min(5, $_SESSION['carrito'][$nombre]['cant'] + $cantidad);
        }
    } else {
        $_SESSION['carrito'][$nombre] = [
            'nombre' => $nombre,
            'precio' => $precio,
            'img' => $img,
            'cant' => $cantidad
        ];
    }
}

echo json_encode(['status' => 'ok']);