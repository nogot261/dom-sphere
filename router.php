<?php
declare(strict_types=1);

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$path = rawurldecode($path);
$file = __DIR__ . $path;

if ($path === '/healthz') {
    header('Content-Type: text/plain; charset=UTF-8');
    echo "ok\n";
    return true;
}

if ($path === '/') {
    require __DIR__ . '/index.php';
    return true;
}

if (is_file($file)) {
    $relative = ltrim($path, '/');
    $extension = strtolower(pathinfo($relative, PATHINFO_EXTENSION));

    // Only root-level page controllers and public assets may be served.
    $isPublicPage = dirname($relative) === '.'
        && $extension === 'php'
        && !in_array($relative, ['config.php', 'router.php'], true);
    $isPublicAsset = str_starts_with($path, '/assets/')
        && in_array($extension, ['css', 'js', 'svg', 'png', 'jpg', 'jpeg', 'gif', 'webp', 'ico'], true);

    if ($isPublicPage || $isPublicAsset) {
        return false;
    }
}

http_response_code(404);
require __DIR__ . '/404.php';
return true;
