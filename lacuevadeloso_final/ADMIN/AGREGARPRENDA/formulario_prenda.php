<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "danemi1612", "lacuevadeloso");
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Obtener datos para los select
$colores = $conexion->query("SELECT id, nombre FROM colores");
$tallas = $conexion->query("SELECT id, nombre FROM tallas");
$generos = $conexion->query("SELECT id, genero FROM genero");
$colecciones = $conexion->query("SELECT id, coleccion_nombre FROM colecciones");
$tipos = $conexion->query("SELECT id, nombre FROM tipos_prenda");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Prenda</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
      background-color: #f8f9fa;
    }
    form {
      background: white;
      padding: 20px;
      border-radius: 10px;
      width: 400px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    label {
      display: block;
      margin-top: 10px;
    }
    input, select {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
    }
    input[type="submit"] {
      margin-top: 20px;
      background-color: #007bff;
      color: white;
      border: none;
      cursor: pointer;
    }
  </style>
</head>
<body>

<div class="header">
        <button class="btn btn-link p-0 me-2" style="font-size: 1.5rem; color: inherit;" 
                onclick="window.location.href='../PRODUCTOSENVENTA/productosventa.html'" title="Regresar">
          <i class="bi bi-arrow-left"></i>
        </button>

<form action="guardar_prenda.php" method="POST" enctype="multipart/form-data">
  <label>Nombre de la prenda:</label>
  <input type="text" name="nombre_prenda" required>

  <label>Costo de producción:</label>
  <input type="number" step="0.01" name="costo_produccion" required>

  <label>Precio de venta:</label>
  <input type="number" step="0.01" name="precio_venta" required>

  <label>Tipo de prenda:</label>
  <select name="tipo_prenda_id" required>
    <option value="">Selecciona...</option>
    <?php while($row = $tipos->fetch_assoc()): ?>
      <option value="<?= $row['id'] ?>"><?= $row['nombre'] ?></option>
    <?php endwhile; ?>
  </select>

  <label>Color:</label>
  <select name="color_id" required>
    <option value="">Selecciona...</option>
    <?php while($row = $colores->fetch_assoc()): ?>
      <option value="<?= $row['id'] ?>"><?= $row['nombre'] ?></option>
    <?php endwhile; ?>
  </select>

  <label>Talla:</label>
  <select name="talla_id" required>
    <option value="">Selecciona...</option>
    <?php while($row = $tallas->fetch_assoc()): ?>
      <option value="<?= $row['id'] ?>"><?= $row['nombre'] ?></option>
    <?php endwhile; ?>
  </select>

  <label>Género:</label>
  <select name="genero_id" required>
    <option value="">Selecciona...</option>
    <?php while($row = $generos->fetch_assoc()): ?>
      <option value="<?= $row['id'] ?>"><?= $row['genero'] ?></option>
    <?php endwhile; ?>
  </select>

  <label>Colección:</label>
  <select name="coleccion_id" required>
    <option value="">Selecciona...</option>
    <?php while($row = $colecciones->fetch_assoc()): ?>
      <option value="<?= $row['id'] ?>"><?= $row['coleccion_nombre'] ?></option>
    <?php endwhile; ?>
  </select>

  <label>Imagen principal:</label>
  <input type="file" name="imagen_principal" accept="image/*" required>

  <label>Imágenes complementarias:</label>
  <input type="file" name="imagenes_complementarias[]" multiple accept="image/*">

  <input type="submit" value="Guardar prenda">
</form>

</body>
</html>
