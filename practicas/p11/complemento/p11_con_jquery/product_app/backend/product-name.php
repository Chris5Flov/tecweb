<?php 
include_once __DIR__.'/database.php';

// SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
$data = array(
    'status'  => 'error',
    'message' => 'Hubo un error en la verificación'
);

// VERIFICACION DEL NOMBRE
if (isset($_GET['name'])) {

    $name = $_GET['name'];
    
    $name = $conexion->real_escape_string($name);

    // CONSULTA A LA BD PARA SABER SI EL NOMBRE YA EXISTE
    $sql = "SELECT COUNT(*) as count FROM productos WHERE nombre = '{$name}' AND eliminado = 0";
    $result = $conexion->query($sql);

    if ($result) {
        // RESULTADO DE LA CONSULTA
        $row = $result->fetch_assoc();
        
        // VALIDACION DEL NOMBRE
        if ($row['count'] > 0) {
            $data['status'] = 'error';
            $data['message'] = 'El nombre del producto ya existe.';
        } else {
            $data['status'] = 'success';
            $data['message'] = 'Nombre disponible.';
        }
        
        $result->free(); 
    } else {
        $data['message'] = "ERROR: No se pudo ejecutar la consulta. " . mysqli_error($conexion);
    }
    $conexion->close();
}

echo json_encode($data, JSON_PRETTY_PRINT);
?>