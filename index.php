<?php

// текущий пользователь
$current_user_id = 1;

require_once (__DIR__ . '/functions/functions.php');



// проверка id выбранного проекта
check_selected_project_id($current_user_id);

$main_data = get_main_data($current_user_id);

// данные для form_task
$form_task = $main_data;
if (isset($errors)){
    $form_task['errors'] = $errors;
}


// Данные для layout
$user_name = 'User';
$title_name = 'Дела в порядке';
$content = include_template('main.php', $main_data);

// выбор страниц
if (isset($_GET['page']) && $_GET['page'] == 'add_task') {
        $content = include_template('form_task.php', $form_task);
}


$layout_data = [
    'user' => $user_name,
    'title' => $title_name,
    'content' => $content
];

print(include_template('layout.php', $layout_data));
