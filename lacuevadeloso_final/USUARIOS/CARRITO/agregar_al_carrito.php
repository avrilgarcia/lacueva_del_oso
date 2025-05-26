<?php
session_start();
require 'config.php';

if (!isset($_POST['id_prenda'])) {
    die("ID de prenda no especificado.");
}

$id_prenda = intval($_POST['id_prenda']);

$stmt = $conn->prepare("SELECT id, nombre_prenda, precio_venta FROM prendas WHERE id = ?");
$stmt->bind_param("i", $id_prenda);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Prenda no encontrada.");
}

$prenda = $result->fetch_assoc();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

if (isset($_SESSION['carrito'][$id_prenda])) {
    $_SESSION['carrito'][$id_prenda]['cantidad'] += 1;
} else {
    $_SESSION['carrito'][$id_prenda] = [
        'nombre' => $prenda['nombre_prenda'],
        'precio' => $prenda['precio_venta'],
        'cantidad' => 1
    ];
}

$stmt->close();
$conn->close();

// 🔁 Redirigir al carrito directamente
header("Location: ../CARRITO/carrito.php");
exit;
