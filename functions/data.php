<?php
// функция получения данных для шаблона main
function get_main_data($current_user_id)
{
    // показывать или нет выполненные задачи
    $show_complete_tasks = rand(0, 1);

    $main_data = [
        'projects' => get_projects($current_user_id),
        'tasks' => show_tasks($current_user_id),
        'show_complete_tasks' => $show_complete_tasks,
        'projects_count' => get_count_task_in_projects($current_user_id)
    ];
    return $main_data;
}

// функция получения данных для шаблона form_task
function get_form_task($current_user_id, $errors = null)
{
    $form_task_data = get_main_data($current_user_id);
    if (isset($errors)) {
        $form_task_data['errors'] = $errors;
    }
    return $form_task_data;
}

function get_form_registration($errors = null)
{
    $form_registration_data = [];
    if ($errors !== null) {
        $form_registration_data['errors'] = $errors;
    }
    return $form_registration_data;
}

function get_form_auth_data($errors = null)
{
    $form_auth_data = [];
    if ($errors !== null) {
        $form_auth_data['errors'] = $errors;
    }
    return $form_auth_data;
}

// функция получения данных для шаблона layout
function get_layout_data($errors = null)
{
    $current_user_id = null;
    if (isset($_SESSION['user_id'])) {
        $current_user_id = $_SESSION['user_id'];
    }

    $main_data = get_main_data($current_user_id);

    // Данные для layout
    $user['id'] = $current_user_id;
    $title_name = 'Дела в порядке';
    $content = include_template('main.php', $main_data);

    // проверка id выбранного проекта
    check_selected_project_id($current_user_id);

    // выбор страниц
    if (!$current_user_id) {
        $content = include_template('guest.php');
    }
    if (isset($_GET['page']) && $_GET['page'] == 'auth') {
        $form_auth_data = get_form_auth_data($errors);
        $content = include_template('auth.php', $form_auth_data);
    }
    if (isset($_GET['page']) && $_GET['page'] == 'add_task') {
        $form_task_data = get_form_task($current_user_id, $errors);
        $content = include_template('form_task.php', $form_task_data);
    }
    if (isset($_GET['page']) && $_GET['page'] == 'registration') {
        $form_registration_data = get_form_registration($errors);
        $content = include_template('form_registration.php', $form_registration_data);
    }

    $layout_data = [
        'user' => $user,
        'title' => $title_name,
        'content' => $content
    ];
    return $layout_data;
}
