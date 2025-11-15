<?php
/*include_once __DIR__ . '/database.php';

if (isset($_GET['nombre'])) {
    $nombre = mysqli_real_escape_string($conexion, $_GET['nombre']);

    // Buscar si el producto ya existe (no eliminado)
    $sql = "SELECT id FROM productos WHERE nombre = '$nombre' AND eliminado = 0 LIMIT 1";
    $result = $conexion->query($sql);

    if ($result && $result->num_rows > 0) {
        echo "existe";
    } else {
        echo "no_existe";
    }

    $result->free_result();
    $conexion->close();
} else {
    echo "error";
}*/
namespace backend;

require_once __DIR__ . "/myapi/Products.php";
use myapi\Products;

$products = new Products("marketzone", "root", "12345678a", 3399);

if (isset($_GET['nombre'])) {
    $products->checkName($_GET['nombre']);
    echo $products->getData();
} else {
    echo json_encode(["status" => "error"], JSON_PRETTY_PRINT);
}

?>
