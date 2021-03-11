<?php

require('./helpers.php');
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

// текущий пользователь
$current_user_id = 1;

// функция проверки соединения с БД
function show_db_error() {
    print("Ошибка подключения к БД: " . mysqli_connect_error());
    die;
}

// подключаемся к БД
$con = mysqli_connect("localhost", "root", "root", "doingsdone");
if (!$con) {
    show_db_error();
}
mysqli_set_charset($con, "utf8");

// получаем из БД список проектов текущего пользователя

$safe_current_user_id = intval($current_user_id);
$sql = "SELECT title FROM projects WHERE user_id = '$safe_current_user_id'";
$result_sql = mysqli_query($con, $sql);

$projects = [];

if (!$result_sql) {
    show_db_error();
}

$projects_sql = mysqli_fetch_all($result_sql);
foreach ($projects_sql as $project) {
    array_push($projects, $project['0']);
}


// получаем из БД список задач текущего пользователя

$sql = "SELECT t.title, time_end, p.title, is_done FROM tasks t JOIN projects p ON t.project_id = p.id WHERE t.user_id = '$safe_current_user_id'";
$result_sql = mysqli_query($con, $sql);

$tasks = [];
$tasks_key = ['task', 'date', 'project', 'done'];


$tasks_result = mysqli_fetch_all($result_sql);
foreach ($tasks_result as $task_result) {
    $task = array_combine($tasks_key, $task_result);
    if($task['date'] != "0000-00-00 00:00:00") {
        $task['date'] = date("d.m.Y", strtotime($task['date']));
    } else {
        $task['date'] = null;
    }
    array_push($tasks, $task);
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

// задачи выбранного проекта

function show_tasks_chosen_project($id_project, $projects, $tasks): array
{
    if (isset($_GET['id_chosen_project'])){
        $chosen_project = $projects[$id_project];
        $chosen_project_tasks = [];
        foreach ($tasks as $task){
            if ($chosen_project == $task['project']){
                array_push($chosen_project_tasks, $task);
            }
        }
        return $chosen_project_tasks;
    } else {
        return $all_tasks = $tasks;
    }
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

// проверка выбранного проекта

function is_active_project($id_project)
{
    if (isset($_GET['id_chosen_project']) && $id_project == $_GET['id_chosen_project']){
        return true;
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
