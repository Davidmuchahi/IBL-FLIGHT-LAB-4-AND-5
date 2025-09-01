<?php
header('Content-Type: application/json');

echo json_encode([
    'message' => 'PHP Flight API - IBL_FLIGHTS_LABS',
    'version' => '1.0.0',
    'endpoints' => [
        'GET /api/airlines' => 'Get all airlines',
        'GET /api/airlines/{id}' => 'Get airline by ID',
        'POST /api/airlines' => 'Create new airline',
        'PUT /api/airlines/{id}' => 'Update airline',
        'DELETE /api/airlines/{id}' => 'Delete airline'
    ],
    'base_url' => 'http://localhost/IBL-FLIGHT-LAB-4-AND-5/api/',
    'timestamp' => date('Y-m-d H:i:s')
], JSON_PRETTY_PRINT);
?>
