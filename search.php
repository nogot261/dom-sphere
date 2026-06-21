<?php
require __DIR__ . '/includes/bootstrap.php';
$page_title='Поиск';
$q=trim((string)($_GET['q']??''));
$products=$q===''?[]:array_values(array_filter($content['products'],fn($x)=>text_contains($x['name'].' '.$x['description'].' '.$x['category'],$q)));
$articles=$q===''?[]:array_values(array_filter($content['articles'],fn($x)=>text_contains($x['title'].' '.$x['lead'].' '.$x['section'],$q)));
$news=$q===''?[]:array_values(array_filter($content['news'],fn($x)=>text_contains($x['title'].' '.$x['text'],$q)));
$total=count($products)+count($articles)+count($news);
require APP_ROOT . '/includes/header.php';
?>
<main id="main-content" class="container page"><div class="page-heading"><span class="eyebrow">Поиск по сайту</span><h1>Результаты поиска</h1><?php if($q!==''):?><p>По запросу «<?= e($q) ?>» найдено: <?= $total ?></p><?php else:?><p>Введите запрос в строке поиска.</p><?php endif;?></div><?php if($q!==''&&$total===0):?><div class="empty-state"><h2>Ничего не найдено</h2><p>Попробуйте изменить формулировку запроса.</p></div><?php endif;?><?php if($products):?><section class="search-group"><h2>Товары</h2><?php foreach($products as $x):?><a class="search-result" href="<?= e(url('product.php?id='.$x['id'])) ?>"><strong><?= e($x['name']) ?></strong><span><?= e($x['description']) ?></span></a><?php endforeach;?></section><?php endif;?><?php if($articles):?><section class="search-group"><h2>Статьи</h2><?php foreach($articles as $x):?><a class="search-result" href="<?= e(url('article.php?id='.$x['id'])) ?>"><strong><?= e($x['title']) ?></strong><span><?= e($x['lead']) ?></span></a><?php endforeach;?></section><?php endif;?><?php if($news):?><section class="search-group"><h2>Новости</h2><?php foreach($news as $x):?><div class="search-result"><strong><?= e($x['title']) ?></strong><span><?= e($x['text']) ?></span></div><?php endforeach;?></section><?php endif;?></main><?php require APP_ROOT . '/includes/footer.php'; ?>
