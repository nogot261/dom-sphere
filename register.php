<?php
require __DIR__ . '/includes/bootstrap.php';
if(is_logged_in()) redirect('profile.php');
$page_title='Регистрация';
$values=['name'=>'','email'=>'','username'=>''];$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
    foreach($values as $k=>$v)$values[$k]=trim((string)($_POST[$k]??''));
    $password=(string)($_POST['password']??'');
    if(!check_csrf())$errors[]='Сессия формы истекла. Обновите страницу.';
    if(u_len($values['name'])<2)$errors[]='Укажите имя.';
    if(!filter_var($values['email'],FILTER_VALIDATE_EMAIL))$errors[]='Укажите корректную электронную почту.';
    if(!preg_match('/^[a-zA-Z0-9_]{4,24}$/',$values['username']))$errors[]='Логин должен содержать 4–24 латинских символа, цифры или знак подчеркивания.';
    if(find_user($values['username']))$errors[]='Такой логин уже используется.';
    if(strlen($password)<8)$errors[]='Пароль должен содержать не менее 8 символов.';
    if(!$errors){$items=users();$items[]=['username'=>$values['username'],'name'=>$values['name'],'email'=>$values['email'],'password_hash'=>password_hash($password,PASSWORD_DEFAULT),'role'=>'buyer','created_at'=>date('Y-m-d H:i:s')];write_json('users.json',$items);$_SESSION['username']=$values['username'];flash('success','Учетная запись создана.');redirect('profile.php');}
}
require APP_ROOT . '/includes/header.php';
?>
<main id="main-content" class="container page narrow"><div class="form-card auth-card"><h1>Регистрация покупателя</h1><p>Самостоятельная регистрация создает учетную запись с ролью «Покупатель».</p><?php if($errors):?><div class="notice error"><ul><?php foreach($errors as $error):?><li><?= e($error) ?></li><?php endforeach;?></ul></div><?php endif;?><form method="post"><?= csrf_field() ?><label for="name">Имя</label><input id="name" name="name" value="<?= e($values['name']) ?>" required><label for="email">Электронная почта</label><input id="email" name="email" type="email" value="<?= e($values['email']) ?>" required><label for="username">Логин</label><input id="username" name="username" value="<?= e($values['username']) ?>" required><label for="password">Пароль</label><input id="password" name="password" type="password" minlength="8" required><button class="button" type="submit">Создать учетную запись</button></form></div></main><?php require APP_ROOT . '/includes/footer.php'; ?>
