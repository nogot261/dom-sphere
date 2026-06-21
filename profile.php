<?php
require __DIR__ . '/includes/bootstrap.php';
require_login();
$page_title='Личный кабинет';
$user=current_user();
$userMessages=array_values(array_filter(messages(),fn($m)=>(($m['username']??'')===$user['username'])||u_lower($m['email'])===u_lower($user['email'])));
require APP_ROOT . '/includes/header.php';
?>
<main id="main-content" class="container page"><div class="profile-head"><div><span class="eyebrow">Учетная запись</span><h1><?= e($user['name']) ?></h1><p>Роль: <?= e(role_name($user['role'])) ?> · Логин: <?= e($user['username']) ?></p></div><a class="button secondary" href="<?= e(url('contacts.php')) ?>">Новое обращение</a></div><div class="profile-grid"><section class="form-card"><h2>Данные пользователя</h2><dl class="specs"><div><dt>Имя</dt><dd><?= e($user['name']) ?></dd></div><div><dt>Электронная почта</dt><dd><?= e($user['email']) ?></dd></div><div><dt>Дата создания</dt><dd><?= e(format_date(substr($user['created_at'],0,10))) ?></dd></div></dl></section><section><h2>Мои обращения</h2><?php if(!$userMessages):?><div class="empty-state"><p>Обращений пока нет.</p></div><?php else:?><div class="message-list"><?php foreach(array_reverse($userMessages) as $m):?><article><div class="message-top"><strong><?= e($m['topic']) ?></strong><span class="status"><?= e($m['status']) ?></span></div><time><?= e($m['created_at']) ?></time><p><?= e($m['message']) ?></p><?php if($m['reply']):?><div class="reply"><strong>Ответ администратора</strong><p><?= e($m['reply']) ?></p></div><?php endif;?></article><?php endforeach;?></div><?php endif;?></section></div></main><?php require APP_ROOT . '/includes/footer.php'; ?>
