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

$app->run();
?>
