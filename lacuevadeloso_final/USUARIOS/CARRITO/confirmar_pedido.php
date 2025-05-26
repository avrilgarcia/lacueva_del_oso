<?php
session_start();
require 'config.php';

if (!isset($_SESSION['id_usuario']) || empty($_SESSION['carrito'])) {
    header("Location: ../ARTICULOS/mujer.html");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$carrito = $_SESSION['carrito'];

// Datos del formulario
$id_medio_pago = intval($_POST['id_medio_pago']);
$direccion = trim($_POST['direccion']);
$especificaciones = trim($_POST['especificaciones'] ?? '');

// 1. Guardar dirección
$stmt = $conn->prepare("INSERT INTO direccion_envio (id_usuario, direccion, especificaciones) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $id_usuario, $direccion, $especificaciones);
$stmt->execute();
$id_direccion = $stmt->insert_id;
$stmt->close();

// 2. Calcular el total del pedido
$total_pedido = 0;
foreach ($carrito as $id_prenda => $item) {
    $cantidad = $item['cantidad'];
    $precio_unitario = $item['precio'];
    $total_pedido += $cantidad * $precio_unitario;
}

// 3. Insertar pedido
$fecha = date('Y-m-d H:i:s');
$stmt = $conn->prepare("INSERT INTO pedido (id_usuario, id_direccion, id_medio_pago, fecha_pedido, total_pedido) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iiisd", $id_usuario, $id_direccion, $id_medio_pago, $fecha, $total_pedido);
$stmt->execute();
$id_pedido = $stmt->insert_id;
$stmt->close();

// 4. Insertar detalles del pedido
$stmt = $conn->prepare("INSERT INTO detalle_pedido (id_pedido, id_prenda, cantidad, precio_unitario) VALUES (?, ?, ?, ?)");
foreach ($carrito as $id_prenda => $item) {
    $cantidad = $item['cantidad'];
    $precio_unitario = $item['precio'];
    $stmt->bind_param("iiid", $id_pedido, $id_prenda, $cantidad, $precio_unitario);
    $stmt->execute();
}
$stmt->close();

// 5. Limpiar carrito
unset($_SESSION['carrito']);

// 6. Redirigir a página de confirmación
header("Location: pedido_confirmado.php");
exit;
?>
