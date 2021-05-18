<?php

function send_reminder_for_tasks($name, $email, $mail_content)
{
    $transport = (new Swift_SmtpTransport('smtp.timeweb.ru', 25))
        ->setUsername('doingsdone@ci65243.tmweb.ru')
        ->setPassword('9K8TpC8T');

    $message = (new Swift_Message('Уведомление от сервиса «Дела в порядке»'))
        ->setFrom(['doingsdone@ci65243.tmweb.ru' => 'Дела в порядке'])
        ->setTo([$email => $name])
        ->setContentType("text/html")
        ->setBody($mail_content);


    $mailer = new Swift_Mailer($transport);
    $mailer->send($message);
}