<?php

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
