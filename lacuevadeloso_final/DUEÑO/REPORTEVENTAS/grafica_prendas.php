<?php
$host = 'localhost';
$db = 'lacuevadeloso';
$user = 'root';
$pass = 'danemi1612';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

$fecha_inicio = $_GET['fecha_inicio'] ?? null;
$fecha_fin = $_GET['fecha_fin'] ?? null;

if (!$fecha_inicio || !$fecha_fin) {
    die("Faltan fechas.");
}

// Consulta para obtener las prendas más vendidas
$sql = "
    SELECT pr.nombre_prenda, SUM(dp.cantidad) AS total_vendido
    FROM detalle_pedido dp
    JOIN pedido p ON dp.id_pedido = p.id_pedido
    JOIN prendas pr ON dp.id_prenda = pr.id
    WHERE p.fecha_pedido BETWEEN :inicio AND :fin
    GROUP BY pr.nombre_prenda
    ORDER BY total_vendido DESC
    LIMIT 10
";
$stmt = $pdo->prepare($sql);
$stmt->execute(['inicio' => $fecha_inicio, 'fin' => $fecha_fin]);
$data = $stmt->fetchAll();

echo json_encode($data);
