<?php

// функция получения данных для шаблона main
function get_main_data()
{
    // показывать или нет выполненные задачи
    $show_complete_tasks = rand(0, 1);
    $user_id = $_SESSION['user_id'];
    $chosen_project_id = $_GET['id_chosen_project'] ?? null;
    $user_tasks = !isset($_GET['search']) ? show_tasks($user_id) : null;
    $found_tasks = isset($_GET['search']) ? search_task($user_id) : null;
    $nothing_found_message = "";

    if (isset($_GET['search']) && !$found_tasks) {
        $nothing_found_message = "Ничего не найдено по вашему запросу";
    }

    $main_data = [
        'projects' => get_projects($user_id),
        'chosen_project_id' => $chosen_project_id,
        'user_tasks' => $user_tasks,
        'found_tasks' => $found_tasks,
        'show_complete_tasks' => $show_complete_tasks,
        'projects_count' => get_count_task_in_projects($user_id),
        'nothing_found_message' => $nothing_found_message,
    ];

    return $main_data;
}

// функция получения данных для шаблона form_task
function get_form_task($user_id, $errors = null)
{
    $form_task_data = get_main_data($user_id);
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
    $user_id = $_SESSION['user_id'] ?? null;

    $main_data = get_main_data($user_id);

    // Данные для layout
    $user['id'] = $user_id;
    $title_name = 'Дела в порядке';
    $content = include_template('main.php', $main_data);

    // проверка id выбранного проекта
    check_selected_project_id($user_id);

    // выбор страниц
    if (!$user_id) {
        $content = include_template('guest.php');
    }
    if (isset($_GET['page']) && $_GET['page'] == 'auth') {
        $form_auth_data = get_form_auth_data($errors);
        $content = include_template('auth.php', $form_auth_data);
    }
    if (isset($_GET['page']) && $_GET['page'] == 'add_task') {
        $form_task_data = get_form_task($user_id, $errors);
        $content = include_template('form_task.php', $form_task_data);
    }
    if (isset($_GET['page']) && $_GET['page'] == 'registration') {
        $form_registration_data = get_form_registration($errors);
        $content = include_template(
            'form_registration.php',
            $form_registration_data
        );
    }

    $layout_data = [
        'user' => $user,
        'title' => $title_name,
        'content' => $content,
    ];

    return $layout_data;
}
