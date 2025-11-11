<?php
// products_api.php

require_once __DIR__ . '/Products.php'; // ruta corregida, misma carpeta

use MyAPI\Products;

// Configuración de conexión
$dbName = 'marketzone'; // Nombre de tu base de datos
$dbHost = '127.0.0.1';
$dbUser = 'root';
$dbPass = '12345678a';
$dbPort = 3399; // puerto

// Crear instancia de Products
$prod = new Products($dbName, $dbHost, $dbUser, $dbPass, $dbPort);

// Obtener acción de la URL
$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        $prod->getAll();
        echo $prod->getData();
        break;

    case 'get':
        $id = intval($_GET['id'] ?? 0);
        $prod->getById($id);
        echo $prod->getData();
        break;

    case 'findByName':
        $nombre = $_GET['name'] ?? '';
        $prod->singleByName($nombre);
        echo $prod->getData();
        break;

    case 'insert':
        // Recibe datos por POST: nombre, marca, modelo, precio, detalles, unidades, imagen, eliminado
        $data = $_POST;
        $prod->insert($data);
        echo $prod->getData();
        break;

    case 'update':
        $id = intval($_POST['id'] ?? 0);
        $data = $_POST;
        $prod->update($id, $data);
        echo $prod->getData();
        break;

    case 'delete':
        $id = intval($_POST['id'] ?? 0);
        $prod->delete($id);
        echo $prod->getData();
        break;

    default:
        $prod->getAll();
        echo $prod->getData();
        break;
}
