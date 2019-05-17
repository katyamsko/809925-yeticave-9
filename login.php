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

if (isset($_SESSION['user'])) {
    header("Location: /index.php");
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

if ((string)$_SERVER['REQUEST_METHOD'] !== 'POST') {
    $page_content = include_template('login.php', [
        'categories' => $categories
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

$form = $_POST;

$required = ['email', 'password'];
$errors = [];

foreach ($required as $value) {
    if (empty($form[$value])) {
        $errors[$value] = 'Это поле необходимо заполнить';
    }
}

$email = mysqli_real_escape_string($link, $form['email']);
$sql = "SELECT * FROM user WHERE email = '$email'";
$res = mysqli_query($link, $sql);

$user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

if (!count($errors)) {
    if ($user) {
        if (password_verify($form['password'], $user['password'])) {
            $_SESSION['user'] = $user;
        } else {
            $errors['password'] = 'Вы ввели неверный пароль';
        }
    } else {
        $errors['email'] = 'Такой пользователь не найден';
    }
}

if (!count($errors)) {
    header("Location: /index.php");
    exit();
}

$page_content = include_template('login.php', [
    'categories' => $categories,
    'form' => $form,
    'errors' => $errors
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => $page_title,
    'categories' => $categories,
    'user_name' => $user_name,
    'is_auth' => $is_auth
]);

print($layout_content);
