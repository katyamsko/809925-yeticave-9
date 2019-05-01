<?php
require_once('helpers.php');
require_once('data.php');
require_once('functions.php');
require_once('init.php');


 if (isset($_GET['id'])) {
    $id_lot = $_GET['id'];
}

if (!$link) {
    $error = mysqli_connect_error();
    print($error);
} else {
    $sql = 'SELECT * FROM category';
    $result = mysqli_query($link, $sql);

    if ($result) {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($link);
        print($error);
        die();
    }
     $sql = 'SELECT l.name as lot_name, l.lot_time, l.description, l.image, l.end_time, c.name as category, MAX(r.price) as current_price FROM lot as l '
          . 'JOIN category as c '
          . 'ON l.category_id = c.id '
         . 'JOIN rate as r '
          . 'ON r.lot_id = l.id '
          . 'WHERE l.id = ' . $id_lot;

     if ($res = mysqli_query($link, $sql)) {
         $lot_array = mysqli_fetch_all($res, MYSQLI_ASSOC);
         $lot = $lot_array[0];

         print($lot[0]['lot_name']."<br>");
         print($hren['lot_name']);

      $page_content = include_template('404.php', [
            'categories' => $categories,
             'lot' => $lot,
             'price' => $price,
             'showedTime' => $resultTime['time'],
            'class_item' => $resultTime['class']
        ]);
    }
     else {
         $error = mysqli_error($link);
         print($error);
         die();
     }
 }



// $page_content = include_template('lot.php', [
//     'categories' => $categories,
//     'ads' => $ads,
//     'price' => $price,
//     'showedTime' => $resultTime['time'],
//     'class_item' => $resultTime['class']
// ]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Главная',
    'categories' => $categories,
    'ads' => $ads,
    'price' => $price,
    'user_name' => $user_name,
    'is_auth' => $is_auth
]);

print($layout_content);

