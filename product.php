<?php
require __DIR__ . '/includes/bootstrap.php';
$product = product_by_id((int)($_GET['id'] ?? 0));
if (!$product) { http_response_code(404); require APP_ROOT . '/404.php'; exit; }
$page_title = $product['name'];
require APP_ROOT . '/includes/header.php';
?>
<main id="main-content" class="container page">
<nav class="breadcrumbs" aria-label="Хлебные крошки"><a href="<?= e(url('index.php')) ?>">Главная</a><span>›</span><a href="<?= e(url('catalog.php')) ?>">Каталог</a><span>›</span><span><?= e($product['name']) ?></span></nav>
<div class="product-detail"><div><img class="product-detail-image" src="<?= e(url($product['image'])) ?>" alt="<?= e($product['name']) ?>"></div><div><span class="tag"><?= e($product['category']) ?></span><h1><?= e($product['name']) ?></h1><p class="lead"><?= e($product['description']) ?></p><div class="detail-price"><?= e(format_price($product['price'])) ?></div><dl class="specs"><div><dt>Материал</dt><dd><?= e($product['material']) ?></dd></div><div><dt>Наличие</dt><dd><?= e($product['availability']) ?></dd></div><div><dt>Оценка покупателей</dt><dd>★ <?= e($product['rating']) ?> из 5</dd></div></dl><a class="button" href="<?= e(url('contacts.php?topic=' . urlencode('Вопрос о товаре: ' . $product['name']))) ?>">Задать вопрос о товаре</a></div></div>
<section class="section"><h2>Описание и рекомендации</h2><p>Товар подходит для повседневного использования. Перед применением рекомендуется ознакомиться с назначением изделия, соблюдать правила ухода и не использовать его вне предусмотренных условий.</p><p>Информация на странице является демонстрационной и используется в учебном веб-проекте.</p></section>
</main><?php require APP_ROOT . '/includes/footer.php'; ?>
