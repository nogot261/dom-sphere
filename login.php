<?php
require __DIR__ . '/includes/bootstrap.php';
if (is_logged_in()) redirect('profile.php');
$page_title='Вход';
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $username=trim((string)($_POST['username']??''));
    $password=(string)($_POST['password']??'');
    if(!check_csrf()) $error='Сессия формы истекла. Обновите страницу.';
    else { $user=find_user($username); if($user && password_verify($password,$user['password_hash'])){$_SESSION['username']=$user['username'];flash('success','Вход выполнен.');redirect('profile.php');} else $error='Неверный логин или пароль.'; }
}
require APP_ROOT . '/includes/header.php';
?>
<main id="main-content" class="container page narrow"><div class="form-card auth-card"><h1>Вход в учетную запись</h1><p>После входа пользователь может просматривать обращения и ответы.</p><?php if($error):?><div class="notice error"><?= e($error) ?></div><?php endif;?><form method="post"><?= csrf_field() ?><label for="username">Логин</label><input id="username" name="username" autocomplete="username" required><label for="password">Пароль</label><input id="password" name="password" type="password" autocomplete="current-password" required><button class="button" type="submit">Войти</button></form><p class="form-note">Нет учетной записи? <a href="<?= e(url('register.php')) ?>">Зарегистрироваться</a>.</p></div></main><?php require APP_ROOT . '/includes/footer.php'; ?>
