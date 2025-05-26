<?php
header('Content-Type: application/json');
$conexion = new mysqli("localhost", "root", "danemi1612", "lacuevadeloso");
if ($conexion->connect_error) {
    die(json_encode(["error" => "Conexión fallida: " . $conexion->connect_error]));
}

$filtros = [
    "colores" => [],
    "tipos" => [],
    "tallas" => []
];


// Colores
$result = $conexion->query("SELECT id, nombre FROM colores");
while ($row = $result->fetch_assoc()) {
    $filtros["colores"][] = $row;
}


// Tipos de prenda
$result = $conexion->query("SELECT id, nombre FROM tipos_prenda");
while ($row = $result->fetch_assoc()) {
    $filtros["tipos"][] = $row;
}

// Tallas
$result = $conexion->query("SELECT id, nombre FROM tallas");
while ($row = $result->fetch_assoc()) {
    $filtros["tallas"][] = $row;
}

echo json_encode($filtros);
$conexion->close();
?>
