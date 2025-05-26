<?php
$host = "localhost";
$usuario = "root";
$contrasena = "danemi1612";
$basedatos = "lacuevadeloso";

$conexion = new mysqli($host, $usuario, $contrasena, $basedatos);

if ($conexion->connect_error) {
    // Esto no debe salir en producción, solo para debug
    die(json_encode(["status" => "error", "msg" => "Conexión fallida: " . $conexion->connect_error]));
}
?>
