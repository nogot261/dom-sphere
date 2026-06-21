<?php
require __DIR__ . '/includes/bootstrap.php';
$page_title = 'Главная';
$featured = array_slice($content['products'], 0, 6);
$latest_news = array_slice($content['news'], 0, 3);
require APP_ROOT . '/includes/header.php';
?>
<main id="main-content">
<section class="hero">
    <div class="container hero-grid">
        <div>
            <span class="eyebrow">Новая коллекция для порядка</span>
            <h1>Дом, в котором удобно каждый день</h1>
            <p>Подберите товары для кухни, ванной, хранения, текстиля, декора и уборки. Все разделы доступны без регистрации.</p>
            <div class="hero-actions"><a class="button" href="<?= e(url('catalog.php')) ?>">Перейти в каталог</a><a class="button secondary" href="<?= e(url('articles.php')) ?>">Читать советы</a></div>
            <ul class="hero-benefits"><li>30 товаров в каталоге</li><li>15 практических статей</li><li>Версия для слабовидящих</li></ul>
        </div>
        <div class="hero-visual" aria-label="Иллюстрация уютного интерьера">
            <img src="<?= e(url('assets/img/hero-home.svg')) ?>" alt="Уютная гостиная с товарами для дома">
        </div>
    </div>
</section>
<section class="container section">
    <div class="section-heading"><div><span class="eyebrow">Основные направления</span><h2>Категории товаров</h2></div><a href="<?= e(url('catalog.php')) ?>">Весь каталог →</a></div>
    <div class="category-grid">
        <?php foreach ($content['categories'] as $category): ?>
        <a class="category-card" href="<?= e(url('catalog.php?category=' . urlencode($category['name']))) ?>"><h3><?= e($category['name']) ?></h3><p><?= e($category['description']) ?></p><span>Смотреть товары</span></a>
        <?php endforeach; ?>
    </div>
</section>
<section class="soft-section"><div class="container section">
    <div class="section-heading"><div><span class="eyebrow">Популярное</span><h2>Рекомендуемые товары</h2></div></div>
    <div class="product-grid">
        <?php foreach ($featured as $product): ?>
        <article class="product-card"><a href="<?= e(url('product.php?id=' . $product['id'])) ?>"><img src="<?= e(url($product['image'])) ?>" alt="<?= e($product['name']) ?>"></a><div class="product-card-body"><span class="tag"><?= e($product['category']) ?></span><h3><a href="<?= e(url('product.php?id=' . $product['id'])) ?>"><?= e($product['name']) ?></a></h3><p><?= e($product['description']) ?></p><div class="product-meta"><strong><?= e(format_price($product['price'])) ?></strong><span>★ <?= e($product['rating']) ?></span></div></div></article>
        <?php endforeach; ?>
    </div>
</div></section>
<section class="container section split-section">
    <div><span class="eyebrow">Полезные материалы</span><h2>Советы для дома</h2><p>Статьи сгруппированы по трем разделам. В каждом разделе размещено по пять материалов.</p><a class="button" href="<?= e(url('articles.php')) ?>">Открыть раздел советов</a></div>
    <div class="news-list compact">
        <?php foreach ($latest_news as $item): ?><article><time><?= e(format_date($item['date'])) ?></time><h3><?= e($item['title']) ?></h3><p><?= e($item['text']) ?></p></article><?php endforeach; ?>
    </div>
</section>
<section class="cta"><div class="container cta-inner"><div><h2>Есть вопрос о товаре или работе сайта?</h2><p>Отправьте сообщение. Ответ появится в личном кабинете после обработки администратором.</p></div><a class="button light" href="<?= e(url('contacts.php')) ?>">Написать сообщение</a></div></section>
</main>
<?php require APP_ROOT . '/includes/footer.php'; ?>
