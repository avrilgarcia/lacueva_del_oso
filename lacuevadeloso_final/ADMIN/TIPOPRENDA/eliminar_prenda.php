<?php
include 'config.php';

$id = intval($_POST['id'] ?? 0);
if ($id > 0) {
    $stmt = $conexion->prepare("DELETE FROM tipos_prenda WHERE id = ?");
    $stmt->bind_param("i", $id);
    echo $stmt->execute() ? "ok" : "error";
    $stmt->close();
} else {
    echo "error";
}

$conexion->close();
?>
