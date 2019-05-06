<?php

  $price = function($argument) {
    $finalPrice = ceil($argument);
    if ($finalPrice < 1000) {
      return $finalPrice. ' ₽';
    }
    else {
      return $finalPrice = number_format($finalPrice, 0, '.', ' ').' ₽';
    }
  };

function esc($str) {
  $text = htmlspecialchars($str);
  return $text;
};

$days_count = function () {
  $dt_end = date_create("tomorrow");
  $dt_now = date_create("now");
  $dt_diff = date_diff($dt_end, $dt_now);

  $end = 'tomorrow';
  $now = 'now';

  $diff = strtotime($end) - strtotime($now);

  if (floor($diff / 3600) <= 1) {
    $class = 'timer--finishing';
  } else {
    $class = '';
  }

  $tempArray = [
    'time' => date_interval_format($dt_diff, "%H:%I"),
    'class' => $class
  ];

  return $tempArray;
};


$resultTime = $days_count();



?>
