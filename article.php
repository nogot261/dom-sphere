<?php
require __DIR__ . '/includes/bootstrap.php';
$article = article_by_id((int)($_GET['id'] ?? 0));
if (!$article) { http_response_code(404); require APP_ROOT . '/404.php'; exit; }
$page_title = $article['title'];
require APP_ROOT . '/includes/header.php';
?>
<main id="main-content" class="container page narrow"><nav class="breadcrumbs" aria-label="Хлебные крошки"><a href="<?= e(url('index.php')) ?>">Главная</a><span>›</span><a href="<?= e(url('articles.php')) ?>">Советы</a><span>›</span><span><?= e($article['section']) ?></span></nav><article class="longread"><span class="tag"><?= e($article['section']) ?></span><h1><?= e($article['title']) ?></h1><time>Опубликовано <?= e(format_date($article['date'])) ?></time><p class="lead"><?= e($article['lead']) ?></p><h2>Порядок действий</h2><p><?= e($article['content']) ?></p><ol><li>Определите задачу и измерьте доступное пространство.</li><li>Оставьте только действительно нужные предметы.</li><li>Выберите решение, которое удобно использовать каждый день.</li><li>Через неделю оцените результат и при необходимости скорректируйте систему.</li></ol><aside class="tip"><strong>Практический совет</strong><p>Не покупайте органайзеры заранее. Сначала определите состав и объем вещей, которые нужно хранить.</p></aside><p>Материал подготовлен для учебного проекта сети магазинов товаров для дома.</p></article></main><?php require APP_ROOT . '/includes/footer.php'; ?>
