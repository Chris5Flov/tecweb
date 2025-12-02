<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use TECWEB\MYAPI\CREATE\Create;
use TECWEB\MYAPI\DELETE\Delete;
use TECWEB\MYAPI\READ\Read;
use TECWEB\MYAPI\UPDATE\Update;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
$app->addRoutingMiddleware();
$app->setBasePath('/tecweb/actividades/a09/product_app/backend');

//CREATE
$app->post('/product', function($request, $response, $args){
    $products = new Create("marketzone");
    $input = $request->getBody()->getContents();
    $data = json_decode($input, true);
    $producto = (object)$data;
    $products->add($producto);
    $response->getBody()->write(json_encode($products->getData()));
    return $response->withHeader('Content-Type', 'application/json');
});

//DELETE
$app->delete('/productos/{id}', function($request, $response, $args){
    $products = new Delete("marketzone");
    $id = $args['id'];
    $products->delete($id);
    $response->getBody()->write(json_encode($products->getData()));
    return $response->withHeader('Content-Type', 'application/json');
});


//READ
$app->get('/products', function ($request, $response, $args){
    $products = new Read("marketzone");
    $products->list();
    $response->getBody()->write(json_encode($products->getData()));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/products/{search}', function($request, $response, $args){
    $products = new Read("marketzone");
    $search = $args['search'] ?? '';
    $products->search($search);
    $response->getBody()->write(json_encode($products->getData()));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/productos/{id}', function($request, $response, $args){
    $products = new Read("marketzone");
    $par = $request->getQueryParams();
    $id = isset($par['name']) ? intval($par['name']) : 0;
    $products->single($id);
    $response->getBody()->write(json_encode($products->getData()));
    return $response->withHeader('Content-Type', 'application/json');
});


//UPDATE
$app->put('/product', function($request, $response, $args){
    $products = new Update("marketzone");
    $input = $request->getBody()->getContents();
    $data = json_decode($input, true);
    $producto = (object)$data;
    $products->edit($producto);
    $response->getBody()->write(json_encode($products->getData()));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
?>