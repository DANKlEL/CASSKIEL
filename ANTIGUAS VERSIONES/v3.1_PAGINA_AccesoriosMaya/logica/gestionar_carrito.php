<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $accion = $_POST['accion'] ?? '';
    if (!isset($_SESSION['carrito'])) { $_SESSION['carrito'] = []; }

    switch ($accion) {
        case 'eliminar':
            foreach ($_SESSION['carrito'] as $i => $item) {
                if ($item['nombre'] === $nombre) { unset($_SESSION['carrito'][$i]); break; }
            }
            break;

        case 'sumar':
            foreach ($_SESSION['carrito'] as &$item) {
                if ($item['nombre'] === $nombre && $item['cant'] < 5) { $item['cant']++; break; }
            }
            break;

        case 'restar':
            foreach ($_SESSION['carrito'] as $i => &$item) {
                if ($item['nombre'] === $nombre) {
                    $item['cant']--;
                    if ($item['cant'] <= 0) { unset($_SESSION['carrito'][$i]); }
                    break;
                }
            }
            break;

        default: // Agregar desde catálogo o modal
            $precio = (float)($_POST['precio'] ?? 0);
            $img = $_POST['img'] ?? '';
            $cantidad = (int)($_POST['cantidad'] ?? 1);
            $sustituir = ($_POST['sustituir'] ?? '') === 'true';

            $encontrado = false;
            foreach ($_SESSION['carrito'] as &$item) {
                if ($item['nombre'] === $nombre) {
                    $item['cant'] = $sustituir ? $cantidad : min(5, $item['cant'] + $cantidad);
                    $encontrado = true; break;
                }
            }
            if (!$encontrado) {
                $_SESSION['carrito'][] = ['nombre' => $nombre, 'precio' => $precio, 'img' => $img, 'cant' => min(5, $cantidad)];
            }
            break;
    }

    $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar siempre
    
    $totalUnidades = 0;
    foreach ($_SESSION['carrito'] as $item) { $totalUnidades += $item['cant']; }
    echo json_encode(['status' => 'success', 'totalItems' => $totalUnidades]);
    exit;
}

// Para la consulta GET del modal
if (isset($_GET['consultar'])) {
    $nombre = $_GET['consultar'];
    $cant = 0;
    if (isset($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $item) {
            if ($item['nombre'] === $nombre) { $cant = $item['cant']; break; }
        }
    }
    echo json_encode(['cantidadActual' => $cant]);
    exit;
}