<?php
session_start();  // Iniciar sesión para guardar variables

header("Content-Type: application/json");
require_once "config.php";

// Activar errores para desarrollo
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Obtener datos
$email = trim($_POST['email']);
$password = trim($_POST['password']);

if (empty($email) || empty($password)) {
    echo json_encode(["status" => "error", "msg" => "Email y contraseña son obligatorios."]);
    exit();
}

// Buscar usuario por email
$stmt = $conexion->prepare("SELECT u.id, u.nombre_usuario, u.contra_usuario, r.nombre AS rol 
                            FROM usuario u
                            JOIN roles r ON u.rolusuario_id = r.id
                            WHERE u.email_usuario = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["status" => "error", "msg" => "Usuario no encontrado."]);
    exit();
}

$usuario = $result->fetch_assoc();

// Verificar la contraseña
if (!password_verify($password, $usuario['contra_usuario'])) {
    echo json_encode(["status" => "error", "msg" => "Contraseña incorrecta."]);
    exit();
}

// Guardar id_usuario y rol en sesión para usar después
$_SESSION['id_usuario'] = $usuario['id'];
$_SESSION['rol'] = strtolower($usuario['rol']);

// Responder con éxito y rol para redireccionar en JS
$respuesta = [
    "status" => "success",
    "msg" => "Inicio de sesión exitoso.",
    "rol" => strtolower($usuario['rol']) // ej: "admin" o "usuario"
];

echo json_encode($respuesta);
$stmt->close();
$conexion->close();
?>
