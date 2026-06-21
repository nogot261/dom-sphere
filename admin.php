<?php
require __DIR__ . '/includes/bootstrap.php';
require_admin();
$page_title='Управление сайтом';
$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
    if(!check_csrf())$errors[]='Сессия формы истекла.';
    $action=$_POST['action']??'';
    if(!$errors && $action==='add_user'){
        $name=trim((string)($_POST['name']??''));$email=trim((string)($_POST['email']??''));$username=trim((string)($_POST['username']??''));$password=(string)($_POST['password']??'');$role=in_array($_POST['role']??'', ['buyer','administrator'],true)?$_POST['role']:'buyer';
        if(u_len($name)<2||!filter_var($email,FILTER_VALIDATE_EMAIL)||!preg_match('/^[a-zA-Z0-9_]{4,24}$/',$username)||strlen($password)<8)$errors[]='Проверьте заполнение данных нового пользователя.';
        if(find_user($username))$errors[]='Логин уже используется.';
        if(!$errors){$items=users();$items[]=['username'=>$username,'name'=>$name,'email'=>$email,'password_hash'=>password_hash($password,PASSWORD_DEFAULT),'role'=>$role,'created_at'=>date('Y-m-d H:i:s')];write_json('users.json',$items);flash('success','Пользователь создан администратором.');redirect('admin.php');}
    }
    if(!$errors && $action==='reply'){
        $id=(int)($_POST['message_id']??0);$reply=trim((string)($_POST['reply']??''));
        if(u_len($reply)<3)$errors[]='Введите ответ.';
        if(!$errors){$items=messages();foreach($items as &$m){if((int)$m['id']===$id){$m['reply']=$reply;$m['status']='Отвечено';$m['replied_at']=date('Y-m-d H:i:s');}}unset($m);write_json('messages.json',$items);flash('success','Ответ сохранен.');redirect('admin.php');}
    }
}
$allUsers=users();$allMessages=array_reverse(messages());
require APP_ROOT . '/includes/header.php';
?>
<main id="main-content" class="container page"><div class="page-heading"><span class="eyebrow">Панель администратора</span><h1>Управление сайтом</h1><p>Создание пользователей и обработка обращений.</p></div><?php if($errors):?><div class="notice error"><ul><?php foreach($errors as $error):?><li><?= e($error) ?></li><?php endforeach;?></ul></div><?php endif;?><div class="admin-grid"><section class="form-card"><h2>Создать пользователя</h2><form method="post"><?= csrf_field() ?><input type="hidden" name="action" value="add_user"><label for="name">Имя</label><input id="name" name="name" required><label for="email">Электронная почта</label><input id="email" name="email" type="email" required><label for="username">Логин</label><input id="username" name="username" required><label for="password">Пароль</label><input id="password" name="password" type="password" minlength="8" required><label for="role">Роль</label><select id="role" name="role"><option value="buyer">Покупатель</option><option value="administrator">Администратор</option></select><button class="button" type="submit">Создать</button></form></section><section><h2>Пользователи</h2><div class="table-wrap"><table><thead><tr><th>Имя</th><th>Логин</th><th>Роль</th><th>Дата</th></tr></thead><tbody><?php foreach($allUsers as $u):?><tr><td><?= e($u['name']) ?><small><?= e($u['email']) ?></small></td><td><?= e($u['username']) ?></td><td><?= e(role_name($u['role'])) ?></td><td><?= e(format_date(substr($u['created_at'],0,10))) ?></td></tr><?php endforeach;?></tbody></table></div></section></div><section class="section"><h2>Обращения пользователей</h2><?php if(!$allMessages):?><div class="empty-state"><p>Новых обращений нет.</p></div><?php else:?><div class="message-list admin-messages"><?php foreach($allMessages as $m):?><article><div class="message-top"><strong>№<?= e($m['id']) ?>. <?= e($m['topic']) ?></strong><span class="status"><?= e($m['status']) ?></span></div><time><?= e($m['created_at']) ?> · <?= e($m['name']) ?> · <?= e($m['email']) ?></time><p><?= e($m['message']) ?></p><form method="post" class="reply-form"><?= csrf_field() ?><input type="hidden" name="action" value="reply"><input type="hidden" name="message_id" value="<?= e($m['id']) ?>"><label for="reply-<?= e($m['id']) ?>">Ответ</label><textarea id="reply-<?= e($m['id']) ?>" name="reply" rows="3" required><?= e($m['reply']) ?></textarea><button class="button" type="submit">Сохранить ответ</button></form></article><?php endforeach;?></div><?php endif;?></section></main><?php require APP_ROOT . '/includes/footer.php'; ?>
