<?php
require __DIR__ . '/includes/bootstrap.php';
$page_title = 'Советы для дома';
$section = trim((string)($_GET['section'] ?? ''));
$sections = array_values(array_unique(array_column($content['articles'], 'section')));
$articles = array_values(array_filter($content['articles'], fn($a) => $section==='' || $a['section']===$section));
require APP_ROOT . '/includes/header.php';
?>
<main id="main-content" class="container page"><div class="page-heading"><span class="eyebrow">Практические материалы</span><h1>Советы для дома</h1><p>В каждом тематическом разделе опубликовано по пять статей.</p></div>
<div class="tabs" role="navigation" aria-label="Разделы статей"><a class="<?= $section===''?'active':'' ?>" href="<?= e(url('articles.php')) ?>">Все</a><?php foreach ($sections as $s): ?><a class="<?= $section===$s?'active':'' ?>" href="<?= e(url('articles.php?section='.urlencode($s))) ?>"><?= e($s) ?></a><?php endforeach; ?></div>
<div class="article-grid"><?php foreach ($articles as $article): ?><article class="article-card"><span class="tag"><?= e($article['section']) ?></span><time><?= e(format_date($article['date'])) ?></time><h2><a href="<?= e(url('article.php?id='.$article['id'])) ?>"><?= e($article['title']) ?></a></h2><p><?= e($article['lead']) ?></p><a class="text-link" href="<?= e(url('article.php?id='.$article['id'])) ?>">Читать статью →</a></article><?php endforeach; ?></div>
</main><?php require APP_ROOT . '/includes/footer.php'; ?>
