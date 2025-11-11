<?php
header('Content-Type: application/json');
$conexion = new mysqli('localhost','root','','marketzone');
if($conexion->connect_error){
    die(json_encode(['status'=>'error','message'=>'No se pudo conectar a la DB']));
}
$conexion->set_charset("utf8");

if(isset($_POST['nombre'])){
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $marca = $conexion->real_escape_string($_POST['marca']);
    $modelo = $conexion->real_escape_string($_POST['modelo']);
    $precio = floatval($_POST['precio']);
    $detalles = $conexion->real_escape_string($_POST['detalles']);
    $unidades = intval($_POST['unidades']);
    $imagen = $conexion->real_escape_string($_POST['imagen']);

    // Verificar si existe
    $result = $conexion->query("SELECT * FROM productos WHERE nombre='$nombre' AND eliminado=0");

    if($result->num_rows == 0){
        $sql = "INSERT INTO productos VALUES (null,'$nombre','$marca','$modelo',$precio,'$detalles',$unidades,'$imagen',0)";
        if($conexion->query($sql)){
            echo json_encode(['status'=>'success','message'=>'Producto agregado']);
        } else {
            echo json_encode(['status'=>'error','message'=>$conexion->error]);
        }
    } else {
        echo json_encode(['status'=>'error','message'=>'Ya existe un producto con ese nombre']);
    }
    $result->free();
}
$conexion->close();
?>
