<?php
require __DIR__ . '/includes/bootstrap.php';
$page_title = 'Новости';
require APP_ROOT . '/includes/header.php';
?>
<main id="main-content" class="container page"><div class="page-heading"><span class="eyebrow">События проекта</span><h1>Новости</h1><p>Лента обновлений каталога, материалов и функций сайта.</p></div><div class="news-list"><?php foreach ($content['news'] as $item): ?><article><time><?= e(format_date($item['date'])) ?></time><h2><?= e($item['title']) ?></h2><p><?= e($item['text']) ?></p></article><?php endforeach; ?></div></main><?php require APP_ROOT . '/includes/footer.php'; ?>
