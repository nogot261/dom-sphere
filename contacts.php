<?php
require __DIR__ . '/includes/bootstrap.php';
$page_title = 'Контакты и обратная связь';
$user = current_user();
$values = ['name'=>$user['name']??'', 'email'=>$user['email']??'', 'topic'=>trim((string)($_GET['topic']??'')), 'message'=>''];
$errors=[];
if ($_SERVER['REQUEST_METHOD']==='POST') {
    foreach ($values as $key=>$unused) $values[$key]=trim((string)($_POST[$key]??''));
    if (!check_csrf()) $errors[]='Не удалось подтвердить отправку формы. Обновите страницу.';
    if (u_len($values['name'])<2) $errors[]='Укажите имя.';
    if (!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) $errors[]='Укажите корректный адрес электронной почты.';
    if (u_len($values['topic'])<3) $errors[]='Укажите тему сообщения.';
    if (u_len($values['message'])<10) $errors[]='Сообщение должно содержать не менее 10 символов.';
    if (!$errors) {
        $items=messages();
        $items[]=['id'=>count($items)+1,'username'=>$user['username']??null,'name'=>$values['name'],'email'=>$values['email'],'topic'=>$values['topic'],'message'=>$values['message'],'reply'=>'','status'=>'Новое','created_at'=>date('Y-m-d H:i:s')];
        write_json('messages.json',$items);
        flash('success','Сообщение отправлено. Ответ можно посмотреть в личном кабинете после обработки.');
        redirect('contacts.php');
    }
}
require APP_ROOT . '/includes/header.php';
?>
<main id="main-content" class="container page"><div class="page-heading"><span class="eyebrow">Связь с магазином</span><h1>Контакты и обратная связь</h1><p>Задайте вопрос о товарах, работе сайта или условиях обслуживания.</p></div><div class="contact-grid"><section><h2>Контактные данные</h2><address><strong>Адрес</strong><span><?= e($config['address']) ?></span><strong>Телефон</strong><span><?= e($config['phone']) ?></span><strong>Электронная почта</strong><span><?= e($config['support_email']) ?></span><strong>Режим работы</strong><span>Ежедневно, 09:00–21:00</span></address><div class="map-placeholder"><strong>Схема расположения</strong><span>Метро «Уютная», выход № 2, далее 300 метров</span></div></section><section class="form-card"><h2>Отправить сообщение</h2><?php if ($errors): ?><div class="notice error"><ul><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?><form method="post"><?= csrf_field() ?><label for="name">Имя</label><input id="name" name="name" value="<?= e($values['name']) ?>" required><label for="email">Электронная почта</label><input id="email" name="email" type="email" value="<?= e($values['email']) ?>" required><label for="topic">Тема</label><input id="topic" name="topic" value="<?= e($values['topic']) ?>" required><label for="message">Сообщение</label><textarea id="message" name="message" rows="6" required><?= e($values['message']) ?></textarea><button class="button" type="submit">Отправить</button></form></section></div></main><?php require APP_ROOT . '/includes/footer.php'; ?>
