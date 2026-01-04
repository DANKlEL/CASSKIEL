<?php
session_start();
header('Content-Type: application/json');

$items = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];
echo json_encode(['items' => array_values($items)]);