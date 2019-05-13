<?php
require_once('helpers.php');
require_once('data.php');
require_once('functions.php');
require_once('init.php');

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

            if ($search) {
                $search_string = trim($search);
                $sql = 'SELECT l.id as lot_id, l.name as lot_name, l.name, l.image as lot_image, l.end_time as lot_time, l.start_price as start_price, c.name as category FROM lot as l '
                  . ' JOIN category as c'
                  . ' ON l.category_id = c.id'
                  . ' WHERE MATCH(l.name, description) AGAINST(?)';

                $stmt = db_get_prepare_stmt($link, $sql, [$search_string]);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);

                foreach ($lots as $key => $value) {
                    $lots[$key]['lot_time'] = $diff_time($value['lot_time']);
                }

                if (isset($lots[0])) {
                   $page_content = include_template('search.php', [
                        'lots' => $lots,
                        'categories' => $categories,
                        'search' => $search
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
    'ads' => $ads,
    'price' => $price,
    'user_name' => $user_name,
    'is_auth' => $is_auth
]);

print($layout_content);
