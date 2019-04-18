<?php
require_once('helpers.php');
require_once('data.php');
require_once('functions.php');



$page_content = include_template('index.php', [
    'categories' => $categories,
    'ads' => $ads,
    'price' => $price,
    'showedTime' => $resultTime['time'],
    'class_item' => $resultTime['class']
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Главная',
    'categories' => $categories,
    'ads' => $ads,
    'price' => $price,
    'user_name' => $user_name,
    'is_auth' => $is_auth
]);

print($layout_content);
