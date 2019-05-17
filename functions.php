<?php

require_once('vendor/autoload.php');

/**
 *Разделяет пробелом в переданном числе третий порядок
 *
 * Пример использования:
 * price(38000); // '38 000 ₽';
 *
 *@param string $argument Приводимое к заданному формату число в виде строки
 *
 *@return string $result Строка вида '38 000 ₽'
 */
function price(string $argument) : string {
    $finalPrice = ceil($argument);
    $result = number_format($finalPrice, 0, '.', ' ').' ₽';

    if ($finalPrice < 1000) {
        $result = $finalPrice. ' ₽';
    }
    return $result;
};

/**
 *Экранирует специальные символы
 *
 * Пример использования:
 * esc('<script>alert(1);</script>'); // '<script>alert(1);</script>';
 *
 *@param string $str Строка, которая впоследствии будет экранироваться
 *
 *@return string $result Строка с экранизированными символами
 */
function esc(string $str) : string {
    $text = htmlspecialchars($str);
    return $text;
};

/**
 * Возвращает массив с данными: необходимый класс для таймера и оставшееся время до наступления полуночи в формате ЧЧ:ММ
 *
 * Пример использования:
 * days_count(); // $tempArray = [['class'] => '', ['time'] => '10:35'];
 *
 *@return array $tempArray Ассоциативный массив, в котором по ключу 'class' лежит название класса для таймера, а по ключу 'time' - строка с временем, оставшимся до полуночи в формате ЧЧ:ММ
 */
function days_count() : array {
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
$resultTime = days_count();

/**
 *Показывает оставшееся до переданного момента времени количество часов, минут и секунд в формате ЧЧ:ММ:СС, а также задает класс для таймеров
 *
 * Пример использования:
 * diff_time('2019-05-20'); // $result_time = [['format'] => '110:23:10']
 *
 *@param string $end_time Строка, указывающая на определенный момент времени
 *
 *@return array $result_time Массив, в котором по ключу 'format' находится оставшееся до $end_time время в формате ЧЧ:ММ:СС, а по ключу 'span' может находиться строка 'Торги окончены', если в качестве параметра укзаан прошедший момент времени
 */
function diff_time(string $end_time) : array {
    if ($end_time !== null) {
        $now = 'now';
        $diff = strtotime($end_time) - strtotime($now);

        $hours = floor($diff / 3600);
        $minutes = floor(($diff - $hours * 3600) / 60);
        $seconds = $diff - $hours * 3600 - $minutes * 60;

        $result_time = [];

        if ($diff < 0) {
            $result_time['span'] = 'Торги окончены';
            $result_time['format'] = 'Аукцион закрыт';
            $result_time['timer_class'] = '';
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
    } else {
        $result_time['format'] = '';
        $result_time['timer_class'] = '';
    }

    return $result_time;
}

