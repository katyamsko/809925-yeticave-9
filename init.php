<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('vendor/autoload.php');
require_once 'functions.php';

$link = mysqli_connect("yeticave", "root", "", "yeticave");
mysqli_set_charset($link, "utf8");

$categories = [];
$content = '';
