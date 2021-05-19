<?php

require_once '../bootstrap.php';

$users_data = get_users_data();

foreach ($users_data as $user_data) {
    $mail_data = get_mail_data($user_data);
    if (!$mail_data['mail_text']) {
        continue;
    }
    $mail_content = include_template('mail.php', $mail_data);
    send_reminder_for_tasks(
        $user_data['name'],
        $user_data['email'],
        $mail_content
    );
}