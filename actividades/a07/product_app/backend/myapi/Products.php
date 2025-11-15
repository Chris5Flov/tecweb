<?php
namespace myapi;

require_once "Database.php";

class Products extends Database {
    private array $data = [];

    public function __construct(
        string $db,
        string $user = "root",
        string $pass = "12345678a"
    ) {
        parent::__construct($db, $user, $pass);
    }

    /* ==========================================
       AGREGAR PRODUCTO
       ========================================== */
    public function add(object $obj): void {
        $sql = "INSERT INTO productos 
            (nombre, marca, modelo, precio, detalles, unidades, imagen)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param(
            "sssdsis",
            $obj->nombre,
            $obj->marca,
            $obj->modelo,
            $obj->precio,
            $obj->detalles,
            $obj->unidades,
            $obj->imagen
        );

        $stmt->execute();

        $this->data = [
            "added" => $stmt->affected_rows > 0,
            "message" => "Producto agregado correctamente"
        ];
    }

    /* ==========================================
       ELIMINAR PRODUCTO
       ========================================== */
    public function delete(string $id): void {
        $sql = "DELETE FROM productos WHERE id=?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();

        $this->data = [
            "deleted" => $stmt->affected_rows > 0,
            "message" => "Producto eliminado correctamente"
        ];
    }

    /* ==========================================
       EDITAR PRODUCTO
       ========================================== */
    public function edit(object $obj): void {
        $sql = "UPDATE productos SET 
            nombre=?, marca=?, modelo=?, precio=?, detalles=?, unidades=?, imagen=?
            WHERE id=?";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param(
            "sssdsisi",
            $obj->nombre,
            $obj->marca,
            $obj->modelo,
            $obj->precio,
            $obj->detalles,
            $obj->unidades,
            $obj->imagen,
            $obj->id
        );

        $stmt->execute();

        $this->data = [
            "updated" => $stmt->affected_rows >= 0,
            "message" => "Producto actualizado correctamente"
        ];
    }

    /* ==========================================
       LISTAR PRODUCTOS
       ========================================== */
    public function list(): void {
        $sql = "SELECT * FROM productos ORDER BY id DESC";
        $result = $this->conexion->query($sql);

        $this->data = $result->fetch_all(MYSQLI_ASSOC);
    }

    /* ==========================================
       BUSCAR POR NOMBRE / MARCA
       ========================================== */
    public function search(string $text): void {
        $sql = "SELECT * FROM productos WHERE nombre LIKE ? OR marca LIKE ?";
        $stmt = $this->conexion->prepare($sql);

        $like = "%".$text."%";
        $stmt->bind_param("ss", $like, $like);
        $stmt->execute();

        $this->data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /* ==========================================
       OBTENER UN PRODUCTO POR ID
       ========================================== */
    public function single(string $id): void {
        $sql = "SELECT * FROM productos WHERE id=?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();

        $this->data = $stmt->get_result()->fetch_assoc();
    }

    /* ==========================================
       VALIDAR NOMBRE ÚNICO
       ========================================== */
    public function singleByName(string $name): void {
        $sql = "SELECT * FROM productos WHERE nombre=?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $name);
        $stmt->execute();

        $this->data = $stmt->get_result()->fetch_assoc() ?? [];
    }

    /* ==========================================
       RETORNAR RESPUESTA
       ========================================== */
    public function getData(): string {
        return json_encode($this->data, JSON_UNESCAPED_UNICODE);
    }
}
?>
