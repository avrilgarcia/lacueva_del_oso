<?php
include 'config.php';

$id = intval($_POST['id'] ?? 0);
$nombre = trim($_POST['nombre'] ?? '');

if ($id > 0 && $nombre !== '') {
    $stmt = $conexion->prepare("UPDATE colores SET nombre = ? WHERE id = ?");
    $stmt->bind_param("si", $nombre, $id);
    echo $stmt->execute() ? "ok" : "error";
    $stmt->close();
} else {
    echo "error";
}

$conexion->close();
?>
