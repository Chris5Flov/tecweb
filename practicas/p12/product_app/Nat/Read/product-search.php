<?php

namespace Nat\Read;
use Vendor\Composer\Products as Products;
require_once __DIR__.'/../../Products.php';

$productos = new Products('marketzone');

// Validar que se reciba el parámetro 'search'
$search = isset($_GET['search']) ? $_GET['search'] : null;

if ($search) {
    $productos->search($search);
    echo $productos->getData();
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No se recibio el valor de busqueda'
    ], JSON_PRETTY_PRINT);
}

?>