<?php
$host = "localhost";
$usuario = "root";
$contrasena = "danemi1612";
$basedatos = "lacuevadeloso";

$conexion = new mysqli($host, $usuario, $contrasena, $basedatos);

if ($conexion->connect_error) {
    echo json_encode(["status" => "error", "msg" => "Conexión fallida"]);
    exit;
}

?>
