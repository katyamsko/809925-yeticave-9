<?php

require_once('vendor/autoload.php');
require_once('init.php');
require_once('helpers.php');

session_start();

if (isset($_SESSION['user'])) {
    $is_auth = true;
    $user_name = $_SESSION['user']['name'];
    $user_id = $_SESSION['user']['id'];
    $user_email = $_SESSION['user']['email'];
} else {
    $is_auth = false;
    $user_name = "";
}

$sql = 'SELECT * FROM lot'
    . ' WHERE winner_id IS NULL'
    . ' AND end_time < NOW()';

$result = mysqli_query($link, $sql);

if ($result && $is_auth && mysqli_num_rows($result)) {
    $closed_lots = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach ($closed_lots as $key => $value) {
        $sql = 'SELECT * FROM rate'
            . ' WHERE lot_id = ' . $value['id']
            . ' ORDER BY price DESC';
        $result = mysqli_query($link, $sql);
        $winner_id = mysqli_fetch_assoc($result)['user_id'];

        if ((int)$winner_id !== 0) {
            $sql = 'UPDATE lot'
            . ' set winner_id = ' . $winner_id
            . ' where id = ' . $value['id'];

            $result = mysqli_query($link, $sql);
            $result = true;

            if($result) {
                if ((int)$user_id === (int)$winner_id) {
                    $transport = new Swift_SmtpTransport("phpdemo.ru", 25);
                    $transport->setUsername("keks@phpdemo.ru");
                    $transport->setPassword("htmlacademy");

                    $mailer = new Swift_Mailer($transport);

                    $logger = new Swift_Plugins_Loggers_ArrayLogger();
                    $mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));

                    $recipients =  $user_email;

                    $message = new Swift_Message();
                    $message->setSubject("Ваша ставка победила");
                    $message->setFrom(['keks@phpdemo.ru' => 'Yeticave']);
                    $message->setBcc($recipients);

                    $msg_content = include_template('email.php', [
                        'user_name' => $user_name,
                        'lot_id' => $lot_id,
                        'lot' => $closed_lots
                    ]);
                    $message->setBody($msg_content, 'text/html');

                    $result = $mailer->send($message);
                }
            }
        }
    }
}

