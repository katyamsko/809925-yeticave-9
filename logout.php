<?php
require_once('vendor/autoload.php');

session_start();

$_SESSION = [];

header("Location: /index.php");
exit();

?>
