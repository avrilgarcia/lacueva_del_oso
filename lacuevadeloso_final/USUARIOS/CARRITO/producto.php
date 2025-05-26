<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "danemi1612", "lacuevadeloso");
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

include 'detalle.php'; 




