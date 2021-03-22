<?php

// текущий пользователь
$current_user_id = 1;

require_once ('./functions/functions.php');
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);


// подсчет количества задач

$projects_count = get_projects_count($tasks);

// фильтрация спецсимволов html

function filter($input_data): string
{
    return htmlspecialchars($input_data);
}





// проверка на валидность id проекта

if (isset($_GET['id_chosen_project'])){
    if ($_GET['id_chosen_project'] > count($projects) && !is_int($_GET['id_chosen_project'])){
        header('Location: /error404/');
    } else {
        $id_chosen_project = intval($_GET['id_chosen_project']);
        $tasks = show_tasks_chosen_project($id_chosen_project, $projects, $tasks);
    }
}



// данные для main

$main_data = [
    'projects' => $projects,
    'tasks' => $tasks,
    'show_complete_tasks' => $show_complete_tasks,
    'projects_count' => $projects_count
];

// Данные для layout

$user_name = 'User';
$title_name = 'Дела в порядке';
$content = include_template('main.php', $main_data);

$layout_data = [
    'user' => $user_name,
    'title' => $title_name,
    'content' => $content
];

print(include_template('layout.php', $layout_data));
