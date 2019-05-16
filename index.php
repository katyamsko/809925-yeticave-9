<?php
require_once('vendor/autoload.php');
require_once('getwinner.php');
require_once('helpers.php');
require_once('data.php');
require_once('functions.php');
require_once('init.php');

session_start();

if (isset($_SESSION['user'])) {
    $is_auth = true;
    $user_name = $_SESSION['user']['name'];
    $user_id = $_SESSION['user']['id'];
} else {
    $is_auth = false;
    $user_name = "";
}

$page_title = "Yeticave | Ошибка";

if (!$link) {
    $error = mysqli_connect_error();
    $page_content = include_template('error.php', ['error' => $error]);
} else {
    $sql = 'SELECT * FROM category';
    $result = mysqli_query($link, $sql);

    if ($result) {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $sql = 'SELECT l.id as lot_id, l.name, l.image, l.start_price, l.end_time as end_time, c.name as category FROM lot as l '
         . 'JOIN category as c ON l.category_id = c.id '
         . 'WHERE l.end_time > NOW() '
         . 'ORDER BY l.lot_time DESC LIMIT 9';

        if ($res = mysqli_query($link, $sql)) {
            $ads = mysqli_fetch_all($res, MYSQLI_ASSOC);

            foreach ($ads as $key => $value) {
                $sql = 'SELECT COUNT(id) as count'
                    . ' FROM rate'
                    . ' WHERE lot_id = ' . $value['lot_id'];
                $result = mysqli_query($link, $sql);
                $ads[$key]['count'] = mysqli_fetch_assoc($result)['count'];
            }

            foreach ($ads as $key => $value) {
                $ads[$key]['format_time'] = $diff_time($value['end_time'])['format'];
                $ads[$key]['timer_class'] = $diff_time($value['end_time'])['timer_class'];
            }

            foreach ($ads as $key => $value) {
                $ads[$key]['rate_status_text'] = $value['count'] . get_noun_plural_form($value['count'], ' ставка ', ' ставки ', ' ставок ');
            }

            $page_title = "Yeticave | Главная";

            $page_content = include_template('index.php', [
                'categories' => $categories,
                'ads' => $ads,
                'price' => $price
            ]);
        } else {
            $error = mysqli_error($link);
            $page_content = include_template('error.php', ['error' => $error]);
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
