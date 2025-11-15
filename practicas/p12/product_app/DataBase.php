<?php
namespace Vendor\Composer;
require_once __DIR__ . '/vendor/autoload.php';

abstract class DataBase {
    protected $conexion;

    public function __construct($db, $user, $pass, $port) {
        $this->conexion = @mysqli_connect(
            'localhost',
            $user,
            $pass,
            $db,
            $port
        );
    
        /**
         * NOTA: si la conexión falló $conexion contendrá false
         **/
        if(!$this->conexion) {
            die('¡Base de datos NO conextada!');
        }
        /*else {
            echo 'Base de datos encontrada';
        }*/
    }
}
?>