<?php
namespace MyAPI;

abstract class DataBase {
    protected $conexion; // PDO
    protected $host;
    protected $user;
    protected $pass;
    protected $dbname;
    protected $port;

    public function __construct(string $dbname, string $host='127.0.0.1', string $user='root', string $pass='', int $port=3306) {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->dbname = $dbname;
        $this->port = $port;

        $this->initConnection();
    }

    protected function initConnection(): void {
        $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset=utf8mb4";
        try {
            $options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $this->conexion = new \PDO($dsn, $this->user, $this->pass, $options);
        } catch (\PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
