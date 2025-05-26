
<?php
session_start();

if (!isset($_GET['id_prenda'])) {
    die("No se especificó la prenda a eliminar.");
}

$id_prenda = intval($_GET['id_prenda']);

if (isset($_SESSION['carrito'][$id_prenda])) {
    unset($_SESSION['carrito'][$id_prenda]);
}

header("Location: carrito.php");
exit;

