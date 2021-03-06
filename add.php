<?php

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
    $error = mysqli_error($link);
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
$page_title = "Yeticave | Добавить лот";

if (!$is_auth) {
    $error = '403 Forbidden';
    $page_content = include_template('error.php', [
        'error' => $error,
        'is_auth' => $is_auth,
        'title' => $page_title,
        'categories' => $categories,
        'user_name' => $user_name
    ]);
    print($page_content);
    die();
}

if ((string)$_SERVER['REQUEST_METHOD'] !== 'POST') {
    $lot['category'] = '';
    $page_content = include_template('add.php', [
        'categories' => $categories,
        'lot' => $lot
    ]);
    $layout_content = include_template('layout.php', [
        'content' => $page_content,
        'title' => $page_title,
        'categories' => $categories,
        'user_name' => $user_name,
        'is_auth' => $is_auth
    ]);

    print($layout_content);
    die();
}

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
    if (is_date_valid($_POST['lot-date'])) {
        $lot_date = strtotime($_POST['lot-date']);
        $now = strtotime('now');
        $diff = floor(($lot_date - $now) / 86400);

        if ($diff < 0) {
            $errors['lot-date'] = 'Объявление должно быть доступно хотя бы 1 день';
        }
    } else {
        $errors['lot-date'] = 'Пожалуйста, введите дату в формате ГГГГ-ММ-ДД';
    }
}

if ((int)$_FILES['lot_image']['size'] > 0) {
    $tmp_name = $_FILES['lot_image']['tmp_name'];
    $path = uniqid() . $_FILES['lot_image']['name'];

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file_type = finfo_file($finfo, $tmp_name);

    if ($file_type !== "image/png" && $file_type !== "image/jpeg" && $file_type !== "image/") {
        $errors['lot_image'] = 'Загрузите картинку в формате jpeg/jpg/png';
    } else {
        move_uploaded_file($tmp_name, 'uploads/' . $path);
        $new_lot['path'] = 'uploads/' . $path;
    }
} else {
    $errors['lot_image'] = 'Вы не загрузили файл';
}

if (count($errors)) {
    $page_content = include_template('add.php', [
        'categories' => $categories,
        'lot' => $new_lot,
        'errors' => $errors,
        'dict' => $dict
    ]);
} else {
    $sql = 'INSERT INTO lot (lot_time, name, description, image, start_price, end_time, step_rate, author_id, category_id) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?)';

    $stmt = db_get_prepare_stmt($link, $sql, [$new_lot['lot-name'], $new_lot['message'], $new_lot['path'], $new_lot['lot-rate'], $new_lot['lot-date'], $new_lot['lot-step'], $user_id, $new_lot['category']]);
    $res = mysqli_stmt_execute($stmt);

    if ($res) {
        $lot_id = mysqli_insert_id($link);
        header("Location:lot.php?id=" . $lot_id);
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
