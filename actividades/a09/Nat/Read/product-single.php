<?php

namespace Nat\Read;
use Vendor\Composer\Products as Products;
require_once __DIR__.'/../../Products.php';

$productos = new Products('marketzone');

// Validar que el parámetro 'id' exista
$id = isset($_POST['id']) ? $_POST['id'] : null;

if ($id) {
    $productos->single($id);
    echo $productos->getData();
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No se recibio el ID'
    ], JSON_PRETTY_PRINT);
}
?>
