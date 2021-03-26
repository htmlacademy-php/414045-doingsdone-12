<?php

// текущий пользователь
$current_user_id = 1;

require_once ('./functions/functions.php');

// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

// данные для main
$projects = get_projects($current_user_id);
$tasks = get_tasks($current_user_id);


$main_data = [
    'projects' => $projects,
    'tasks' => $tasks,
    'show_complete_tasks' => $show_complete_tasks,
    'projects_count' => $projects_count
];

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
if (isset($_GET['page'])) {
    if (filter($_GET['page']) == 'add_task') {
        $content = include_template('form_task.php', $form_task);
    }
}

$layout_data = [
    'user' => $user_name,
    'title' => $title_name,
    'content' => $content
];

print(include_template('layout.php', $layout_data));
