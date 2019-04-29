<?php
require_once('helpers.php');
require_once('data.php');
require_once('functions.php');
require_once('init.php');

if (!$link) {
    $error = mysqli_connect_error();
    print($error);
} else {
    $sql = 'SELECT * FROM category';
    $result = mysqli_query($link, $sql);

    if ($result) {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($link);
        print($error);
    }

    $sql = 'SELECT l.id, l.name, l.image, l.start_price, c.name as category FROM lot as l '
         . 'JOIN category as c ON l.category_id = c.id '
         . 'WHERE l.end_time IS NULL '
         . 'ORDER BY l.lot_time DESC LIMIT 9';

    if ($res = mysqli_query($link, $sql)) {
        $ads = mysqli_fetch_all($res, MYSQLI_ASSOC);
        $page_content = include_template('index.php', [
            'categories' => $categories,
            'ads' => $ads,
            'price' => $price,
            'showedTime' => $resultTime['time'],
            'class_item' => $resultTime['class']
        ]);
    }
    else {
        $error = mysqli_error($link);
        print($error);
    }
}


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
