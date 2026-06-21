<?php
if (!defined('APP_ROOT')) require __DIR__ . '/includes/bootstrap.php';
http_response_code(404);
$page_title='Страница не найдена';
require APP_ROOT . '/includes/header.php';
?>
<main id="main-content" class="container page"><div class="not-found"><div class="not-found-code">404</div><h1>Страница не найдена</h1><p>Возможно, адрес введен с ошибкой или страница была перемещена.</p><div><a class="button" href="<?= e(url('index.php')) ?>">На главную</a><a class="button secondary" href="<?= e(url('sitemap.php')) ?>">Открыть карту сайта</a></div></div></main><?php require APP_ROOT . '/includes/footer.php'; ?>
