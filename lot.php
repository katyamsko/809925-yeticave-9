<?php
require_once('helpers.php');
require_once('data.php');
require_once('functions.php');
require_once('init.php');

session_start();

if (isset($_SESSION['user'])) {
    $is_auth = true;
    $user_name = $_SESSION['user']['name'];
} else {
    $is_auth = false;
    $user_name = "";
}


$page_title = "Yeticave | Ошибка запроса";

if (!$link) {
    $error = mysqli_connect_error();
    $page_content = include_template('error.php', ['error' => $error]);
} else {
    $sql = 'SELECT * FROM category';
    $result = mysqli_query($link, $sql);

    if ($result) {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if (isset($_GET['id'])) {
            $id_lot = (int)$_GET['id'];

            $sql = 'SELECT l.name as lot_name, l.start_price, l.lot_time, l.description, l.image, l.end_time, c.name as category, MAX(r.price) as current_price FROM lot as l '
            . 'JOIN category as c '
            . 'ON l.category_id = c.id '
            . 'JOIN rate as r '
            . 'ON r.lot_id = l.id '
            . 'WHERE l.id = ' . $id_lot;

            if ($res = mysqli_query($link, $sql)) {
                $lot_array = mysqli_fetch_all($res, MYSQLI_ASSOC);
                $lot = $lot_array[0];

                if ($lot['current_price'] == null) {
                    $lot['current_price'] = $lot['start_price'];
                }

                if ($lot['lot_name']) {
                    $page_content = include_template('lot.php', [
                        'categories' => $categories,
                        'lot' => $lot,
                        'price' => $price,
                        'showedTime' => $resultTime['time'],
                        'class_item' => $resultTime['class'],
                        'is_auth' => $is_auth
                    ]);
                    $page_title = $lot['lot_name'];
                } else {
                    $page_content = include_template('404.php', ['categories' => $categories]);
                }
            } else {
                $error = mysqli_error($link);
                $page_content = include_template('error.php', ['error' => $error]);
            }
        } else {
            $page_content = include_template('404.php', ['categories' => $categories]);
        }
    } else {
        $error = mysqli_error($link);
        $page_content = include_template('error.php', ['error' => $error]);
    }
}


$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => $page_title,
    'categories' => $categories,
    'ads' => $ads,
    'price' => $price,
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);

print($layout_content);

