<?php
    namespace Nat\Read;
    use Vendor\Composer\Products as Products;
    require_once __DIR__.'/../../Products.php';

    $productos = new Products('marketzone');
    $productos->list();
    echo $productos->getData();
?>