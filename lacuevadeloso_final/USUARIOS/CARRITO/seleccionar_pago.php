<?php
session_start();
require 'config.php';

if (!isset($_SESSION['id_usuario']) || empty($_SESSION['carrito'])) {
    header("Location: ../ARTICULOS/mujer.html");
    exit;
}

// Obtener medios de pago desde la base de datos
$medios = $conn->query("SELECT id_medio_pago, descripcion FROM medio_pago");

// Obtener datos del carrito
$carrito = $_SESSION['carrito'];
$total = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Selección de método de pago</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('../img/LaCuevaDelOso.png') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
        }
        .contenedor {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 30px;
            margin: 50px auto;
            max-width: 1100px;
        }
        .item-carrito img {
            width: 70px;
            border-radius: 10px;
        }
        .btn-custom {
            background-color: #4b7c72;
            color: white;
        }
        .btn-custom:hover {
            background-color: #3d655d;
        }
        .seccion {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<div class="container contenedor">
    <div class="row">
        <div class="col-md-7 seccion">
            <h3>Artículos seleccionados</h3>
            <ul class="list-group mb-3">
                <?php foreach ($carrito as $id => $item): 
                    $subtotal = $item['precio'] * $item['cantidad'];
                    $total += $subtotal;
                    // Imagen
                    $id_prenda = intval($id);
                    $img_query = $conn->query("SELECT ruta_imagen FROM imagenes_prenda WHERE prenda_id = $id_prenda AND tipo = 'principal' LIMIT 1");
                    $ruta_imagen = "IMG_PRENDAS/default.png";
                    if ($img_query && $img_query->num_rows > 0) {
                        $img_data = $img_query->fetch_assoc();
                        $ruta_imagen = $img_data['ruta_imagen'];
                    }
                ?>
                <li class="list-group-item d-flex justify-content-between align-items-center item-carrito">
                    <img src="<?= htmlspecialchars($ruta_imagen) ?>" alt="<?= htmlspecialchars($item['nombre']) ?>">
                    <div>
                        <strong><?= htmlspecialchars($item['nombre']) ?></strong><br>
                        Cantidad: <?= $item['cantidad'] ?>
                    </div>
                    <span>$<?= number_format($subtotal, 2) ?> MXN</span>
                </li>
                <?php endforeach; ?>
            </ul>
            <h4>Total: $<?= number_format($total, 2) ?> MXN</h4>
        </div>

        <div class="col-md-5 seccion">
            <h3>Ventana de pago</h3>
            <form action="confirmar_pedido.php" method="post">
                <div class="mb-3">
                    <label for="metodo" class="form-label">Método de pago</label>
                    <select class="form-select" id="metodo" name="id_medio_pago" required>
                        <?php while($row = $medios->fetch_assoc()): ?>
                            <option value="<?= $row['id_medio_pago'] ?>"><?= htmlspecialchars($row['descripcion']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección de entrega</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" required>
                </div>
                <div class="mb-3">
                    <label for="especificaciones" class="form-label">Especificaciones</label>
                    <textarea class="form-control" id="especificaciones" name="especificaciones" rows="2"></textarea>
                </div>
                <button type="submit" class="btn btn-custom w-100">Confirmar pedido</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
