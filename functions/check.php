<?php

// фильтрация спецсимволов html

function filter($input_data): string
{
    return htmlspecialchars($input_data);
}

// проверка на валидность id проекта

if (isset($_GET['id_chosen_project'])){
    if ($_GET['id_chosen_project'] > count(get_projects($current_user_id)) && !is_int($_GET['id_chosen_project'])){
        header('Location: /error404/');
    } else {
        $id_chosen_project = intval($_GET['id_chosen_project']);
        $tasks = show_tasks_chosen_project($id_chosen_project, get_projects($current_user_id), get_tasks($current_user_id));
    }
}

// валидация названия задачи
function validate_task_name($name){
    if ($name && is_string($name)) {
        return true;
    }
}
// валидация формата даты
function validate_date($date, $format = 'Y-m-d')
{
    $d = date_create_from_format($format, $date);
    return $d && date_format($d, $format) == $date && $date >= date('Y-m-d');
}
// валидация id проекта
function validate_project($id, $user_id) {
    $projects = get_projects($user_id);
    $projects_id = [];
    foreach ($projects as $key => $project){
        array_push($projects_id, $project['id']);
    }
    return in_array($id, $projects_id);
}



