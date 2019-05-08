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

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $new_user = $_POST;

            $required = ['email', 'password', 'name', 'message'];
            $dict = ['email' => 'Почтовый ящик', 'password' => 'Пароль', 'name' => 'Имя', 'message' => 'Контактные данные'];
            $errors = [];

            foreach ($required as $key) {
                if (empty($_POST[$key])) {
                    $errors[$key] = 'Это поле надо заполнить';
                }
            }

            if ($_FILES['avatar']['size'] > 0) {
                $tmp_name = $_FILES['avatar']['tmp_name'];
                $path = uniqid() . $_FILES['avatar']['name'];

                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $file_type = finfo_file($finfo, $tmp_name);

                if ($file_type !== "image/png" && $file_type !== "image/jpeg" && $file_type !== "image/") {
                    $errors['avatar'] = 'Загрузите картинку в формате jpeg/jpg/png';
                } else {
                    move_uploaded_file($tmp_name, 'uploads/' . $path);
                    $new_lot['path'] = 'uploads/' . $path;
                }

            }

            if (count($errors)) {
                $page_content = include_template('sign-up.php', [
                    'categories' => $categories,
                    'new_user' => $new_user,
                    'errors' => $errors,
                    'dict' => $dict
                ]);

            } else {

                $email = mysqli_real_escape_string($link, $_POST['email']);
                $sql = "SELECT id FROM user WHERE email = '$email'";
                $res = mysqli_query($link, $sql);

                if ($res) {
                    if (mysqli_num_rows($res) > 0) {
                        $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
                    } else {
                        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                        $sql = 'INSERT INTO user (reg_time, email, name, password, contacts) VALUES (NOW(), ?, ?, ?, ?)';
                        $stmt = db_get_prepare_stmt($link, $sql, [$_POST['email'], $_POST['name'], $password, $_POST['message']]);
                        $res = mysqli_stmt_execute($stmt);
                    }

                    if ($res) {
                        if (empty($errors)) {
                            header("Location: /index.php");
                            exit();
                        } else {
                            $page_content = include_template('sign-up.php', [
                                'categories' => $categories,
                                'new_user' => $new_user,
                                'errors' => $errors,
                                'dict' => $dict
                            ]);
                        }
                    } else {
                        $error = mysqli_error($link);
                        $page_content = include_template('error.php', ['error' => $error]);
                    }

                } else {
                    $error = mysqli_error($link);
                    $page_content = include_template('error.php', ['error' => $error]);
                }
            }
        } else {
            $page_content = include_template('sign-up.php', [
                'categories' => $categories
            ]);
            $page_title = "Yeticave | Регистрация на сайте";
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
