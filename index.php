<?php
declare(strict_types=1);

/**
 * Root Router / Fallback for Hostinger LiteSpeed / Apache hosting.
 * Automatically delegates to public/ directory.
 */
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$path = urldecode($uri);

// Prevent path traversal
if (str_contains($path, '..')) {
    http_response_code(400);
    exit('Bad Request');
}

$target = __DIR__ . '/public' . $path;

if ($path !== '/' && is_file($target)) {
    if (str_ends_with($target, '.php')) {
        require $target;
        exit;
    }
    $ext = strtolower(pathinfo($target, PATHINFO_EXTENSION));
    $mimes = [
        'css' => 'text/css; charset=utf-8',
        'js' => 'application/javascript; charset=utf-8',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'svg' => 'image/svg+xml',
        'webp' => 'image/webp',
        'ico' => 'image/x-icon',
        'json' => 'application/json',
        'woff2' => 'font/woff2',
        'woff' => 'font/woff',
        'ttf' => 'font/ttf',
    ];
    if (isset($mimes[$ext])) {
        header('Content-Type: ' . $mimes[$ext]);
    }
    readfile($target);
    exit;
}

require_once __DIR__ . '/public/index.php';
