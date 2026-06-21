<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

define('APP_ROOT', dirname(__DIR__));
$config = require APP_ROOT . '/config.php';
$content = require APP_ROOT . '/data/content.php';
date_default_timezone_set($config['timezone']);
require_once APP_ROOT . '/includes/functions.php';
ensure_storage();
