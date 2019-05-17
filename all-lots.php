<?php
//require_once('vendor/autoload.php');
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

$page_title = "Yeticave | Ошибка";

if (!$link) {
    $error = mysqli_connect_error();
    $page_content = include_template('error.php', ['error' => $error]);
} else {
    $sql = 'SELECT * FROM category';
    $result = mysqli_query($link, $sql);

    if ($result) {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if (isset($_GET['cat'])) {
            $lots_category = $_GET['cat'];

            $cur_page = $_GET['page'] ?? 1;
            $page_items = 9;

            $stmt = db_get_prepare_stmt($link, "SELECT COUNT(*) as cnt FROM lot as l JOIN category as c on l.category_id = c.id WHERE c.code LIKE '" . $lots_category . "'");
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $items_count = mysqli_fetch_assoc($result)['cnt'];
            $pages_count = ceil($items_count / $page_items);
            $offset = ($cur_page - 1) * $page_items;
            $pages = range(1, $pages_count);

            $sql = 'SELECT l.id as lot_id, l.name as lot_name, l.image as lot_image, l.start_price as lot_price, l.lot_time as lot_time, l.end_time as end_time, c.name as category FROM lot as l'
                . ' JOIN category as c'
                . ' ON l.category_id = c.id'
                . ' WHERE l.end_time > NOW()'
                . " AND c.code LIKE '" . $lots_category . "'"
                . ' ORDER BY l.lot_time DESC'
                . ' LIMIT ' . $page_items
                . ' OFFSET ' . $offset;

            $result = mysqli_query($link, $sql);

            if ($result) {
                if (mysqli_num_rows($result)) {
                    $lot = mysqli_fetch_all($result, MYSQLI_ASSOC);

                    foreach ($lot as $key => $value) {
                        $sql = 'SELECT COUNT(id) as count'
                            . ' FROM rate'
                            . ' WHERE lot_id = ' . $value['lot_id'];
                        $result = mysqli_query($link, $sql);
                        $lot[$key]['count'] = mysqli_fetch_assoc($result)['count'];
                    }

                    foreach ($lot as $key => $value) {
                        $lot[$key]['format_time'] = diff_time($value['end_time'])['format'];
                        $lot[$key]['timer_class'] = diff_time($value['end_time'])['timer_class'];
                    }

                    foreach ($lot as $key => $value) {
                        $lot[$key]['rate_status_text'] = $value['count'] . get_noun_plural_form($value['count'], ' ставка ', ' ставки ', ' ставок ');
                    }

                    $category = $lot[0]['category'];

                    //print($lot[0]['lot_name']);

                    $page_title = "YetiCave | " . $lot[0]['category'];
                    $page_content = include_template('all-lots.php', [
                        'categories' => $categories,
                        'lot' => $lot,
                        'category' => $category,
                        'price' => 'price',
                        'pages_count' => $pages_count,
                        'pages' => $pages,
                        'cur_page' => $cur_page,
                        'lots_category' => $lots_category
                    ]);
                } else {
                    $sql = "SELECT name FROM category WHERE code like '" . $lots_category . "'";
                    $result = mysqli_query($link, $sql);
                    $category_title = mysqli_fetch_assoc($result)['name'];
                    $error = 'В данный момент открытые аукционы товаров этой категории отсутствуют';
                    $page_content = include_template('error.php', ['error' => $error]);
                    $page_title = "YetiCave | " . $category_title;
                }
            } else {
                $error = mysqli_error($link);
                $page_content = include_template('error.php', ['error' => $error]);
            }
        } else {
            $cur_page = $_GET['page'] ?? 1;
            $page_items = 9;

            $stmt = db_get_prepare_stmt($link, "SELECT COUNT(*) as cnt FROM lot as l JOIN category as c on l.category_id = c.id WHERE l.end_time > NOW()");
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $items_count = mysqli_fetch_assoc($result)['cnt'];
            $pages_count = ceil($items_count / $page_items);
            $offset = ($cur_page - 1) * $page_items;
            $pages = range(1, $pages_count);

            $sql = 'SELECT l.id as lot_id, l.name as lot_name, l.image as lot_image, l.start_price as lot_price, l.lot_time as lot_time, l.end_time as end_time, c.name as category FROM lot as l'
                . ' JOIN category as c'
                . ' ON l.category_id = c.id'
                . ' WHERE l.end_time > NOW()'
                . ' ORDER BY l.lot_time DESC'
                . ' LIMIT ' . $page_items
                . ' OFFSET ' . $offset;

            $result = mysqli_query($link, $sql);

            if ($result) {
                if (mysqli_num_rows($result)) {
                   $lot = mysqli_fetch_all($result, MYSQLI_ASSOC);

                    foreach ($lot as $key => $value) {
                        $sql = 'SELECT COUNT(id) as count'
                            . ' FROM rate'
                            . ' WHERE lot_id = ' . $value['lot_id'];
                        $result = mysqli_query($link, $sql);
                        $lot[$key]['count'] = mysqli_fetch_assoc($result)['count'];
                    }

                    foreach ($lot as $key => $value) {
                        $lot[$key]['rate_status_text'] = $value['count'] . get_noun_plural_form($value['count'], ' ставка ', ' ставки ', ' ставок ');
                    }

                    foreach ($lot as $key => $value) {
                        $lot[$key]['format_time'] = diff_time($value['end_time'])['format'];
                        $lot[$key]['timer_class'] = diff_time($value['end_time'])['timer_class'];
                    }

                    $category = '';
                    $page_title = "YetiCave | Открытые лоты";
                    $page_content = include_template('all-lots.php', [
                        'categories' => $categories,
                        'lot' => $lot,
                        'category' => $category,
                        'price' => 'price',
                        'pages_count' => $pages_count,
                        'pages' => $pages,
                        'cur_page' => $cur_page
                    ]);
                } else {
                    $error = 'В данный момент открытые аукционы отсутствуют';
                    $page_content = include_template('error.php', ['error' => $error]);
                    $page_title = 'YetiCave | Открытые лоты';
                }
            } else {
                $error = mysqli_error($link);
                $page_content = include_template('error.php', ['error' => $error]);
            }
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
    'user_name' => $user_name,
    'is_auth' => $is_auth
]);

print($layout_content);

