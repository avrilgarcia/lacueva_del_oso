<?php
// Siempre suprime advertencias con este encabezado
error_reporting(0);
header("Content-Type: text/plain");

include 'config.php';

$id = intval($_POST['id'] ?? 0);

if ($id > 0) {
    $stmt = $conexion->prepare("DELETE FROM tallas WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "ok";
    } else {
        echo "error";
    }

    $stmt->close();
} else {
    echo "error";
}

$conexion->close();
?>
