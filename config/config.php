<?php
// Determine scheme and host
$host = $_SERVER['HTTP_HOST'] ?? '';
$serverName = $_SERVER['SERVER_NAME'] ?? '';
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';

// Compute base path relative to document root (handles subfolder installs like localhost/project)
$documentRoot = isset($_SERVER['DOCUMENT_ROOT']) ? str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT'])) : '';
$projectRoot = str_replace('\\', '/', realpath(__DIR__ . '/..'));
$basePath = '';
if ($documentRoot && $projectRoot && $documentRoot !== $projectRoot) {
    $relative = str_replace($documentRoot, '', $projectRoot);
    $basePath = '/' . trim($relative, '/');
}

// Check if running on a local development environment (supports localhost with ports and 127.0.0.1)
if (
    strpos($host, 'localhost') !== false ||
    strpos($host, '127.0.0.1') !== false ||
    $serverName === 'localhost' ||
    // Laragon & local dev common TLDs
    preg_match('/\.(test|local|localhost)$/i', $host) === 1 ||
    // Detect Laragon folder layout
    (isset($_SERVER['DOCUMENT_ROOT']) && stripos($_SERVER['DOCUMENT_ROOT'], 'laragon') !== false)
) {
    // Local database settings (Laragon/XAMPP/MAMP)
    $server_name = "localhost";
    $user_name = "root";  // Default local user
    $password = "";       // Default local password (empty)
    $db_name = "ns_coffee"; // Local database name

    // Define the base URL for the local environment (supports subfolder or vhost)
    define("url", $scheme . "://" . $host . $basePath);
    define("ADMINURL", url . "/admin-panel");
} else {
    // Live database settings
    $env_file = $_SERVER['DOCUMENT_ROOT'] . '/.env';

    // Check if the .env file exists
    if (file_exists($env_file)) {
        $env = parse_ini_file($env_file);
    } else {
        die("❌ Error: .env file is missing! Please upload it to your server.");
    }

    // Load database credentials from .env
    $server_name = $env['DB_HOST'] ?? '';
    $user_name = $env['DB_USER'] ?? '';
    $password = $env['DB_PASS'] ?? '';
    $db_name = $env['DB_NAME'] ?? '';

    // Define the base URL for the live environment (supports subfolder installs)
    define("url", $scheme . "://" . $_SERVER['HTTP_HOST'] . $basePath);
    define("ADMINURL", url . "/admin-panel");
}

// Create a connection to the MySQL database
$conn = mysqli_connect($server_name, $user_name, $password, $db_name);

// Check if the connection was successful
if (!$conn) {
    die("❌ Connection failed: " . mysqli_connect_error());
}
