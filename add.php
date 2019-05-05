<?php
require_once('helpers.php');
require_once('data.php');
require_once('functions.php');
require_once('init.php');

$page_title = "Yeticave | Ошибка";

if (!$link) {
    $error = mysqli_connect_error();
    $page_content = include_template('error.php', ['error' => $error]);
} else {
    $sql = 'SELECT * FROM category';
    $result = mysqli_query($link, $sql);

    if ($result) {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $page_content = include_template('add.php', ['categories' => $categories]);
        $page_title = "Yeticave | Добавить лот";

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $new_lot = $_POST;

            $required = ['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date'];
            $dict = ['lot-name' => 'Название товара', 'category' => 'Категория', 'message' => 'Описание товара', 'lot_image' => 'Фото товара', 'lot-rate' => 'Начальная цена', 'lot-step' => 'Шаг ставки', 'lot-date' => 'Дата окончания торгов'];
            $errors = [];

            foreach ($required as $key) {
                if (empty($_POST[$key])) {
                    $errors[$key] = 'Это поле надо заполнить';
                }
            }

            if (!empty($_POST['lot-rate']) && (int)$_POST['lot-rate'] <= 0) {
                $errors['lot-rate'] = 'Введите число > 0';
            }

            if (!empty($_POST['lot-step']) && (int)$_POST['lot-step'] <= 0) {
                $errors['lot-step'] = 'Введите число > 0';
            }

            if (!empty($_POST['lot-date'])) {
                $date = $_POST['lot-date'];

                if (strlen($date) != 10 || $date[4] !== '-' || $date[7] !== '-') {
                    $errors['lot-date'] = 'Следуйте указанному формату';
                } else {
                    if ((int)substr($date, 0, 4) < 2019 || (int)substr($date, 5, 2) <= 0 || (int)substr($date, 5, 2) > 12 || (int)substr($date, -2, 2) <= 0 || (int)substr($date, -2, 2) > 31) {
                        $errors['lot-date'] = 'Введите реальную дату';
                    } else {
                        $lot_date = strtotime($_POST['lot-date']);
                        $now = strtotime('now');
                        $diff = floor(($lot_date - $now) / 86400);

                        if ($diff < 0) {
                            $errors['lot-date'] = 'Объявление должно быть доступно хотя бы 1 день';
                        }
                    }
                }
            }

            if ($_FILES['lot_image']['size'] > 0) {
                $tmp_name = $_FILES['lot_image']['tmp_name'];
                $path = uniqid() . $_FILES['lot_image']['name'];

                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $file_type = finfo_file($finfo, $tmp_name);

                if ($file_type !== "image/png" && $file_type !== "image/jpeg" && $file_type !== "image/") {
                    $errors['file'] = 'Загрузите картинку в формате GIF';
                } else {
                    move_uploaded_file($tmp_name, 'uploads/' . $path);
                    $new_lot['path'] = 'uploads/' . $path;
                }

            } else {
                $errors['file'] = 'Вы не загрузили файл';
            }

            if (count($errors)) {
                $page_content = include_template('add.php', [
                    'categories' => $categories,
                    'lot' => $new_lot,
                    'errors' => $errors,
                    'dict' => $dict
                ]);

            } else {

                $sql = 'INSERT INTO lot (lot_time, name, description, image, start_price, end_time, step_rate, author_id, category_id) VALUES (NOW(), ?, ?, ?, ?, ?, ?, 1, ?)';

                $stmt = db_get_prepare_stmt($link, $sql, [$new_lot['lot-name'], $new_lot['message'], $new_lot['path'], $new_lot['lot-rate'], $new_lot['lot-date'], $new_lot['lot-step'], $new_lot['category']]);
                $res = mysqli_stmt_execute($stmt);

                if ($res) {
                    $lot_id = mysqli_insert_id($link);
                    header("Location:lot.php?id=" . $lot_id);
                }
            }
        } else {
            $page_content = include_template('add.php', [
                'categories' => $categories
            ]);
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
    'user_name' => $user_name,
    'is_auth' => $is_auth
]);

print($layout_content);
