<?php

// задачи выбранного проекта

function show_tasks(): array
{
    if (!isset($_GET['id_chosen_project'])) {
        return get_user_tasks();
    }

    return get_user_tasks($_GET['id_chosen_project']);
}

// проверка выбранного проекта

function is_active_project($id_project): bool
{
    return isset($_GET['id_chosen_project'])
        && $id_project == $_GET['id_chosen_project'];
}

// проверка времени до истечения срока задачи

function is_task_important($task_time): bool
{
    $current_time = time();
    $task_time = strtotime($task_time);
    $task_time_to_end_limit = 24 * 3600; //24 часа

    return $task_time - $current_time < $task_time_to_end_limit;
}

// сохраняем файл
function save_file()
{
    $file_url = null;
    if ($_FILES['file']['name']) {
        $file_name = $_FILES['file']['name'];
        $file_path = './';
        $file_url = '/'.$file_name;
        move_uploaded_file($_FILES['file']['tmp_name'], $file_path.$file_name);
    }

    return $file_url;
}

// добавляем новую задачу
function add_new_task($current_user_id, $project_id, $task_name, $task_date)
{
    // сохраняем файл
    $file_url = save_file();

    // запись в БД
    add_task_in_db(
        $current_user_id,
        $project_id,
        $task_name,
        $file_url,
        $task_date
    );
}
