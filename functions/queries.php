<?php

// поиск id выбранного проекта пользователя
function find_project_id($user_id, $project_id)
{
    $con = connect_db();
    $sql = "SELECT id FROM projects WHERE user_id = ? AND id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'ii', $user_id, $project_id);
    mysqli_stmt_execute($stmt);
    $result_sql = mysqli_stmt_get_result($stmt);

    if (!$result_sql) {
        show_db_error();
    }

    $project_id_sql = mysqli_fetch_all($result_sql);

    return $project_id_sql;
}

// получаем количество задач в проекте
function get_count_task_in_projects($user_id)
{
    $con = connect_db();
    $sql = "SELECT project_id, COUNT(*) AS 'count_tasks' FROM tasks WHERE user_id = ? GROUP BY project_id";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result_sql = mysqli_stmt_get_result($stmt);

    if (!$result_sql) {
        show_db_error();
    }

    $count_tasks = [];
    $count_tasks_sql = mysqli_fetch_all($result_sql);
    foreach ($count_tasks_sql as $value) {
        $count_tasks[$value[0]] = $value[1];
    }

    return $count_tasks;
}

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
    $sql = "SELECT t.title, time_end, p.id, p.title, is_done, file_src FROM tasks t JOIN projects p ON t.project_id = p.id WHERE t.user_id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result_sql = mysqli_stmt_get_result($stmt);

    $tasks = [];
    $tasks_key = ['task', 'date', 'project_id', 'project', 'done', 'file_src', 'file_name'];

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
function add_task_in_db($user_id, $project_id, $title, $file_src = null, $time_end = null)
{
    $con = connect_db();
    $sql = "INSERT INTO tasks (user_id, project_id, title, file_src, time_end) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'iisss', $user_id, $project_id, $title, $file_src, $time_end);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_error($stmt)) {
        print mysqli_stmt_error($stmt);
        print $time_end;
    }
}
