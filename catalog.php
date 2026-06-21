<?php
require __DIR__ . '/includes/bootstrap.php';
$page_title = 'Каталог товаров';
$category = trim((string)($_GET['category'] ?? ''));
$q = trim((string)($_GET['q'] ?? ''));
$products = array_values(array_filter($content['products'], function($item) use ($category, $q) {
    $categoryOk = $category === '' || $item['category'] === $category;
    $queryOk = $q === '' || text_contains($item['name'] . ' ' . $item['description'] . ' ' . $item['category'], $q);
    return $categoryOk && $queryOk;
}));
require APP_ROOT . '/includes/header.php';
?>
<main id="main-content" class="container page">
<div class="page-heading"><span class="eyebrow">Ассортимент</span><h1>Каталог товаров</h1><p>Выберите категорию или воспользуйтесь поиском.</p></div>
<div class="catalog-layout">
<aside class="filters"><h2>Фильтры</h2><form method="get"><label for="catalog-q">Название или описание</label><input id="catalog-q" name="q" value="<?= e($q) ?>" placeholder="Например, контейнер"><label for="category">Категория</label><select id="category" name="category"><option value="">Все категории</option><?php foreach ($content['categories'] as $item): ?><option <?= $category===$item['name']?'selected':'' ?>><?= e($item['name']) ?></option><?php endforeach; ?></select><button class="button" type="submit">Применить</button><a class="text-link" href="<?= e(url('catalog.php')) ?>">Сбросить</a></form></aside>
<section><div class="results-line"><strong>Найдено товаров: <?= count($products) ?></strong><?php if ($category || $q): ?><span>Учитываются выбранные параметры</span><?php endif; ?></div>
<?php if (!$products): ?><div class="empty-state"><h2>Товары не найдены</h2><p>Измените параметры поиска или сбросьте фильтры.</p></div><?php else: ?><div class="product-grid">
<?php foreach ($products as $product): ?><article class="product-card"><a href="<?= e(url('product.php?id='.$product['id'])) ?>"><img src="<?= e(url($product['image'])) ?>" alt="<?= e($product['name']) ?>"></a><div class="product-card-body"><span class="tag"><?= e($product['category']) ?></span><h2><a href="<?= e(url('product.php?id='.$product['id'])) ?>"><?= e($product['name']) ?></a></h2><p><?= e($product['description']) ?></p><div class="product-meta"><strong><?= e(format_price($product['price'])) ?></strong><span>★ <?= e($product['rating']) ?></span></div></div></article><?php endforeach; ?>
</div><?php endif; ?></section></div>
</main><?php require APP_ROOT . '/includes/footer.php'; ?>
