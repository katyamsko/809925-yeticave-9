<?php

require_once('vendor/autoload.php');

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

$diff_time = function($end_time) {
    $now = 'now';
    $diff = strtotime($end_time) - strtotime($now);

    $hours = floor($diff / 3600);
    $minutes = floor(($diff - $hours * 3600) / 60);
    $seconds = $diff - $hours * 3600 - $minutes * 60;

    $result_time = [];

    if ($diff < 0) {
        $result_time['span'] = 'Торги окончены';
    } else {
        if ($hours < 1) {
            $result_time['timer_class'] = 'timer--finishing';
        } else {
            $result_time['timer_class'] = '';
        }

        if ($hours < 10 && $hours > 0) {
            $hours = '0' . $hours;
        } elseif ($hours == 0) {
            $hours = '00';
        }

        if ($minutes < 10) {
            $minutes = '0' . $minutes;
        } elseif ($minutes == 0) {
            $minutes = '00';
        }

        if ($seconds < 10) {
            $seconds = '0' . $seconds;
        } elseif ($seconds == 0) {
            $seconds = '00';
        }

        $result_time['format'] = $hours . ':' . $minutes . ':' . $seconds;
    }

    return $result_time;
}

?>
