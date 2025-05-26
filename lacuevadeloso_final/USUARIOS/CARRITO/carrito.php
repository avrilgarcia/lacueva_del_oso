<?php
session_start();

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "danemi1612", "lacuevadeloso");
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<title>Carrito de Compras</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background: url('../img/LaCuevaDelOso.png') no-repeat center center fixed;
        background-size: cover;
        font-family: Arial, sans-serif;
        color: #333;
    }
    .carrito-container {
        background-color: rgba(255, 255, 255, 0.95);
        border-radius: 10px;
        padding: 30px;
        margin: 40px auto;
        width: 90%;
        max-width: 1000px;
    }
    .carrito-item {
        border-bottom: 1px solid #ccc;
        padding: 15px 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: transparent;
    }
    .carrito-img {
        width: 80px;
        height: auto;
        border-radius: 8px;
        border: 1px solid #ccc;
    }
    .btn-custom {
        background-color: #4b7c72;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
    }
    .btn-custom:hover {
        background-color: #3d655d;
    }
    .total-box {
        background-color: #e0ece9;
        padding: 20px;
        border-radius: 10px;
        margin-top: 20px;
    }
</style>
</head>
<body>

<div class="container carrito-container">

    <h1 class="mb-4">Mi carrito</h1>

    <?php if (empty($_SESSION['carrito'])): ?>
        <p>Tu carrito está vacío.</p>
        <a href="../ARTICULOS/mujer.html" class="btn btn-custom mt-3">Ver prendas para agregar</a>
    <?php else: ?>

        <?php
        $total = 0;
        $total_items = 0;

        foreach ($_SESSION['carrito'] as $id => $item):
            $id_prenda = intval($id);
            $img_query = "SELECT ruta_imagen FROM imagenes_prenda WHERE prenda_id = $id_prenda AND tipo = 'principal' LIMIT 1";
            $img_result = $conexion->query($img_query);
            $ruta_imagen = 'IMG_PRENDAS/default.png';

            if ($img_result && $img_result->num_rows > 0) {
                $img_data = $img_result->fetch_assoc();
                $ruta_imagen = $img_data['ruta_imagen'];
            }

            $subtotal = $item['precio'] * $item['cantidad'];
            $total += $subtotal;
            $total_items += $item['cantidad'];
        ?>

        <div class="carrito-item row align-items-center">
            <div class="col-md-2">
                <img src="<?= htmlspecialchars($ruta_imagen) ?>" alt="<?= htmlspecialchars($item['nombre']) ?>" class="carrito-img">
            </div>
            <div class="col-md-6">
                <h5><?= htmlspecialchars($item['nombre']) ?></h5>
                <p class="mb-0">Precio: $<?= number_format($item['precio'], 2) ?> MXN</p>
                <p class="mb-0">Cantidad: <?= $item['cantidad'] ?></p>
                <p class="mb-0">Subtotal: $<?= number_format($subtotal, 2) ?> MXN</p>
            </div>
            <div class="col-md-4 text-end">
                <form method="get" action="eliminar_del_carrito.php" onsubmit="return confirm('¿Eliminar esta prenda del carrito?');">
                    <input type="hidden" name="id_prenda" value="<?= $id ?>">
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>

        <?php endforeach; ?>

        <div class="total-box mt-4">
            <h4>Total: $<?= number_format($total, 2) ?> MXN</h4>
            <p>Total de artículos: <?= $total_items ?></p>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="../ARTICULOS/mujer.html" class="btn btn-custom">Seguir agregando prendas</a>
            <form method="post" action="seleccionar_pago.php">
                <button type="submit" class="btn btn-success">Continuar con el pago</button>
            </form>
        </div>

    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
