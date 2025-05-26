<?php
include 'config.php';
file_put_contents("debug_eliminar.txt", print_r($_POST, true));

$id = intval($_POST['id'] ?? 0);
if ($id > 0) {
    $stmt = $conexion->prepare("DELETE FROM colores WHERE id = ?");
    $stmt->bind_param("i", $id);
    echo $stmt->execute() ? "ok" : "error";
    $stmt->close();
} else {
    echo "error";
}

$conexion->close();
?>
