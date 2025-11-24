<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require 'vendor/autoload.php';

$app = AppFactory::create();

$app->setBasePath("/tecweb/practicas/p13_slim4"); 

$app->addRoutingMiddleware();

$app->get('/', function (Request $request, Response $response, $args ){
    $response->getBody()->write("Hola Mundo Slim!!");
    return $response;
});

$app->get("/hola[/{nombre}]", function(Request $request, Response $response, $args){
    $nombre = $args['nombre'] ?? 'Invitado';
    $response->getBody()->write("Hola, " . $nombre);
    return $response;
});

$app->post("/pruebapost", function(Request $request, Response $response, $args){
    $reqPost = $request->getParsedBody();
    $val1 = $reqPost["val1"];
    $val2 = $reqPost["val2"];
    $response->getBody()->write("Valores: " .$val1 . " " . $val2);
    return $response; 
});

$app->get("/testjson", function($request, $response, $args){
    $data = [];
    $data[0]["nombre"]="Christian";
    $data[0]["apellidos"]="Flores Ovando";
    $data[1]["nombre"]="Ricardo";
    $data[1]["apellidos"]="Carmona Calderon";

    $response->getBody()->write(json_encode($data, JSON_PRETTY_PRINT));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
?>