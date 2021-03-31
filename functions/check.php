<?php

// фильтрация спецсимволов html

function filter($input_data): string
{
    return htmlspecialchars($input_data);
}

// проверка на валидность id проекта
function check_selected_project_id() {
    if (isset($_GET['id_chosen_project'])){
        if ($_GET['id_chosen_project'] > count(get_projects($current_user_id)) && !is_int($_GET['id_chosen_project'])){
            header('Location: /error404/');
        } else {
            $id_chosen_project = intval($_GET['id_chosen_project']);
            $tasks = show_tasks_chosen_project($id_chosen_project, get_projects($current_user_id), get_tasks($current_user_id));
            return $tasks;
        }
    }
}

// валидация названия задачи
function validate_task_name(){
    if ($_POST['name'] && is_string($_POST['name'])) {
        return true;
    }
}

// валидация id проекта
function validate_project($project_id, $user_id) {
    $projects = get_projects($user_id);
    $projects_with_id = [];
    foreach ($projects as $key => $project){
        array_push($projects_with_id, $project['id']);
    }
    if (isset($_POST['project_id']) && in_array($project_id, $projects_with_id)) {
        return true;
    }
}

// проверка формата даты
function check_format_date($date, $format = 'Y-m-d') {
    $d = date_create_from_format($format, $date);
    return $d && date_format($d, $format) == $date && $date >= date('Y-m-d');
}

// валидация даты
function validate_date($date) {
    if ($date) {
        if (check_format_date($date)){
            return true;
        }
    } else {
        return true;
    }
}

// валидация формы добавления задачи
function validate($user_id, $task_name, $project_id, $task_date){
    $errors = [];

    if (!validate_task_name($task_name)) {
        $errors['name'] = 'Введите название задачи!';
    }
    if (!validate_project($project_id, $user_id)) {
        $errors['project'] = 'Ошибка, выбранного проекта не существует!';
    }
    if (!validate_date($task_date)) {
        $errors['date'] = 'Введитие дату в формате ГГГГ-ММ-ДД. Дата ранее создания задачи не может быть выбранна.';
    }

    return $errors;
}
