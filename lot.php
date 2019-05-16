<?php
require_once('vendor/autoload.php');
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

            $sql = 'SELECT l.name as lot_name, l.start_price, l.lot_time, l.description, l.image, l.end_time as end_time, l.step_rate, l.author_id as author_id, c.name as category, MAX(r.price) as current_price FROM lot as l '
            . 'JOIN category as c '
            . 'ON l.category_id = c.id '
            . 'JOIN rate as r '
            . 'ON r.lot_id = l.id '
            . 'WHERE l.id = ' . $id_lot;

            $res = mysqli_query($link, $sql);

            if ($res) {
                $lot_array = mysqli_fetch_all($res, MYSQLI_ASSOC);
                $lot = $lot_array[0];

                $lot['format_time'] = $diff_time($lot['end_time'])['format'];
                $lot['timer_class'] = $diff_time($lot['end_time'])['timer_class'];


                $sql_table = 'SELECT r.rate_time, r.user_id, r.price as offer, r.lot_id, u.name as author_name FROM rate as r'
                        . ' JOIN user as u'
                        . ' ON r.user_id = u.id'
                        . ' WHERE lot_id = ' . $id_lot
                        . ' ORDER BY rate_time DESC'
                        . ' LIMIT 10';
                $res_table = mysqli_query($link, $sql_table);


                $table_rates_array = mysqli_fetch_all($res_table, MYSQLI_ASSOC);
                $table_rates = $table_rates_array;
                $count = count($table_rates);

                foreach ($table_rates as $key => $value) {
                    $now = 'now';
                    $time_rate = $value['rate_time'];

                    $diff = ceil((-strtotime($time_rate) + strtotime($now)) / 60);
                    $table_rates[$key]['rate_time_diff'] = $diff;
                    $table_rates[$key]['time_diff_text'] = $diff . get_noun_plural_form($diff, ' минута ', ' минуты ', ' минут ') . 'назад';
                }



                if ($lot['current_price'] == null) {
                    $lot['current_price'] = $lot['start_price'];
                    $cur_price = $lot['current_price'];
                } else {
                    $cur_price = $lot['current_price'];
                }

                if ($lot['step_rate'] !== NULL) {
                    $lot['minimal_price'] = $cur_price + $lot['step_rate'];
                } else {
                    $lot['minimal_price'] = $lot['current_price'];
                }

                if ($lot['lot_name']) {

                    if ($is_auth) {

                        $sql = 'SELECT * FROM rate'
                            . ' WHERE lot_id = ' . $id_lot
                            . ' ORDER BY price DESC'
                            . ' LIMIT 1';
                        $res = mysqli_query($link, $sql);

                        if ($res) {
                            $lot_rates_array = mysqli_fetch_all($res, MYSQLI_ASSOC);
                            $lot_rates = $lot_rates_array[0];

                            if ($lot_rates['user_id'] == $user_id) {
                                $page_content = include_template('lot.php', [
                                    'categories' => $categories,
                                    'lot' => $lot,
                                    'price' => $price,
                                    'showedTime' => $resultTime['time'],
                                    'class_item' => $resultTime['class'],
                                    'is_auth' => $is_auth,
                                    'user_flag' => true,
                                    'table_rates' => $table_rates,
                                    'count' => $count,
                                    'diff_time' => $diff_time,
                                    'user_id' => $user_id
                                ]);
                                $page_title = $lot['lot_name'];
                            } else {
                                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                    $new_rate = $_POST;

                                    $required = ['cost'];
                                    $errors = [];

                                    foreach ($required as $value) {
                                        if (empty($new_rate[$value])) {
                                            $errors[$value] = 'Заполните это поле';
                                        }
                                    }

                                    if (!empty($new_rate['cost']) && (int)$new_rate['cost'] < $lot['minimal_price']) {
                                        $errors['cost'] = 'Цена должна быть не меньше минимальной ставки!';
                                    }

                                    if (count($errors)) {
                                        $page_content = include_template('lot.php', [
                                            'categories' => $categories,
                                            'lot' => $lot,
                                            'price' => $price,
                                            'showedTime' => $resultTime['time'],
                                            'class_item' => $resultTime['class'],
                                            'is_auth' => $is_auth,
                                            'errors' => $errors,
                                            'id_lot' => $id_lot,
                                            'table_rates' => $table_rates,
                                            'count' => $count,
                                            'diff_time' => $diff_time,
                                            'user_id' => $user_id
                                        ]);
                                        $page_title = "Yeticave | Ошибка ставки";
                                    } else {
                                        $current_rate = $new_rate['cost'];
                                        $sql = 'INSERT INTO rate (rate_time, price, user_id, lot_id) VALUES (NOW(), ' . $current_rate . ', ' . $user_id . ', ' . $id_lot . ')';
                                        $res = mysqli_query($link, $sql);
                                        if ($res) {
                                            header("Location: /lot.php?id=" . $id_lot);
                                            exit();
                                        } else {
                                            $error = mysqli_error($link);
                                            $page_content = include_template('error.php', ['error' => $error]);
                                        }
                                    }
                                } else {
                                    $page_content = include_template('lot.php', [
                                            'categories' => $categories,
                                            'lot' => $lot,
                                            'price' => $price,
                                            'showedTime' => $resultTime['time'],
                                            'class_item' => $resultTime['class'],
                                            'is_auth' => $is_auth,
                                            'id_lot' => $id_lot,
                                            'table_rates' => $table_rates,
                                            'count' => $count,
                                            'diff_time' => $diff_time,
                                            'user_id' => $user_id
                                        ]);
                                        $page_title = $lot['lot_name'];
                                }
                            }
                        } else {
                            $error = mysqli_error($link);
                            $page_content = include_template('error.php', ['error' => $error]);
                        }
                    } else {
                        $page_content = include_template('lot.php', [
                            'categories' => $categories,
                            'lot' => $lot,
                            'price' => $price,
                            'showedTime' => $resultTime['time'],
                            'class_item' => $resultTime['class'],
                            'is_auth' => $is_auth,
                            'table_rates' => $table_rates,
                            'count' => $count,
                            'diff_time' => $diff_time,
                            'user_id' => $user_id
                        ]);
                        $page_title = $lot['lot_name'];
                    }
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

