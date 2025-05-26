<?php
$conexion = new mysqli("localhost", "root", "danemi1612", "lacuevadeloso");
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}



if (!isset($_GET['id'])) {
    die("ID de producto no especificado.");
}
$id_prenda = intval($_GET['id']);

$query_prenda = "SELECT id, nombre_prenda, precio_venta FROM prendas WHERE id = $id_prenda";
$result_prenda = $conexion->query($query_prenda);

if ($result_prenda->num_rows === 0) {
    die("Producto no encontrado.");
}

$prenda = $result_prenda->fetch_assoc();

$query_imagenes = "SELECT ruta_imagen, tipo FROM imagenes_prenda WHERE prenda_id = $id_prenda";
$result_imagenes = $conexion->query($query_imagenes);

$imagen_principal = '';
$imagenes_complementarias = [];

while ($imagen = $result_imagenes->fetch_assoc()) {
    if ($imagen['tipo'] == 'principal') {
        $imagen_principal = $imagen['ruta_imagen'];
    } else {
        $imagenes_complementarias[] = $imagen['ruta_imagen'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($prenda['nombre_prenda']) ?></title>
    <link rel="stylesheet" href="producto.css">
    <style>
        body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #f0f2f5;
    margin: 0;
    padding: 0;
    background: url('../img/LaCuevaDelOso.png') no-repeat center center/cover;
}

.top-bar {
    background-color: #578e7e;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 30px;
    box-shadow: 0 0 8px rgba(0,0,0,0.2);
}

.logo img {
    height: 50px;
}

.icons img {
    height: 24px;
    margin-left: 20px;
    cursor: pointer;
}

.producto-container {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 40px;
    background-color: #fff;
    margin: 40px auto;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
    max-width: 1200px;
    background-color: transparent;
}

.imagenes-miniaturas {
    display: flex;
    flex-direction: column;
    gap: 12px;
  
}

.imagenes-miniaturas img {
    width: 80px;
    border: 2px solid #ccc;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.3s;
    background-color: white;
}

.imagenes-miniaturas img:hover {
    border-color: #2ecc71;
}

.imagen-principal {
    flex-shrink: 0;
}

.imagen-principal img {
    width: 400px;
    height: auto;
    object-fit: cover;
    border-radius: 12px;
    border: 2px solid #ccc;
}

.info-producto {
    display: flex;
    flex-direction: column;
    justify-content: center;
    max-width: 400px;
}

.info-producto h1 {
    margin-bottom: 10px;
}

.precio {
    font-size: 24px;
    color: #27ae60;
    font-weight: bold;
    margin-bottom: 20px;
}

.boton-carrito {
    padding: 12px 24px;
    background-color: #2ecc71;
    border: none;
    color: white;
    font-weight: bold;
    font-size: 16px;
    cursor: pointer;
    border-radius: 8px;
    transition: background-color 0.3s;
}

.boton-carrito:hover {
    background-color: #27ae60;
}

@media (max-width: 992px) {
    .producto-container {
        flex-direction: column;
        align-items: center;
    }

    .imagenes-miniaturas {
        flex-direction: row;
        justify-content: center;
        margin-bottom: 20px;
    }

    .imagen-principal img {
        width: 90vw;
        max-width: 400px;
    }

    .info-producto {
        align-items: center;
        text-align: center;
        background-color: #578e7e;
    }
    
}

.prendas{
    color: black;
}

.prendas:hover{
     transform: scale(1.10); 
}

    </style>
    <script>
        function cambiarImagenPrincipal(src) {
            document.getElementById('imgPrincipal').src = src;
        }
    </script>
</head>
<body>

<div class="top-bar">
    <div class="logo">
        <img src="img/LOGOSO.png" alt="Logo Oso">
    </div>
<a  class="prendas"  href="../ARTICULOS/mujer.html">PRENDAS</a>

    <div class="icons">
        <img src="img/cart-shopping-solid.svg" alt="Carrito">
        <img src="img/heart-solid.svg" alt="Favoritos">
        <img src="img/LOGOUSUARIO.png" alt="Usuario">
    </div>
</div>

<div class="wrapper">
    <div class="producto-container">
        <div class="imagenes-miniaturas">
            <?php foreach ($imagenes_complementarias as $img): ?>
                <img src="<?= htmlspecialchars($img) ?>" onclick="cambiarImagenPrincipal('<?= htmlspecialchars($img) ?>')" alt="Vista adicional">
            <?php endforeach; ?>
        </div>

        <div class="imagen-principal">
            <img id="imgPrincipal" src="<?= htmlspecialchars($imagen_principal) ?>" alt="Imagen principal">
        </div>

        <div class="info-producto">
    <h1><?= htmlspecialchars($prenda['nombre_prenda']) ?></h1>
    <div class="precio">$<?= number_format($prenda['precio_venta'], 2) ?> MXN</div>
<form method="post" action="../CARRITO/agregar_al_carrito.php">
    <input type="hidden" name="id_prenda" value="<?= $prenda['id'] ?>">
    <input type="hidden" name="redirect" value="../CARRITO/carrito.php">
    <button type="submit" class="boton-carrito">Añadir al carrito</button>
</form>





</div>

    </div>
</div>

</body>
</html>
