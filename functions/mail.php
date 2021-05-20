<?php

function send_reminder_for_tasks($name, $email, $mail_content)
{
    $transport = (new Swift_SmtpTransport(SMTP_HOST, SMTP_PORT))
        ->setUsername(SMTP_USER)
        ->setPassword(SMTP_PASSWORD);

    $message = (new Swift_Message('Уведомление от сервиса «Дела в порядке»'))
        ->setFrom([SMTP_USER => 'Дела в порядке'])
        ->setTo([$email => $name])
        ->setContentType("text/html")
        ->setBody($mail_content);


    $mailer = new Swift_Mailer($transport);
    $mailer->send($message);
}