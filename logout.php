<?php
require __DIR__ . '/includes/bootstrap.php';
unset($_SESSION['username']);
flash('success','Вы вышли из учетной записи.');
redirect('index.php');
