<?php
    require_once 'functions.php';

    $link = mysqli_connect("yeticave", "root", "", "yeticave");
    mysqli_set_charset($link, "utf8");

$categories = [];
$content = '';
