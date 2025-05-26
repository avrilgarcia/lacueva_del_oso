<?php
// Configuración de conexión
$host = 'localhost';
$db = 'lacuevadeloso';
$user = 'root';
$pass = 'danemi1612';

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno) {
    die("Error de conexión: " . $mysqli->connect_error);
}

if (!isset($_GET['id']) && !isset($_POST['id'])) {
    die("ID de prenda no especificado.");
}

$id = isset($_GET['id']) ? intval($_GET['id']) : intval($_POST['id']);

// Si se envió el formulario (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_prenda = $mysqli->real_escape_string($_POST['nombre_prenda']);
    $costo_produccion = floatval($_POST['costo_produccion']);
    $precio_venta = floatval($_POST['precio_venta']);
    $tipo_prenda_id = intval($_POST['tipo_prenda_id']);
    $color_id = intval($_POST['color_id']);
    $talla_id = intval($_POST['talla_id']);
    $genero_id = intval($_POST['genero_id']);
    $coleccion_id = intval($_POST['coleccion_id']);

    $sql_update = "UPDATE prendas SET
    nombre_prenda = '$nombre_prenda',
    costo_produccion = $costo_produccion,
    precio_venta = $precio_venta,
    tipo_prenda_id = $tipo_prenda_id,
    color_id = $color_id,
    talla_id = $talla_id,
    genero_id = $genero_id,
    coleccion_id = $coleccion_id
    WHERE id = $id";


    if ($mysqli->query($sql_update)) {
    echo "<p>Prenda actualizada correctamente. Redirigiendo al listado...</p>";
    echo "<script>
            setTimeout(function() {
                window.location.href = '/ADMIN/PRODUCTOSENVENTA/productosventa.html';
            }, 2000);
          </script>";
    exit;
}

}

// Obtener datos actuales de la prenda
$result = $mysqli->query("SELECT * FROM prendas WHERE id = $id LIMIT 1");
if ($result->num_rows === 0) {
    die("Prenda no encontrada.");
}
$prenda = $result->fetch_assoc();

// Puedes obtener listas para tipos, colores, tallas y colecciones para hacer selects si lo deseas
$tipos = $mysqli->query("SELECT id, nombre FROM tipos_prenda")->fetch_all(MYSQLI_ASSOC);
$colores = $mysqli->query("SELECT id, nombre FROM colores")->fetch_all(MYSQLI_ASSOC);
$tallas = $mysqli->query("SELECT id, nombre FROM tallas")->fetch_all(MYSQLI_ASSOC);
$colecciones = $mysqli->query("SELECT id, coleccion_nombre FROM colecciones")->fetch_all(MYSQLI_ASSOC);
$generos = $mysqli->query("SELECT id, genero FROM genero")->fetch_all(MYSQLI_ASSOC);


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Prenda</title>
</head>
<body>
    <h1>Editar Prenda</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $prenda['id']; ?>">

        <label>Nombre Prenda:
            <input type="text" name="nombre_prenda" required value="<?php echo htmlspecialchars($prenda['nombre_prenda']); ?>">
        </label><br><br>

        <label>Costo Producción:
            <input type="number" step="0.01" name="costo_produccion" required value="<?php echo $prenda['costo_produccion']; ?>">
        </label><br><br>

        <label>Precio Venta:
            <input type="number" step="0.01" name="precio_venta" required value="<?php echo $prenda['precio_venta']; ?>">
        </label><br><br>

        <label>Tipo Prenda:
            <select name="tipo_prenda_id" required>
                <?php foreach ($tipos as $tipo): ?>
                    <option value="<?php echo $tipo['id']; ?>" <?php if ($tipo['id'] == $prenda['tipo_prenda_id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($tipo['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label><br><br>

        <label>Color:
            <select name="color_id" required>
                <?php foreach ($colores as $color): ?>
                    <option value="<?php echo $color['id']; ?>" <?php if ($color['id'] == $prenda['color_id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($color['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label><br><br>

        <label>Talla:
            <select name="talla_id" required>
                <?php foreach ($tallas as $talla): ?>
                    <option value="<?php echo $talla['id']; ?>" <?php if ($talla['id'] == $prenda['talla_id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($talla['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label><br><br>

        <label>Género:
    <select name="genero_id" required>
        <?php foreach ($generos as $genero): ?>
            <option value="<?= $genero['id'] ?>" <?= ($genero['id'] == $prenda['genero_id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($genero['genero']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</label><br><br>

        <label>Colección:
            <select name="coleccion_id" required>
                <?php foreach ($colecciones as $coleccion): ?>
                    <option value="<?php echo $coleccion['id']; ?>" <?php if ($coleccion['id'] == $prenda['coleccion_id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($coleccion['coleccion_nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label><br><br>

        <button type="submit">Guardar Cambios</button>
        <button type="button" onclick="history.back()">Cancelar</button>
    </form>
</body>
</html>
