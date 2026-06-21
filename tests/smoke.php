<?php
require dirname(__DIR__) . '/includes/bootstrap.php';
$errors = [];
if (count($content['products']) !== 30) $errors[] = 'Ожидалось 30 товаров.';
if (count($content['articles']) !== 15) $errors[] = 'Ожидалось 15 статей.';
if (count($content['news']) !== 5) $errors[] = 'Ожидалось 5 новостей.';
if (!find_user('admin')) $errors[] = 'Не найдена учетная запись администратора.';
if (!find_user('pokupatel')) $errors[] = 'Не найдена учетная запись покупателя.';
if ($errors) { fwrite(STDERR, implode(PHP_EOL, $errors) . PHP_EOL); exit(1); }
echo "Проверка выполнена успешно.\n";
