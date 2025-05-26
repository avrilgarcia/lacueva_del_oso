<?php
session_start();
require 'config.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../ARTICULOS/mujer.html");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

// Obtener el último pedido realizado por el usuario
$stmt = $conn->prepare("SELECT id_pedido, fecha_pedido, total_pedido FROM pedido WHERE id_usuario = ? ORDER BY fecha_pedido DESC LIMIT 1");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $pedido = $result->fetch_assoc();
    $id_pedido = $pedido['id_pedido'];
    $fecha_pedido = $pedido['fecha_pedido'];
    $total_pedido = $pedido['total_pedido'];
} else {
    echo "No se encontró un pedido reciente.";
    exit;
}

$stmt->close();

// Obtener los detalles del pedido (artículos)
$stmt = $conn->prepare("SELECT dp.id_prenda, p.nombre_prenda, dp.cantidad, dp.precio_unitario FROM detalle_pedido dp JOIN prendas p ON dp.id_prenda = p.id WHERE dp.id_pedido = ?");
$stmt->bind_param("i", $id_pedido);
$stmt->execute();
$detalles = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Pedido</title>
    <!-- Vinculamos Bootstrap desde el CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos generales */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    width: 80%;
    margin: 0 auto;
    padding: 20px;
    background-color: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    margin-top: 50px;
}

h1 {
    text-align: center;
    color: #2c3e50;
    font-size: 32px;
}

h2, h3 {
    color: #34495e;
}

p {
    font-size: 18px;
    line-height: 1.6;
    color: #7f8c8d;
}

/* Estilo de la tabla */
table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
}

table, th, td {
    border: 1px solid #ecf0f1;
}

th, td {
    padding: 12px;
    text-align: left;
}

th {
    background-color: #2980b9;
    color: white;
}

td {
    background-color: #ecf0f1;
}

td:hover {
    background-color: #bdc3c7;
}

/* Estilo de botones y enlaces */
a {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #3498db;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    text-align: center;
}

a:hover {
    background-color: #2980b9;
}

/* Estilo para el contenedor de detalles */
.details {
    margin-top: 40px;
}

.details p {
    font-size: 20px;
    color: #2c3e50;
}

/* Responsividad */
@media (max-width: 768px) {
    .container {
        width: 90%;
    }

    table {
        font-size: 14px;
    }

    th, td {
        padding: 10px;
    }
}

    </style>
</head>
<body class="bg-light">
    <div class="container my-5 p-4 bg-white rounded shadow-sm">
        <h1 class="text-center text-primary mb-4">¡Gracias por tu compra!</h1>
        <p class="text-center text-muted mb-4">Tu pedido ha sido confirmado con éxito.</p>

        <div class="mb-4">
            <h2 class="h4 text-info">Detalles del Pedido</h2>
            <p><strong>Número de Pedido:</strong> <?php echo $id_pedido; ?></p>
            <p><strong>Fecha del Pedido:</strong> <?php echo $fecha_pedido; ?></p>
            <p><strong>Total del Pedido:</strong> $<?php echo number_format($total_pedido, 2); ?></p>
        </div>

        <h3 class="h5 text-info mb-3">Artículos del Pedido</h3>
        <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Prenda</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($detalle = $detalles->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $detalle['nombre_prenda']; ?></td>
                        <td><?php echo $detalle['cantidad']; ?></td>
                        <td>$<?php echo number_format($detalle['precio_unitario'], 2); ?></td>
                        <td>$<?php echo number_format($detalle['cantidad'] * $detalle['precio_unitario'], 2); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="text-center mt-4">
            <a href="../ARTICULOS/mujer.html" class="btn btn-primary">Volver a la tienda</a>
        </div>
    </div>

    <!-- Vinculamos los scripts de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

