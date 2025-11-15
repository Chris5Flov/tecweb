<?php
    /*namespace Nat\Delete;
    use Vendor\Composer\Products as Products;
    require_once __DIR__.'/../../Products.php';

    $productos = new Products('marketzone');
    $productos->delete( $_POST['id'] );
    echo $productos->getData();*/
namespace Nat\Delete;
use Vendor\Composer\Products as Products;
require_once __DIR__.'/../../Products.php';

$productos = new Products('marketzone');

// Si 'id' no viene, se devuelve un JSON de error directamente
if (isset($_POST['id']) && !empty($_POST['id'])) {
    $productos->delete($_POST['id']);
    echo $productos->getData();
} else {
    // Devuelve un JSON directamente
    echo json_encode([
        'status' => 'error',
        'message' => 'No se recibio el ID del producto'
    ], JSON_PRETTY_PRINT);
}

?>
