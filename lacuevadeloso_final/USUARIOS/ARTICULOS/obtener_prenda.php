<?php
header('Content-Type: application/json');
$conexion = new mysqli("localhost", "root", "danemi1612", "lacuevadeloso");

if ($conexion->connect_error) {
    die(json_encode(["error" => "Conexión fallida: " . $conexion->connect_error]));
}

// Filtros
$condiciones = [];

if (!empty($_GET['colores'])) {
    $colores = implode(",", array_map('intval', explode(",", $_GET['colores'])));
    $condiciones[] = "p.color_id IN ($colores)";
}

if (!empty($_GET['tipos'])) {
    $tipos = implode(",", array_map('intval', explode(",", $_GET['tipos'])));
    $condiciones[] = "p.tipo_prenda_id IN ($tipos)";
}

if (!empty($_GET['talla'])) {
    $talla = intval($_GET['talla']);
    $condiciones[] = "p.talla_id = $talla";
}

if (!empty($_GET['precioMin'])) {
    $precioMin = floatval($_GET['precioMin']);
    $condiciones[] = "p.precio_venta >= $precioMin";
}

if (!empty($_GET['precioMax'])) {
    $precioMax = floatval($_GET['precioMax']);
    $condiciones[] = "p.precio_venta <= $precioMax";
}

$where = "";
if (count($condiciones) > 0) {
    $where = "WHERE " . implode(" AND ", $condiciones);
}

// Consulta
$sql = "
SELECT p.id, p.nombre_prenda AS nombre, p.precio_venta AS precio, img.ruta_imagen AS imagen
FROM prendas p
LEFT JOIN imagenes_prenda img ON img.prenda_id = p.id AND img.tipo = 'principal'
$where
";

$result = $conexion->query($sql);
$prendas = [];

while ($row = $result->fetch_assoc()) {
    // Limpia y corrige la ruta a la imagen
    $imagen = $row["imagen"] ?: "img/placeholder.png";

    $prendas[] = [
        "id" => $row["id"],
        "nombre" => $row["nombre"],
        "precio" => number_format($row["precio"], 2),
        "imagen" => $imagen
    ];
}

echo json_encode($prendas);
$conexion->close();
?>
