<?php
require_once('vendor/autoload.php');
require_once('helpers.php');
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


$page_title = "Yeticave | Ошибка запроса";

if (!$link) {
    $error = mysqli_connect_error();
    $page_content = include_template('error.php', [
        'error' => $error,
        'is_auth' => $is_auth,
        'title' => $page_title,
        'user_name' => $user_name
    ]);
    print($page_content);
    die();
}

$sql = 'SELECT * FROM category';
$result = mysqli_query($link, $sql);

if (!$result) {
    $error = mysqli_connect_error();
    $page_content = include_template('error.php', [
        'error' => $error,
        'is_auth' => $is_auth,
        'title' => $page_title,
        'user_name' => $user_name
    ]);
    print($page_content);
    die();
}

$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

if (!$is_auth) {
    $error = 'Ошибка доступа! Войдите на сайт';
    $page_title = "Yeticave | Ошибка доступа";
    $page_content = include_template('error.php', [
        'error' => $error,
        'is_auth' => $is_auth,
        'user_name' => $user_name,
        'title' => $page_title
    ]);
    print($page_content);
    die();
}

$sql = 'SELECT r.rate_time as rate_timing, r.price as offer, r.user_id, r.lot_id as lot_id, l.NAME as lot_name, l.category_id, l.image as lot_image, l.end_time as lot_timing, c.name as category'
    . ' FROM rate AS r'
    . ' JOIN lot AS l'
    . ' ON r.lot_id = l.id'
    . ' LEFT outer JOIN category AS c'
    . ' ON l.category_id = c.id'
    . ' WHERE r.user_id = ' . $user_id
    . ' ORDER BY r.rate_time DESC';
$res = mysqli_query($link, $sql);

if (!$res) {
    $error = mysqli_connect_error();
    $page_content = include_template('error.php', [
        'error' => $error,
        'is_auth' => $is_auth,
        'title' => $page_title,
        'user_name' => $user_name
    ]);
    print($page_content);
    die();
}

$my_rates = mysqli_fetch_all($res, MYSQLI_ASSOC);

foreach ($my_rates as $key => $value) {
    $now = 'now';
    $time_rate = $value['rate_timing'];

    $diff = ceil((-strtotime($time_rate) + strtotime($now)) / 60);
    $my_rates[$key]['rate_time_diff'] = $diff;
    $my_rates[$key]['time_diff_text'] = $diff . get_noun_plural_form($diff, ' минута ', ' минуты ', ' минут ') . 'назад';
}

foreach ($my_rates as $key => $value) {
    $now = 'now';
    $lot_timing = $value['lot_timing'];

    $diff = (strtotime($lot_timing) - strtotime($now));

    $hours = floor($diff / 3600);
    $minutes = floor(($diff - $hours * 3600) / 60);
    $seconds = $diff - $hours * 3600 - $minutes * 60;

    if ($hours < 10 && $hours > 0) {
        $hours = '0' . $hours;
    } elseif ($hours == 0) {
        $hours = '00';
    }

    if ($minutes < 10 && $minutes > 0) {
        $minutes = '0' . $minutes;
    } elseif ($minutes == 0) {
        $minutes = '00';
    }

    if ($seconds < 10 && $seconds > 0) {
        $seconds = '0' . $seconds;
    } elseif ($seconds == 0) {
        $seconds = '00';
    }
    if ((int)$diff < 0) {
        $sql = 'SELECT user_id FROM rate'
        . ' WHERE lot_id = ' . $value['lot_id']
        . ' ORDER BY price DESC'
        . ' LIMIT 1';
        $res = mysqli_query($link, $sql);

        if (!$res) {
            $error = mysqli_connect_error();
            $page_content = include_template('error.php', [
                'error' => $error,
                'is_auth' => $is_auth,
                'title' => $page_title,
                'user_name' => $user_name
            ]);
            print($page_content);
            die();
        }

        $rates_winner = mysqli_fetch_all($res, MYSQLI_ASSOC)[0];

        if ((int)$rates_winner === (int)$user_id) {
            $my_rates[$key]['contacts'] = $_SESSION['user']['contacts'];
            $my_rates[$key]['rates_item_class'] = 'rates__item--win';
            $my_rates[$key]['timing_class'] = 'timer--win';
            $my_rates[$key]['timing_format'] = 'Ставка выиграла';
            $my_rates[$key]['is_winner'] = true;
        } else {
            $my_rates[$key]['rates_item_class'] = 'rates__item--end';
            $my_rates[$key]['timing_class'] = 'timer--end';
            $my_rates[$key]['timing_format'] = 'Торги окончены';
            $my_rates[$key]['is_winner'] = false;
        }
    } elseif (floor($diff / 3600) <= 1) {
        $my_rates[$key]['timing_class'] = 'timer--finishing';
        $my_rates[$key]['timing_format'] = $hours . ':' . $minutes . ":" . $seconds;
        $my_rates[$key]['is_winner'] = false;
    } else {
        $my_rates[$key]['timing_class'] = '';
        $my_rates[$key]['timing_format'] = $hours . ':' . $minutes . ":" . $seconds;
        $my_rates[$key]['is_winner'] = false;
    }
}

$page_content = include_template('my-bets.php', [
    'categories' => $categories,
    'my_rates' => $my_rates,
    'is_auth' => $is_auth
]);
$page_title = 'Yeticave | Мои ставки';

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => $page_title,
    'categories' => $categories,
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);

print($layout_content);
