<?php

require_once '../bootstrap.php';

$users = get_users_data();

foreach ($users as $user) {
    $tasks = get_today_tasks($user['id']);
    if ($tasks) {
        send_reminder_for_tasks($user['name'], $user['email'], $tasks);
    }
}