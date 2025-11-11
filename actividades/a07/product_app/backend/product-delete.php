<?php
header('Content-Type: application/json');
$conexion = new mysqli('localhost','root','','marketzone');
if($conexion->connect_error){
    die(json_encode(['status'=>'error','message'=>'No se pudo conectar a la DB']));
}
$conexion->set_charset("utf8");

if(isset($_POST['id'])){
    $id = intval($_POST['id']);
    if($conexion->query("UPDATE productos SET eliminado=1 WHERE id=$id")){
        echo json_encode(['status'=>1]);
    } else {
        echo json_encode(['status'=>0]);
    }
}
$conexion->close();
?>
