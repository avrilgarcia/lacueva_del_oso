<?php
include 'config.php';

$nombre = trim($_POST['color'] ?? '');

if ($nombre === '') {
    echo json_encode(["status" => "error", "msg" => "Nombre vacío"]);
    exit;
}

// Verificar que no exista la talla
$stmt = $conexion->prepare("SELECT id FROM tallas WHERE nombre = ?");
$stmt->bind_param("s", $nombre);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(["status" => "error", "msg" => "Talla ya existe"]);
    $stmt->close();
    $conexion->close();
    exit;
}

$stmt->close();

// Insertar nueva talla
$stmt = $conexion->prepare("INSERT INTO tallas (nombre) VALUES (?)");
$stmt->bind_param("s", $nombre);

if ($stmt->execute()) {
    echo json_encode(["status" => "ok", "id" => $stmt->insert_id]);
} else {
    echo json_encode(["status" => "error", "msg" => "Error al guardar"]);
}

$stmt->close();
$conexion->close();
?>
