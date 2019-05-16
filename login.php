<?php
require_once('vendor/autoload.php');
require_once('helpers.php');
require_once('data.php');
require_once('functions.php');
require_once('init.php');

session_start();

$page_title = "Yeticave | Ошибка";

if (!$link) {
    $error = mysqli_connect_error();
    $page_content = include_template('error.php', ['error' => $error]);
} else {
    if (isset($_SESSION['user'])) {
        header("Location: /index.php");
        exit();
    } else {
        $sql = 'SELECT * FROM category';
        $result = mysqli_query($link, $sql);

        if ($result) {
            $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

                if (count($errors)) {
                    $page_content = include_template('login.php', [
                        'categories' => $categories,
                        'form' => $form,
                        'errors' => $errors
                    ]);
                } else {
                    header("Location: /index.php");
                    exit();
                }
            } else {
                $page_content = include_template('login.php', [
                    'categories' => $categories
                ]);
                $page_title = "Yeticave | Вход на сайт";
            }
        }
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
