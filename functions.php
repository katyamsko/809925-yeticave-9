<?php

  $price = function($argument) {
    $finalPrice = ceil($argument);
    if ($finalPrice < 1000) {
      return $finalPrice. ' ₽';
    }
    else {
    //1й вариант
      return $finalPrice = number_format($finalPrice, 0, '.', ' ').' ₽';
    // 2-й вариант
    //  $num = (string)$finalPrice;
    //  $length = strlen($num);
    //  $left = substr($num, 0, $length - 3);
    //  $right = substr($num, -3);
    //  return $left.' '.$right.' ₽';
    }
  };

function esc($str) {
  $text = htmlspecialchars($str);
  return $text;
}
 ?>
