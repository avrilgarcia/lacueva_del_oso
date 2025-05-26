<?php
header("Content-Type: application/json");
require_once "config.php";

// Activar errores
ini_set('display_errors', 1);
error_reporting(E_ALL);

$email = isset($_POST['email']) ? trim($_POST['email']) : '';

if (empty($email)) {
    echo json_encode(["status" => "error", "msg" => "Debes ingresar un correo."]);
    exit();
}

// Verificar si existe el usuario con ese correo
$stmt = $conexion->prepare("SELECT id FROM usuario WHERE email_usuario = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["status" => "error", "msg" => "El correo no está registrado."]);
    exit();
}

$usuario = $result->fetch_assoc();

// Generar contraseña temporal aleatoria
$nuevaContra = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10);
$nuevaContraHash = password_hash($nuevaContra, PASSWORD_DEFAULT);

// Actualizar contraseña en la base de datos
$update = $conexion->prepare("UPDATE usuario SET contra_usuario = ? WHERE id = ?");
$update->bind_param("si", $nuevaContraHash, $usuario['id']);
$update->execute();

// Simular envío de correo (aquí podrías usar PHPMailer o mail())
// mail($email, "Tu nueva contraseña", "Tu nueva contraseña temporal es: $nuevaContra");

echo json_encode([
    "status" => "success",
    "msg" => "Se ha generado una nueva contraseña temporal: $nuevaContra"
    // En producción no devuelvas la contraseña directamente.
]);

$stmt->close();
$update->close();
$conexion->close();
?>
