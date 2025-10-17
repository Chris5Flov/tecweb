<?php

    $conexion = @mysqli_connect(
    'localhost',   // host
    'root',        // usuario
    '12345678a',   // contraseña
    'marketzone',  // base de datos
    3399           // puerto
    
    );

    /**
     * NOTA: si la conexión falló $conexion contendrá false
     **/
    if(!$conexion) {
        die('¡Base de datos NO conextada!');
    }
?>