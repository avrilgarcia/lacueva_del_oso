<?php
header('Content-Type: application/json');
$input = json_decode(file_get_contents("php://input"), true);

$inicio = $input['fechaInicio'];
$fin = $input['fechaFin'];

$conexion = new mysqli("localhost", "root", "danemi1612", "lacuevadeloso");
if ($conexion->connect_error) {
    die(json_encode(["error" => "Error de conexión"]));
}

// GANANCIA TOTAL
$sql = "
SELECT SUM((p.precio_venta - p.costo_produccion) * dp.cantidad) AS ganancia
FROM pedido pe
JOIN detalle_pedido dp ON pe.id_pedido = dp.id_pedido
JOIN prendas p ON dp.id_prenda = p.id
WHERE pe.fecha_pedido BETWEEN ? AND ?
";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ss", $inicio, $fin);
$stmt->execute();
$stmt->bind_result($ganancia_total);
$stmt->fetch();
$stmt->close();

// MÁS VENDIDO POR CATEGORÍAS
function masVendido($conexion, $columna, $tabla_join, $campo_texto, $inicio, $fin) {
    $sql = "
    SELECT $campo_texto, COUNT(*) as cantidad
    FROM pedido pe
    JOIN detalle_pedido dp ON pe.id_pedido = dp.id_pedido
    JOIN prendas pr ON dp.id_prenda = pr.id
    JOIN $tabla_join t ON pr.$columna = t.id
    WHERE pe.fecha_pedido BETWEEN ? AND ?
    GROUP BY t.id
    ORDER BY cantidad DESC LIMIT 1";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $inicio, $fin);
    $stmt->execute();
    $stmt->bind_result($valor, $cantidad);
    $stmt->fetch();
    $stmt->close();
    return $valor ?: "-";
}

$genero = masVendido($conexion, "genero_id", "genero", "genero", $inicio, $fin);
$tipo = masVendido($conexion, "tipo_prenda_id", "tipos_prenda", "nombre", $inicio, $fin);
$talla = masVendido($conexion, "talla_id", "tallas", "nombre", $inicio, $fin);
$color = masVendido($conexion, "color_id", "colores", "nombre", $inicio, $fin);

// GANANCIA POR DÍA
$sql = "
SELECT DATE(fecha_pedido) AS fecha, 
SUM((p.precio_venta - p.costo_produccion) * dp.cantidad) AS ganancia
FROM pedido pe
JOIN detalle_pedido dp ON pe.id_pedido = dp.id_pedido
JOIN prendas p ON dp.id_prenda = p.id
WHERE pe.fecha_pedido BETWEEN ? AND ?
GROUP BY DATE(fecha_pedido)
ORDER BY fecha
";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ss", $inicio, $fin);
$stmt->execute();
$resultado = $stmt->get_result();

$fechas = [];
$ganancias = [];
while ($fila = $resultado->fetch_assoc()) {
    $fechas[] = $fila['fecha'];
    $ganancias[] = round($fila['ganancia'], 2);
}

echo json_encode([
    "ganancia_total" => number_format($ganancia_total, 2),
    "genero" => $genero,
    "tipo_prenda" => $tipo,
    "talla" => $talla,
    "color" => $color,
    "fechas" => $fechas,
    "ganancias_dia" => $ganancias
]);
?>
