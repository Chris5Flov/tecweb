<?php
require 'vendor/autoload.php';

$app = new Slim\App();

$app->get('/', function ($request, $response, $args ){

    $response->getBody()->write("Hola Mundo Slim!!");
    return $response;
});

$app->get("/hola[/{nombre}]", function( $request, $response, $args){
    $response->write("Hola, " . $args["nombre"]);
    return $response;
});

$app->post("/pruebapost", function( $request, $response, $arg){
    $reqPost = $request->getParsedBody();
    $val1 = $reqPost["val1"];
    $val2 = $reqPost["val2"];

    $response->write("Valores: " . $val1 ." ".$val2);
});

$app->get("/testjson", function($request, $response, $args){
    $data[0]["nombre"]="Christian";
    $data[0]["apellidos"]="Flores Ovando";
    $data[1]["nombre"]="Ricardo";
    $data[1]["apellidos"]="Carmona Calderon";
    $response->write(json_encode($data, JSON_PRETTY_PRINT));
    return $response;
});

$app->run();
?>
