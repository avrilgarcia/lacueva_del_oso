<?php
$conexion = new mysqli("localhost", "root", "danemi1612", "lacuevadeloso");
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$nombre = $_POST['nombre_prenda'];
$costo = $_POST['costo_produccion'];
$precio = $_POST['precio_venta'];
$tipo_id = $_POST['tipo_prenda_id'];
$color_id = $_POST['color_id'];
$talla_id = $_POST['talla_id'];
$genero_id = $_POST['genero_id'];
$coleccion_id = $_POST['coleccion_id'];

$query = "INSERT INTO prendas (nombre_prenda, costo_produccion, precio_venta, tipo_prenda_id, color_id, talla_id, genero_id, coleccion_id) 
          VALUES ('$nombre', '$costo', '$precio', '$tipo_id', '$color_id', '$talla_id', '$genero_id', '$coleccion_id')";
$conexion->query($query);
$id_prenda = $conexion->insert_id;

$directorioSistema = "../IMG_PRENDAS/";
$directorioWeb = "IMG_PRENDAS/";

if (!is_dir($directorioSistema)) {
    mkdir($directorioSistema, 0777, true);
}

// Imagen principal (sin hash)
if ($_FILES["imagen_principal"]["error"] == 0) {
    $nombreArchivo = basename($_FILES["imagen_principal"]["name"]);
    $rutaSistema = $directorioSistema . $nombreArchivo;
    $rutaWeb = $directorioWeb . $nombreArchivo;

    if (move_uploaded_file($_FILES["imagen_principal"]["tmp_name"], $rutaSistema)) {
        $conexion->query("INSERT INTO imagenes_prenda (prenda_id, ruta_imagen, tipo) VALUES ('$id_prenda', '$rutaWeb', 'principal')");
    } else {
        echo "❌ Error al subir la imagen principal.";
    }
}

// Imágenes complementarias (sin hash)
if (!empty($_FILES["imagenes_complementarias"]["name"][0])) {
    foreach ($_FILES["imagenes_complementarias"]["tmp_name"] as $key => $tmp_name) {
        $nombreArchivo = basename($_FILES["imagenes_complementarias"]["name"][$key]);
        $rutaSistema = $directorioSistema . $nombreArchivo;
        $rutaWeb = $directorioWeb . $nombreArchivo;

        if (move_uploaded_file($tmp_name, $rutaSistema)) {
            $conexion->query("INSERT INTO imagenes_prenda (prenda_id, ruta_imagen, tipo) VALUES ('$id_prenda', '$rutaWeb', 'complementaria')");
        } else {
            echo "❌ Error al subir imagen complementaria: $nombreArchivo<br>";
        }
    }
}

echo "✅ Prenda e imágenes guardadas correctamente. <a href='formulario_prenda.php'>Volver al formulario</a>";
?>
