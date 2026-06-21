<?php
$page_title = $page_title ?? 'Главная';
$user = current_user();
$flashes = consume_flashes();
?><!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="ДомСфера — демонстрационный сайт сети магазинов товаров для дома.">
    <title><?= e($page_title) ?> — <?= e($config['site_name']) ?></title>
    <link rel="stylesheet" href="<?= e(url('assets/css/style.css')) ?>">
</head>
<body>
<a class="skip-link" href="#main-content">Перейти к содержимому</a>
<header class="site-header">
    <div class="topbar">
        <div class="container topbar-inner">
            <span>Сеть магазинов товаров для дома</span>
            <button class="accessibility-button" id="accessibilityToggle" type="button" aria-pressed="false">Версия для слабовидящих</button>
        </div>
    </div>
    <div class="container header-main">
        <a class="brand" href="<?= e(url('index.php')) ?>" aria-label="ДомСфера, главная страница">
            <span class="brand-mark" aria-hidden="true">⌂</span>
            <span><strong>ДомСфера</strong><small>Товары и идеи для уютного дома</small></span>
        </a>
        <form class="header-search" action="<?= e(url('search.php')) ?>" method="get" role="search">
            <label class="visually-hidden" for="header-q">Поиск по сайту</label>
            <input id="header-q" name="q" type="search" placeholder="Найти товар, совет или новость" required>
            <button type="submit">Найти</button>
        </form>
        <div class="account-links">
            <?php if ($user): ?>
                <a href="<?= e(url('profile.php')) ?>"><?= e($user['name']) ?></a>
                <?php if (is_admin()): ?><a href="<?= e(url('admin.php')) ?>">Управление</a><?php endif; ?>
                <a href="<?= e(url('logout.php')) ?>">Выйти</a>
            <?php else: ?>
                <a href="<?= e(url('login.php')) ?>">Войти</a>
                <a href="<?= e(url('register.php')) ?>">Регистрация</a>
            <?php endif; ?>
        </div>
    </div>
    <nav class="main-nav" aria-label="Основная навигация">
        <div class="container nav-inner">
            <a href="<?= e(url('index.php')) ?>">Главная</a>
            <a href="<?= e(url('catalog.php')) ?>">Каталог</a>
            <a href="<?= e(url('articles.php')) ?>">Советы</a>
            <a href="<?= e(url('news.php')) ?>">Новости</a>
            <a href="<?= e(url('about.php')) ?>">О компании</a>
            <a href="<?= e(url('contacts.php')) ?>">Контакты</a>
        </div>
    </nav>
    <div class="accessibility-panel" id="accessibilityPanel" hidden>
        <div class="container accessibility-inner">
            <strong>Настройка отображения:</strong>
            <button type="button" data-font="decrease">А−</button>
            <button type="button" data-font="reset">А</button>
            <button type="button" data-font="increase">А+</button>
            <button type="button" data-spacing="toggle">Интервал</button>
        </div>
    </div>
</header>
<?php foreach ($flashes as $item): ?>
<div class="container"><div class="notice <?= e($item['type']) ?>" role="status"><?= e($item['message']) ?></div></div>
<?php endforeach; ?>
