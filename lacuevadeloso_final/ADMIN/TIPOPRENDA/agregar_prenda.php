<?php
header('Content-Type: application/json');
include 'config.php';

$nombre = trim($_POST['nombre'] ?? '');
if ($nombre === '') {
    echo json_encode(["status" => "vacio", "msg" => "Nombre vacío"]);
    exit;
}

$stmt = $conexion->prepare("INSERT INTO tipos_prenda (nombre) VALUES (?)");
$stmt->bind_param("s", $nombre);

if ($stmt->execute()) {
    echo json_encode(["status" => "ok", "id" => $stmt->insert_id]);
} else {
    echo json_encode(["status" => "error", "msg" => $stmt->error]);
}

$stmt->close();
$conexion->close();
?>
