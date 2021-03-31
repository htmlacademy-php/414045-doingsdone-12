<?php

// подсчет количества задач

function get_count_task_in_project($tasks)
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

$projects_count = get_count_task_in_project(get_tasks($current_user_id));


// задачи выбранного проекта

function show_tasks_chosen_project($id_project, $projects, $tasks): array
{
    if (isset($_GET['id_chosen_project'])) {
        $chosen_project = $projects[$id_project];
        $chosen_project_tasks = [];
        foreach ($tasks as $task) {
            if ($chosen_project == $task['project']) {
                array_push($chosen_project_tasks, $task);
            }
        }
        return $chosen_project_tasks;
    } else {
        return $all_tasks = $tasks;
    }
}

// проверка выбранного проекта

function is_active_project($id_project)
{
    if (isset($_GET['id_chosen_project']) && $id_project == $_GET['id_chosen_project']) {
        return true;
    }
}

// проверка времени до истечения срока задачи

function is_importance_task($task_time): bool
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
        $file_url = "/" . $file_name;
        move_uploaded_file($_FILES['file']['tmp_name'], $file_path . $file_name);
    }
    return $file_url;
}

// добавляем новую задачу, если нет о

function add_new_task($current_user_id, $project_id, $task_name, $task_date)
{
//    форматируем дату, если её передали
    if (!$task_date) {
        $task_date = null;
    }
    // сохраняем файл
    $file_url = save_file();
    // запись в БД
    add_task_in_db($current_user_id, $project_id, $task_name, $file_url, $task_date);
}
