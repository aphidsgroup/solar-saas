<?php

header('Content-Type: text/html');

echo "<h1>Vercel Laravel Debug</h1>";

echo "<h2>Environment Variables</h2>";
echo "<pre>";
foreach ($_ENV as $key => $value) {
    if (strpos($key, 'APP_') === 0) {
        echo "$key = " . (strpos($key, 'KEY') !== false ? '[HIDDEN]' : $value) . "\n";
    }
}
echo "</pre>";

echo "<h2>File System</h2>";
echo "<pre>";
echo "Current directory: " . getcwd() . "\n";
echo "Document root: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
echo "Script name: " . $_SERVER['SCRIPT_NAME'] . "\n";
echo "Request URI: " . $_SERVER['REQUEST_URI'] . "\n";

$paths = [
    'Laravel public index' => __DIR__ . '/../public/index.php',
    'Laravel bootstrap' => __DIR__ . '/../bootstrap/app.php',
    'Vendor autoload' => __DIR__ . '/../vendor/autoload.php',
    'Laravel config' => __DIR__ . '/../config/app.php',
    'Routes web' => __DIR__ . '/../routes/web.php',
];

foreach ($paths as $name => $path) {
    echo "$name: " . ($path) . " - " . (file_exists($path) ? "EXISTS" : "MISSING") . "\n";
}
echo "</pre>";

echo "<h2>PHP Info</h2>";
echo "<pre>";
echo "PHP Version: " . PHP_VERSION . "\n";
echo "Memory Limit: " . ini_get('memory_limit') . "\n";
echo "Max Execution Time: " . ini_get('max_execution_time') . "\n";
echo "</pre>";

echo "<h2>Laravel Test</h2>";
echo "<pre>";
try {
    if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
        require_once __DIR__ . '/../vendor/autoload.php';
        echo "Autoloader loaded successfully\n";
        
        if (file_exists(__DIR__ . '/../bootstrap/app.php')) {
            $app = require_once __DIR__ . '/../bootstrap/app.php';
            echo "Laravel app bootstrapped successfully\n";
            echo "App class: " . get_class($app) . "\n";
        } else {
            echo "Bootstrap file missing\n";
        }
    } else {
        echo "Vendor autoload missing\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
echo "</pre>";

echo "<h2>Try Laravel Route</h2>";
echo "<pre>";
try {
    ob_start();
    include __DIR__ . '/../public/index.php';
    $output = ob_get_clean();
    echo "Laravel output length: " . strlen($output) . " characters\n";
    if (strlen($output) > 0) {
        echo "First 500 characters:\n" . substr($output, 0, 500) . "\n";
    }
} catch (Exception $e) {
    echo "Laravel error: " . $e->getMessage() . "\n";
}
echo "</pre>";
?> 