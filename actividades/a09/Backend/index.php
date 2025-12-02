<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use TECWEB\NAT\CREATE\Create;
use TECWEB\NAT\DELETE\Delete;
use TECWEB\NAT\READ\Read;
use TECWEB\NAT\UPDATE\Update;

require __DIR__ . '/vendor/autoload.php';