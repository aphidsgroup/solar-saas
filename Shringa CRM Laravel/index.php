<?php

// Simple redirect to Laravel application
// This file serves as the main entry point for Vercel

// Set environment variables if not already set
if (!getenv('APP_ENV')) {
    putenv('APP_ENV=production');
}
if (!getenv('APP_DEBUG')) {
    putenv('APP_DEBUG=false');
}
if (!getenv('APP_KEY')) {
    putenv('APP_KEY=base64:VQuaswEMbnGKGEQWFieSlr8N9TkPpAy22GNeAijIgOg=');
}
if (!getenv('APP_URL')) {
    putenv('APP_URL=https://shringacrm.vercel.app');
}

// Set Laravel-specific environment variables
putenv('SESSION_DRIVER=file');
putenv('CACHE_STORE=file');
putenv('QUEUE_CONNECTION=sync');
putenv('LOG_CHANNEL=stack');
putenv('LOG_LEVEL=error');
putenv('DB_CONNECTION=sqlite');
putenv('DB_DATABASE=:memory:');

// Change to the correct directory
chdir(__DIR__);

// Check if Laravel public index exists
if (file_exists(__DIR__ . '/public/index.php')) {
    // Forward to Laravel
    require_once __DIR__ . '/public/index.php';
} else {
    // Fallback response
    header('Content-Type: text/html; charset=utf-8');
    echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shringa CRM - Loading</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; background: #f5f5f5; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 40px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #880808; }
        .status { padding: 15px; margin: 20px 0; border-radius: 5px; }
        .info { background: #e3f2fd; color: #1976d2; }
        .error { background: #ffebee; color: #d32f2f; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🏢 Shringa CRM</h1>
        <div class="info">
            <strong>Application Status:</strong><br>
            Vercel deployment in progress...
        </div>
        <div class="error">
            <strong>Laravel Application Not Found</strong><br>
            The Laravel public/index.php file is missing or not accessible.
        </div>
        <p><strong>Debug Information:</strong></p>
        <ul style="text-align: left;">
            <li>Current directory: ' . getcwd() . '</li>
            <li>Looking for: ' . __DIR__ . '/public/index.php</li>
            <li>File exists: ' . (file_exists(__DIR__ . '/public/index.php') ? 'YES' : 'NO') . '</li>
            <li>PHP Version: ' . PHP_VERSION . '</li>
        </ul>
        <p>Please check the Vercel deployment logs for more information.</p>
    </div>
</body>
</html>';
}
?> 