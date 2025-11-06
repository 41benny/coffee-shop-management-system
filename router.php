<?php
// router.php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path_on_disk = $_SERVER['DOCUMENT_ROOT'] . $path;

// If the request is for a file that exists, serve it directly.
if (is_file($path_on_disk)) {
    return false;
}

// If the request + .php is a file, include it.
if (is_file($path_on_disk . '.php')) {
    require $path_on_disk . '.php';
    return true;
}

// For requests like /admin/admins/, serve index.php
if (is_dir($path_on_disk) && is_file($path_on_disk . '/index.php')) {
    require $path_on_disk . '/index.php';
    return true;
}

// Otherwise, let the built-in server handle it (which will likely be a 404 or a static file).
return false;
?>