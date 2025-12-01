<?php
    namespace Nat\Create;
    use Vendor\Composer\Products as Products;
    require_once __DIR__.'/../../Products.php';

    $productos = new Products('marketzone');
    $productos->add( json_decode( json_encode($_POST) ) );
    echo $productos->getData();
?>