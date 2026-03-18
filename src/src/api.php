<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/controllers.php';

$method = $_SERVER['REQUEST_METHOD'];

match ($method) {
    'GET'    => handleGet($dataFile),
    'POST'   => handlePost($dataFile),
    'PUT'    => handlePut($dataFile),
    'PATCH'  => handlePatch($dataFile),
    'DELETE' => handleDelete($dataFile),
    default  => handleMethodNotAllowed(),
};

function handleMethodNotAllowed(): void
{
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
