<?php
include 'config.php'; // conexión mysqli

$query = "SELECT p.id, p.nombre_prenda, p.costo_produccion, p.precio_venta, 
                tp.nombre AS tipo_nombre,
                c.nombre AS color_nombre,
                t.nombre AS talla_nombre,
                p.genero_id AS genero,
                col.coleccion_nombre
          FROM prendas p
          LEFT JOIN tipos_prenda tp ON p.tipo_prenda_id = tp.id
          LEFT JOIN colores c ON p.color_id = c.id
          LEFT JOIN tallas t ON p.talla_id = t.id
          LEFT JOIN colecciones col ON p.coleccion_id = col.id
          ORDER BY p.id DESC";

$result = $conexion->query($query);
$prendas = [];

while ($row = $result->fetch_assoc()) {
    $prendas[] = $row;
}

header('Content-Type: application/json');
echo json_encode($prendas);
$conexion->close();
?>
