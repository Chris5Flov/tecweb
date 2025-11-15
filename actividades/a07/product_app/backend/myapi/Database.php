<?php
namespace myapi;

abstract class Database {
    protected $conexion;

    public function __construct($db, $user, $pass) {
        // Intentamos la conexión usando mysqli_connect para evitar el fatal error
        $this->conexion = @mysqli_connect('localhost', $user, $pass, $db, 3399);

        if (!$this->conexion) {
            die("¡Base de datos NO conectada!");
        }

        // Establecemos charset igual que antes
        mysqli_set_charset($this->conexion, "utf8mb4");
    }
}
?>
