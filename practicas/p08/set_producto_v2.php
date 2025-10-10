<?php
// Evita warnings si el archivo se abre sin datos enviados
$nombre   = $_POST['name']     ?? '';
$marca    = $_POST['marca']    ?? '';
$modelo   = $_POST['modelo']   ?? '';
$precio   = $_POST['precio']   ?? 0;
$detalles = $_POST['story']    ?? '';
$unidades = $_POST['cantidad'] ?? 0;
$imagen   = $_POST['imagen']   ?? '';

// Conexión a la base de datos (verifica tu puerto)
@$link = new mysqli('localhost', 'root', '12345678a', 'marketzone', 3399);

if ($link->connect_errno) {
    die('Falló la conexión: ' . $link->connect_error . '<br/>');
}

// Evitar ejecución si el formulario no se envió realmente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($nombre) && !empty($marca) && !empty($modelo)) {

    // Verificar si el producto ya existe
    $stmt = $link->prepare("SELECT 1 FROM productos WHERE nombre = ? AND marca = ? AND modelo = ?");
    $stmt->bind_param("sss", $nombre, $marca, $modelo);
    $stmt->execute();

    if ($stmt->get_result()->num_rows > 0) {
        echo '<p style="color:red;">❌ Error: Este producto ya existe en la base de datos.</p>';
        $stmt->close();
    } else {
        $stmt->close();

        // Inserción
        $sql = "INSERT INTO productos (id, nombre, marca, modelo, precio, detalles, unidades, imagen, eliminado)
                VALUES (NULL, '$nombre', '$marca', '$modelo', $precio, '$detalles', $unidades, '$imagen', 0)";

        if ($link->query($sql)) {
            echo '<p style="color:green;">✅ Producto insertado con ID: ' . $link->insert_id . '</p>';
            echo '<h2>Resumen del producto insertado:</h2>';
            echo '<ul>';
            echo '<li><strong>Nombre:</strong> ' . htmlspecialchars($nombre) . '</li>';
            echo '<li><strong>Marca:</strong> ' . htmlspecialchars($marca) . '</li>';
            echo '<li><strong>Modelo:</strong> ' . htmlspecialchars($modelo) . '</li>';
            echo '<li><strong>Precio:</strong> $' . number_format($precio, 2) . '</li>';
            echo '<li><strong>Detalles:</strong> ' . htmlspecialchars($detalles) . '</li>';
            echo '<li><strong>Unidades:</strong> ' . htmlspecialchars($unidades) . '</li>';
            echo '<li><strong>Imagen:</strong> <img src="' . htmlspecialchars($imagen) . '" alt="Imagen del producto" width="100"></li>';
            echo '</ul>';
        } else {
            echo '<p style="color:red;">❌ El producto no pudo ser insertado.</p>';
        }
    }

} else {
    echo '<p style="color:gray;">ℹ️ Abre este archivo solo desde el formulario.</p>';
}

$link->close();
?>
