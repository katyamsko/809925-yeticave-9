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

$page_title = "Yeticave | Ошибка поиска";

if (!$link) {
    $error = mysqli_connect_error();
    $page_content = include_template('error.php', ['error' => $error]);
} else {
    $sql = 'SELECT * FROM category';
    $result = mysqli_query($link, $sql);

    if ($result) {
        $lots = [];
        $search = $_GET['q'] ?? '';
        $search_string = trim($search);

        if ($search) {
            $cur_page = $_GET['page'] ?? 1;
            $page_items = 9;

            $stmt = db_get_prepare_stmt($link, "SELECT COUNT(*) as cnt FROM lot WHERE MATCH(name, description) AGAINST(?)", [$search_string]);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            $items_count = mysqli_fetch_assoc($result)['cnt'];
            $pages_count = ceil($items_count / $page_items);
            $offset = ($cur_page - 1) * $page_items;

            $pages = range(1, $pages_count);

            $sql = 'SELECT l.id as lot_id, l.name as lot_name, l.name, l.image as lot_image, l.end_time as lot_time, l.start_price as start_price, c.name as category FROM lot as l '
              . ' JOIN category as c'
              . ' ON l.category_id = c.id'
              . ' WHERE MATCH(l.name, description) AGAINST(?)'
              . ' ORDER BY lot_time DESC'
              . ' LIMIT ' . $page_items
              . ' OFFSET ' . $offset;

            $stmt = db_get_prepare_stmt($link, $sql, [$search_string]);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);

            foreach ($lots as $key => $value) {
                $sql = 'SELECT COUNT(id) as count'
                    . ' FROM rate'
                    . ' WHERE lot_id = ' . $value['lot_id'];
                $result = mysqli_query($link, $sql);
                $lots[$key]['count'] = mysqli_fetch_assoc($result)['count'];
            }

            foreach ($lots as $key => $value) {
                $lots[$key]['format_time'] = diff_time($value['lot_time'])['format'];
                $lots[$key]['timer_class'] = diff_time($value['lot_time'])['timer_class'];
            }

            foreach ($lots as $key => $value) {
                $lots[$key]['rate_status_text'] = $value['count'] . get_noun_plural_form($value['count'], ' ставка ', ' ставки ', ' ставок ');
            }

            if (isset($lots[0])) {
                $page_content = include_template('search.php', [
                    'lots' => $lots,
                    'categories' => $categories,
                    'search' => $search,
                    'pages_count' => $pages_count,
                    'pages' => $pages,
                    'cur_page' => $cur_page,
                    'search_string' => $search_string
                ]);
                $page_title = 'Поиск по запросу «' . $search_string . '»';
            } else {
                $error = 'По Вашему запросу ничего не найдено!';
                $page_content = include_template('error.php', [
                    'error' => $error
                ]);
                $page_title = 'Поиск по запросу «' . $search_string . '»';
            }
        } else {
            $error = 'Введите что-нибудь в поле поиска!';
            $page_content = include_template('error.php', [
                'error' => $error
            ]);
        }
    } else {
        $error = mysqli_error($link);
        $page_content = include_template('error.php', ['error' => $error]);
        $page_title = "Yeticave | Результат поиска";
    }
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => $page_title,
    'categories' => $categories,
    'user_name' => $user_name,
    'is_auth' => $is_auth
]);

print($layout_content);
