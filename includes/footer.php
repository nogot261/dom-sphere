<footer class="site-footer">
    <div class="container footer-grid">
        <div><strong>ДомСфера</strong><p>Практичные товары, понятные советы и удобный сервис для дома.</p></div>
        <div><strong>Разделы</strong><a href="<?= e(url('catalog.php')) ?>">Каталог</a><a href="<?= e(url('articles.php')) ?>">Советы</a><a href="<?= e(url('news.php')) ?>">Новости</a></div>
        <div><strong>Покупателям</strong><a href="<?= e(url('contacts.php')) ?>">Обратная связь</a><a href="<?= e(url('sitemap.php')) ?>">Карта сайта</a><a href="<?= e(url('profile.php')) ?>">Личный кабинет</a></div>
        <div><strong>Контакты</strong><span><?= e($config['phone']) ?></span><span><?= e($config['support_email']) ?></span><span><?= e($config['address']) ?></span></div>
    </div>
    <div class="container copyright">© 2025 «ДомСфера». Учебный веб-проект.</div>
</footer>
<script src="<?= e(url('assets/js/app.js')) ?>"></script>
</body>
</html>
