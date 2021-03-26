<?php

// получаем из БД список проектов текущего пользователя
function get_projects($user_id)
{
    $con = connect_db();
    $sql = "SELECT id, title FROM projects WHERE user_id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result_sql = mysqli_stmt_get_result($stmt);

    $projects = [];

    if (!$result_sql) {
        show_db_error();
    }

    $projects_sql = mysqli_fetch_all($result_sql);
    $new_key = ['id', 'name'];
    foreach ($projects_sql as $project) {
        array_push($projects, array_combine($new_key, $project));
    }
    return $projects;
}

// получаем из БД список задач текущего пользователя
function get_tasks($user_id)
{
    $con = connect_db();
    $sql = "SELECT t.title, time_end, p.title, is_done, file_src FROM tasks t JOIN projects p ON t.project_id = p.id WHERE t.user_id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result_sql = mysqli_stmt_get_result($stmt);

    $tasks = [];
    $tasks_key = ['task', 'date', 'project', 'done', 'file_src', 'file_name'];

    $tasks_result = mysqli_fetch_all($result_sql);
    foreach ($tasks_result as $task_result) {
        $file_name = ltrim($task_result[4], '/');
        array_push($task_result, $file_name);
        $task = array_combine($tasks_key, $task_result);
        if ($task['date']) {
            $task['date'] = date("d.m.Y", strtotime($task['date']));
        }
        array_push($tasks, $task);
    }
    return $tasks;
}

// добавляем новую задачу
function add_task($user_id, $project_id, $title, $file_src = null, $time_end = null){
    $con = connect_db();
    $sql = "INSERT INTO tasks (user_id, project_id, title, file_src, time_end) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'iisss', $user_id, $project_id, $title, $file_src, $time_end);
    mysqli_stmt_execute($stmt);
}
