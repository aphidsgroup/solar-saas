<?php
header('Content-Type: application/json');

echo json_encode([
    'status' => 'success',
    'message' => 'PHP is working on Vercel!',
    'php_version' => PHP_VERSION,
    'timestamp' => date('Y-m-d H:i:s'),
    'environment' => $_ENV['APP_ENV'] ?? 'unknown',
    'app_key_set' => !empty($_ENV['APP_KEY']),
    'laravel_path' => __DIR__ . '/../public/index.php',
    'file_exists' => file_exists(__DIR__ . '/../public/index.php')
]); 