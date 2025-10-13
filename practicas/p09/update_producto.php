<?php
$link = mysqli_connect("localhost", "root", "12345678a", "marketzone", 3399);

if ($link === false) {
    die("ERROR: No pudo conectarse con la DB. " . mysqli_connect_error());
}

// Recibir datos del formulario
$id = $_POST['id'];
$nombre = mysqli_real_escape_string($link, $_POST['nombre']);
$modelo = mysqli_real_escape_string($link, $_POST['modelo']);
$marca = mysqli_real_escape_string($link, $_POST['marca']);
$precio = mysqli_real_escape_string($link, $_POST['precio']);
$detalles = mysqli_real_escape_string($link, $_POST['story']);
$unidades = mysqli_real_escape_string($link, $_POST['cantidad']);
$imagen = mysqli_real_escape_string($link, $_POST['imagen']);

// Consulta para actualizar el producto
$sql = "UPDATE productos SET nombre='$nombre', modelo='$modelo', marca='$marca', precio='$precio', detalles='$detalles', unidades='$unidades', imagen='$imagen' WHERE id='$id'";

if (mysqli_query($link, $sql)) {
    echo "Producto actualizado correctamente.";
    echo "<br><a href='get_producto_xhtml_v2.php'>Ver productos</a>";
    echo "<br><a href='get_productos_vigentes_v2.php'>Ver productos vigentes</a>";
} else {
    echo "ERROR: No se pudo ejecutar $sql. " . mysqli_error($link);
}

mysqli_close($link);
?>