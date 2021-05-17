<?php

function send_reminder_for_tasks($user_name, $user_email, $tasks)
{
    $user_tasks = [];
    foreach ($tasks as $task) {
        array_push($user_tasks, $task['title']);
    }

    $task_list = '. У вас запланирована задача: ' . $user_tasks[0];

    if (count($user_tasks) > 1)
    {
        $task_list = '. У вас запланированы задачи:';
        foreach ($user_tasks as $task) {
            $task_list .= ' ' . $task . ',';
        }
        $task_list = trim($task_list, ',');
    }

    $transport = (new Swift_SmtpTransport('smtp.timeweb.ru', 25))
        ->setUsername('doingsdone@ci65243.tmweb.ru')
        ->setPassword('9K8TpC8T');

    $message = (new Swift_Message('Уведомление от сервиса «Дела в порядке»'))
        ->setFrom(['doingsdone@ci65243.tmweb.ru' => 'Дела в порядке'])
        ->setTo([$user_email => $user_name])
        ->setBody('Уважаемый, ' . $user_name . $task_list . ' на ' . date('d-m-Y') . '.')
    ;


    $mailer = new Swift_Mailer($transport);
    $mailer->send($message);
}