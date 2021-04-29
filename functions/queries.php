<?php

/**
 * Поиск id выбранного проекта пользователя
 *
 * @param int $user_id    id пользователя
 * @param int $project_id id проекта
 *
 * @return array
 */
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

/**
 * Получает количество задач в проектах
 *
 * @param int $user_id id пользователя
 *
 * @return array количество задач в проектах
 */
function get_count_task_in_projects($user_id)
{
    $con = connect_db();
    $sql
        = "SELECT project_id, COUNT(*) AS 'count_tasks' FROM tasks WHERE user_id = ? GROUP BY project_id";
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

/**
 * Получает из БД список проектов текущего пользователя
 *
 * @param int $user_id id пользователя
 *
 * @return array проекты пользователя
 */
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

/**
 * Получает из БД список задач текущего пользователя
 *
 * Получет задачи пользователя по id проекта. Если id проекта равен null, получает все задачи пользователя.
 *
 * @param int      $user_id    id пользователя
 * @param int|null $project_id id проета
 *
 * @return array задачи пользователя
 */
function get_user_tasks($user_id, $project_id)
{
    $con = connect_db();
    $sql
        = "SELECT t.title AS name, time_end, p.id AS project_id, p.title AS project, is_done, file_src FROM tasks t JOIN projects p ON t.project_id = p.id WHERE t.user_id = ?";
    if ($project_id) {
        $sql
            = "SELECT t.title AS name, time_end, p.id AS project_id, p.title AS project, is_done, file_src  FROM tasks t JOIN projects p ON t.project_id = p.id WHERE t.user_id = ? AND t.project_id = ?";
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

/**
 * Добавляет новую задачу в БД
 *
 * @param int         $user_id    id пользователя
 * @param int         $project_id id проекта
 * @param string      $title      название задачи
 * @param string|null $file_src   путь к файлу
 * @param string|null $time_end   дедлайн задачи
 *
 * @return bool|string
 */
function add_task_in_db($user_id, $project_id, $title, $file_src, $time_end)
{
    if ($time_end == '') {
        $time_end = null;
    }
    $con = connect_db();
    $sql
        = "INSERT INTO tasks (user_id, project_id, title, file_src, time_end) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        'iisss',
        $user_id,
        $project_id,
        $title,
        $file_src,
        $time_end
    );
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_error($stmt)) {
        return print mysqli_stmt_error($stmt);
    }

    return true;
}

/**
 * Проверяет есть ли email в БД
 *
 * @param string $email email пользователя
 *
 * @return bool
 */
function email_exist($email)
{
    $con = connect_db();
    $sql = "SELECT COUNT(*) AS exist FROM users WHERE email = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result_sql = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_assoc($result_sql);

    return $result['exist'] > 0;
}

/**
 * Сохраняет нового пользователя в БД
 *
 * @param string $email    email пользователя
 * @param string $password хеш пароля
 * @param string $name     имя пользователя
 *
 * @return bool|string
 */
function add_new_user($email, $password, $name)
{
    $password = password_hash($password, PASSWORD_DEFAULT);
    $con = connect_db();
    $sql = "INSERT INTO users (email, password, name) VALUES(?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'sss', $email, $password, $name);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_error($stmt)) {
        return print mysqli_stmt_error($stmt);
    }

    return true;
}

/**
 * Аутентификация пользователя
 *
 * @param string $email email пользователя
 *
 * @return array|string
 */
function get_user_auth_data($email)
{
    $con = connect_db();
    $sql = "SELECT email, password FROM users WHERE email = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result_sql = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_assoc($result_sql);

    if (mysqli_stmt_error($stmt)) {
        return print mysqli_stmt_error($stmt);
    }

    return $result;
}

/**
 * Получает id пользователя
 *
 * @param string $email email пользователя
 *
 * @return int|string
 */
function get_user_id($email)
{
    $con = connect_db();
    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result_sql = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_assoc($result_sql);

    if (mysqli_stmt_error($stmt)) {
        return print mysqli_stmt_error($stmt);
    }

    return $result['id'];
}

/**
 * Поиск задачи
 *
 * @param int    $user_id   id пользователя
 * @param string $task_name имя задачи, поисковый запрос
 *
 * @return array|string
 */
function get_looking_for_task($user_id, $task_name)
{
    $con = connect_db();
    $sql
        = "SELECT t.title AS name, time_end, p.id AS project_id, p.title AS project, is_done, file_src FROM tasks t JOIN projects p ON t.project_id = p.id WHERE t.user_id = ? AND MATCH(t.title) AGAINST(?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'is', $user_id, $task_name);
    mysqli_stmt_execute($stmt);
    $result_sql = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_all($result_sql, MYSQLI_ASSOC);

    if (mysqli_stmt_error($stmt)) {
        return print mysqli_stmt_error($stmt);
    }

    $tasks = [];

    foreach ($result as $task) {
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
