<?php

// Set the correct document root
$_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/../public';

// Set the script name for Laravel routing
$_SERVER['SCRIPT_NAME'] = '/index.php';

// Ensure the public directory is the document root
chdir(__DIR__ . '/../public');

// Forward to Laravel's public index
require_once __DIR__ . '/../public/index.php'; 