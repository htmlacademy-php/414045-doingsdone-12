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
    $count_tasks_sql = mysqli_fetch_all($result_sql, MYSQLI_ASSOC);
    foreach ($count_tasks_sql as $value) {
        $count_tasks[$value['project_id']] = $value['count_tasks'];
    }

    return $count_tasks;
}

// получаем из БД список проектов текущего пользователя
function get_projects($user_id)
{
    $con = connect_db();
    $sql = "SELECT id, title AS name FROM projects WHERE user_id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result_sql = mysqli_stmt_get_result($stmt);

    if (!$result_sql) {
        show_db_error();
    }

    $projects_sql = mysqli_fetch_all($result_sql, MYSQLI_ASSOC);

    return $projects_sql;
}

// получаем из БД список задач текущего пользователя
function get_user_tasks($user_id, $project_id = null)
{
    $con = connect_db();
    $sql = "SELECT t.title AS name, time_end, p.id AS project_id, p.title AS project, is_done, file_src FROM tasks t JOIN projects p ON t.project_id = p.id WHERE t.user_id = ?";
    if ($project_id) {
        $sql = "SELECT t.title AS name, time_end, p.id AS project_id, p.title AS project, is_done, file_src  FROM tasks t JOIN projects p ON t.project_id = p.id WHERE t.user_id = ? AND t.project_id = ?";
    }
    $stmt = mysqli_prepare($con, $sql);
    if (!$project_id) {
        mysqli_stmt_bind_param($stmt, 'i', $user_id);
    } else {
        mysqli_stmt_bind_param($stmt, 'ii', $user_id, $project_id);
    }
    mysqli_stmt_execute($stmt);
    $result_sql = mysqli_stmt_get_result($stmt);
    $tasks_result = mysqli_fetch_all($result_sql, MYSQLI_ASSOC);
    $tasks = [];

    foreach ($tasks_result as $task) {
        $file_name = 'файл не загружен';
        if ($task['file_src']) {
            $file_name = ltrim($task['file_src'], '/');
        }
        $task['file_name'] = $file_name;

        if ($task['time_end']) {
            $task['time_end'] = date("d.m.Y", strtotime($task['time_end']));
        }
        array_push($tasks, $task);
    }
    return $tasks;
}

// добавляем новую задачу
function add_task_in_db($user_id, $project_id, $title, $file_src, $time_end)
{
    if ($time_end == '') {
        $time_end = null;
    }
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
