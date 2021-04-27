<?php

// фильтрация спецсимволов html

function filter($input_data)
{
    return htmlspecialchars($input_data);
}

// проверка на существование проекта у пользователя
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

// проверка ошибок загрузки файла
function validate_file(): bool
{
    return ($_FILES['file']['error'] == 0 || $_FILES['file']['error'] == 4);
}

// валидация формы добавления задачи
function validate_task_form(
    $user_id,
    $task_name,
    $project_id,
    $task_date
): array {
    $errors = [];

    if (!validate_task_name($task_name)) {
        $errors['name'] = 'Введите название задачи!';
    }
    if (!validate_project($project_id, $user_id)) {
        $errors['project'] = 'Ошибка, выбранного проекта не существует!';
    }
    if (!validate_date($task_date)) {
        $errors['date']
            = 'Введитие дату в формате ГГГГ-ММ-ДД. Дата ранее создания задачи не может быть выбранна.';
    }
    if (!validate_file()) {
        $errors['file'] = 'Ошибка загрузки файла';
    }

    return $errors;
}

function validate_email()
{
    if (!$_POST['email']) {
        return false;
    }
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    return true;
}

function validate_password()
{
    if (!$_POST['password']) {
        return false;
    }

    return true;
}

function validate_login()
{
    if (!$_POST['name']) {
        return false;
    }

    return true;
}

function validate_registration_form()
{
    $errors = [];

    if (!validate_email() || email_exist($_POST['email'])) {
        $errors['email'] = 'не введён, или не корректно указан email';
    }
    if (!validate_login()) {
        $errors['name'] = 'введите логин';
    }
    if (!validate_password()) {
        $errors['password'] = 'введите пароль';
    }

    return $errors;
}

function validate_auth_form()
{
    $errors = [];

    if (!validate_email()) {
        $errors['email'] = 'некорректно указан email';
    }
    if (!validate_password()) {
        $errors['password'] = 'введите пароль';
    }

    return $errors;
}

function auth_user()
{
    $email = $_POST['email'];
    $password = $_POST['password'];
    $errors = [];

    if (!email_exist($email)) {
        $errors['email'] = 'пользователя с введённым вами email не существует';

        return $errors;
    }

    $user_data = get_user_auth_data($email);

    if (!password_verify($password, $user_data['password'])) {
        $errors['password'] = 'введён неверный пароль';

        return $errors;
    }

    return $errors;
}
