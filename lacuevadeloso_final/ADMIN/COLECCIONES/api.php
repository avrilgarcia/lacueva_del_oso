<?php
include 'config.php';

header("Content-Type: application/json");
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $result = $conexion->query("SELECT * FROM colecciones");
        $colecciones = [];
        while ($row = $result->fetch_assoc()) {
            $colecciones[] = $row;
        }
        echo json_encode($colecciones);
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        $nombre = $conexion->real_escape_string($data['coleccion_nombre']);
        $conexion->query("INSERT INTO colecciones (coleccion_nombre) VALUES ('$nombre')");
        echo json_encode(["success" => true]);
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        $id = (int)$data['id'];
        $nombre = $conexion->real_escape_string($data['coleccion_nombre']);
        $conexion->query("UPDATE colecciones SET coleccion_nombre='$nombre' WHERE id=$id");
        echo json_encode(["success" => true]);
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $data);
        $id = (int)$data['id'];
        $conexion->query("DELETE FROM colecciones WHERE id=$id");
        echo json_encode(["success" => true]);
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido"]);
        break;
}
?>
