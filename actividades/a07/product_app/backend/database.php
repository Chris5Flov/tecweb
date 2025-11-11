<?php
    /*$conexion = @mysqli_connect(
        'localhost',
        'root',
        'Tec&12Web',
        'marketzone'
    );

    
    if(!$conexion) {
        die('¡Base de datos NO conextada!');
    }*/
    use TECWEB\MYAPI\Products as Products; 
    require_once __DIR__.'./myapi/Products.php'; 
    $prodObj = new Products ('marketzone');
    echo json_encode($prodObj->getData());
?>