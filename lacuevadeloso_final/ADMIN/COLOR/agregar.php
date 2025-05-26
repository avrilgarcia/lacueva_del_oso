<?php
// Ocultar advertencias al usuario
error_reporting(0);

// Establecer cabecera JSON clara
header('Content-Type: application/json');

include 'config.php';

// Obtener y validar el color
$color = trim($_POST['color'] ?? '');

if ($color === '') {
    echo json_encode(["status" => "vacio", "msg" => "Color vacío"]);
    exit;
}

// Preparar y ejecutar inserción
$stmt = $conexion->prepare("INSERT INTO colores (nombre) VALUES (?)");
$stmt->bind_param("s", $color);

if ($stmt->execute()) {
    echo json_encode(["status" => "ok", "id" => $stmt->insert_id]);
} else {
    echo json_encode(["status" => "error", "msg" => $stmt->error]);
}

$stmt->close();
$conexion->close();
?>
