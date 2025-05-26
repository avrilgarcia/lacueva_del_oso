<?php
header("Content-Type: application/json");
require_once "config.php"; // Incluye tu archivo de configuración

// Obtener y sanitizar los datos del formulario
$usuario = trim($_POST['usuario']);
$password = trim($_POST['password']);
$email = trim($_POST['email']);
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$rol = intval($_POST['rol']);

// Validar campos requeridos
if (empty($usuario) || empty($password) || empty($email) || empty($fecha_nacimiento) || empty($rol)) {
    echo json_encode(["status" => "error", "msg" => "Todos los campos son obligatorios."]);
    exit();
}

// Encriptar la contraseña (opcional pero recomendable)
$password_encriptada = password_hash($password, PASSWORD_BCRYPT);

// Preparar y ejecutar la inserción
$stmt = $conexion->prepare("INSERT INTO usuario (nombre_usuario, contra_usuario, email_usuario, nacimiento_usuario, rolusuario_id) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssssi", $usuario, $password_encriptada, $email, $fecha_nacimiento, $rol);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "msg" => "Usuario registrado exitosamente."]);
} else {
    echo json_encode(["status" => "error", "msg" => "Error al registrar el usuario: " . $conexion->error]);
}

$stmt->close();
$conexion->close();
?>
