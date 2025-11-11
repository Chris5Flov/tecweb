<?php
namespace MyAPI;

require_once __DIR__ . '/DataBase.php'; // ruta corregida

class Products extends DataBase {
    protected array $response = [];

    public function __construct(string $dbname, string $host='127.0.0.1', string $user='root', string $pass='', int $port=3399) {
        parent::__construct($dbname, $host, $user, $pass, $port);
        $this->response = [];
    }

    // Obtener todos los productos
    public function getAll(): array {
        $this->response = [];
        if (!$this->conexion) return $this->response;

        $sql = "SELECT * FROM productos ORDER BY id ASC";
        $stmt = $this->conexion->query($sql);
        $this->response = $stmt->fetchAll();
        return $this->response;
    }

    // Obtener por ID
    public function getById(int $id): array {
        $this->response = [];
        if (!$this->conexion) return $this->response;

        $sql = "SELECT * FROM productos WHERE id = :id LIMIT 1";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        if ($row) $this->response = $row;
        return $this->response;
    }

    // Buscar por nombre
    public function singleByName(string $nombre): array {
        $this->response = [];
        if (!$this->conexion) return $this->response;

        $sql = "SELECT * FROM productos WHERE nombre = :nombre LIMIT 1";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':nombre' => $nombre]);
        $row = $stmt->fetch();
        if ($row) $this->response = $row;
        return $this->response;
    }

    // Insertar producto
    public function insert(array $data): bool {
        if (!$this->conexion) return false;

        $sql = "INSERT INTO productos
                (nombre, marca, modelo, precio, detalles, unidades, imagen, eliminado)
                VALUES
                (:nombre, :marca, :modelo, :precio, :detalles, :unidades, :imagen, :eliminado)";

        $stmt = $this->conexion->prepare($sql);

        $ok = $stmt->execute([
            ':nombre' => $data['nombre'] ?? '',
            ':marca' => $data['marca'] ?? '',
            ':modelo' => $data['modelo'] ?? '',
            ':precio' => $data['precio'] ?? 0,
            ':detalles' => $data['detalles'] ?? '',
            ':unidades' => $data['unidades'] ?? 0,
            ':imagen' => $data['imagen'] ?? '',
            ':eliminado' => $data['eliminado'] ?? 0
        ]);

        if ($ok) {
            $this->response = ['inserted_id' => (int)$this->conexion->lastInsertId()];
        }

        return $ok;
    }

    // Actualizar producto por id
    public function update(int $id, array $data): bool {
        if (!$this->conexion) return false;

        $sql = "UPDATE productos SET 
                nombre = :nombre, 
                marca = :marca, 
                modelo = :modelo, 
                precio = :precio, 
                detalles = :detalles, 
                unidades = :unidades, 
                imagen = :imagen, 
                eliminado = :eliminado 
                WHERE id = :id";

        $stmt = $this->conexion->prepare($sql);
        $ok = $stmt->execute([
            ':nombre' => $data['nombre'] ?? '',
            ':marca' => $data['marca'] ?? '',
            ':modelo' => $data['modelo'] ?? '',
            ':precio' => $data['precio'] ?? 0,
            ':detalles' => $data['detalles'] ?? '',
            ':unidades' => $data['unidades'] ?? 0,
            ':imagen' => $data['imagen'] ?? '',
            ':eliminado' => $data['eliminado'] ?? 0,
            ':id' => $id
        ]);

        $this->response = ['updated' => $ok ? $stmt->rowCount() : 0];
        return $ok;
    }

    // Eliminar por id
    public function delete(int $id): bool {
        if (!$this->conexion) return false;

        $sql = "DELETE FROM productos WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $ok = $stmt->execute([':id' => $id]);
        $this->response = ['deleted' => $ok ? $stmt->rowCount() : 0];
        return $ok;
    }

    // Devuelve el arreglo de respuesta
    public function getResponse(): array {
        return $this->response;
    }

    // Convierte $response a JSON
    public function getData(): string {
        return json_encode($this->response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
