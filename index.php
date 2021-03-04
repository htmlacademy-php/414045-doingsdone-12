<?php

require('./helpers.php');
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

// текущий пользователь
$curent_user_id = 1;

// подключаемся к БД
$con = mysqli_connect("localhost", "root", "root", "doingsdone");
if (!$con) {
    print("Ошибка подключения к БД: " . mysqli_connect_error());
}
mysqli_set_charset($con, "utf8");

// получаем из БД список проектов текущего пользователя

$sql = "SELECT title FROM projects WHERE user_id = '$curent_user_id'";
$result_sql = mysqli_query($con, $sql);

$projects = [];

if ($result_sql) {
    $projects_sql = mysqli_fetch_all($result_sql);
    foreach ($projects_sql as $project) {
        array_push($projects, $project['0']);
    }
} else {
    print("Ошибка подключения к БД: " . mysqli_connect_error());
}

// получаем из БД список задач текущего пользователя

$sql = "SELECT t.title, time_end, p.title, is_done FROM tasks t JOIN projects p ON t.project_id = p.id WHERE t.user_id = '$curent_user_id'";
$result_sql = mysqli_query($con, $sql);

$tasks = [];
$tasks_key = ['task', 'date', 'project', 'done'];

if ($result_sql) {
    $tasks_sql = mysqli_fetch_all($result_sql);
    foreach ($tasks_sql as $task_sql) {
        $task = array_combine($tasks_key, $task_sql);
        if($task['date'] != "0000-00-00 00:00:00") {
            $task['date'] = date("d.m.Y", strtotime($task['date']));
        } else {
            $task['date'] = null;
        }
        array_push($tasks, $task);
    }
} else {
    print("Ошибка подключения к БД: " . mysqli_connect_error());
}


// подсчет количества задач

function get_projects_count($tasks)
{
    return array_reduce($tasks, function ($carry, $item) {
        if (!isset($carry[$item['project']])) {
            $carry += [$item['project'] => 1];
        } else {
            $carry[$item['project']] += 1;
        }
        return $carry;
    }, []);
}

$projects_count = get_projects_count($tasks);

// фильтрация спецсимволов html

function filter($input_data): string
{
    return htmlspecialchars($input_data);
}

// проверка времени до истечения срока задачи

function is_importance_task($task_time): bool
{
    $current_time = time();
    $task_time = strtotime($task_time);
    $task_time_to_end_limit = 24 * 3600; //24 часа
    return $task_time - $current_time < $task_time_to_end_limit;
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
