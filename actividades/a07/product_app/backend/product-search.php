<?php
header('Content-Type: application/json');
$conexion = new mysqli('localhost','root','','marketzone');
if($conexion->connect_error){
    die(json_encode(['status'=>'error','message'=>'No se pudo conectar a la DB']));
}
$conexion->set_charset("utf8");

$q = isset($_GET['q']) ? $conexion->real_escape_string($_GET['q']) : '';
$result = $conexion->query("SELECT * FROM productos WHERE nombre LIKE '%$q%' AND eliminado=0");

$rows = [];
while($row = $result->fetch_assoc()){
    $rows[] = $row;
}
echo json_encode($rows, JSON_PRETTY_PRINT);

$result->free();
$conexion->close();
?>
