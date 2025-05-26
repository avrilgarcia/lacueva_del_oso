<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "DELETE FROM prendas WHERE id = $id";
    if ($conexion->query($query)) {
        echo "Prenda eliminada correctamente.";
    } else {
        echo "Error al eliminar la prenda.";
    }
} else {
    echo "ID no proporcionado.";
}
$conexion->close();
?>
