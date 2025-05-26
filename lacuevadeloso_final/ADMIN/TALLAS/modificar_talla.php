<?php
include 'config.php';

$id = intval($_POST['id'] ?? 0);
$nombre = trim($_POST['nombre'] ?? '');

if ($id <= 0 || $nombre === '') {
    echo "error";
    exit;
}

// Verificar que no exista otra talla con ese nombre
$stmt = $conexion->prepare("SELECT id FROM tallas WHERE nombre = ? AND id != ?");
$stmt->bind_param("si", $nombre, $id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "error";
    $stmt->close();
    $conexion->close();
    exit;
}
$stmt->close();

// Actualizar talla
$stmt = $conexion->prepare("UPDATE tallas SET nombre = ? WHERE id = ?");
$stmt->bind_param("si", $nombre, $id);

echo $stmt->execute() ? "ok" : "error";
$stmt->close();
$conexion->close();
?>
