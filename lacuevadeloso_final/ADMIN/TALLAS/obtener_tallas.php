<?php
include 'config.php';

$result = $conexion->query("SELECT id, nombre FROM tallas ORDER BY id DESC");
$tallas = [];

while ($fila = $result->fetch_assoc()) {
    $tallas[] = $fila;
}

echo json_encode($tallas);
$conexion->close();
?>
