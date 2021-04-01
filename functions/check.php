<?php

// фильтрация спецсимволов html

function filter($input_data)
{
    return htmlspecialchars($input_data);
}

// проверка на валидность id проекта
function check_selected_project_id($current_user_id)
{
    if (isset($_GET['id_chosen_project'])) {
        if (!find_project_id($current_user_id, $_GET['id_chosen_project'])) {
            return header('Location: /error404/');
        }
    }
}

// валидация названия задачи
function validate_task_name($task_name)
{
    return $task_name && is_string($task_name);
}

// валидация id проекта
function validate_project($project_id, $user_id)
{
    return find_project_id($user_id, $project_id);
}

// проверка формата даты
function check_format_date($date, $format = 'Y-m-d'): bool
{
    $d = date_create_from_format($format, $date);
    return $d && date_format($d, $format) == $date && $date >= date('Y-m-d');
}

// валидация даты
function validate_date($date): bool
{
    if (!$date) {
        return true;
    }
    return check_format_date($date);
}

// валидация формы добавления задачи
function validate($user_id, $task_name, $project_id, $task_date): array
{
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
