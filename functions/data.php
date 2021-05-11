<?php

/**
 * Данные для шаблона main.php
 *
 * @param int         $user_id             id пользователя
 * @param int|null    $chosen_project_id   id выбранного проекта
 * @param string|null $search_string       поисковый запрос
 * @param string|null $chosen_tasks_filter фильтр для отображения задач
 * @param int         $show_complete_tasks показывать или нет выполненые задачи
 *
 * @return array данные для шаблона
 */
function get_main_data(
    $user_id,
    $chosen_project_id = null,
    $search_string = null,
    $chosen_tasks_filter = null,
    $show_complete_tasks = null
) {
    $user_tasks = !$search_string ? show_tasks(
        $user_id,
        $chosen_project_id,
        $chosen_tasks_filter
    )
        : null;
    $found_tasks = $search_string ? search_task($user_id, $search_string)
        : null;
    $nothing_found_message = "";

    if (isset($_GET['search']) && !$found_tasks) {
        $nothing_found_message = "Ничего не найдено по вашему запросу";
    }

    return [
        'projects' => get_projects($user_id),
        'chosen_project_id' => $chosen_project_id,
        'chosen_tasks_filter' => $chosen_tasks_filter,
        'user_tasks' => $user_tasks,
        'found_tasks' => $found_tasks,
        'show_complete_tasks' => $show_complete_tasks,
        'projects_count' => get_count_task_in_projects($user_id),
        'nothing_found_message' => $nothing_found_message,
    ];
}

/**
 * Данные для шаблона form_project.php
 *
 * @param int        $user_id id пользователя
 * @param null|array $errors  массив с ашибками обработки формы
 *
 * @return array данные для шаблона
 */
function get_form_project_data($user_id, $errors = null)
{
    if ($errors) {
        return [
            'projects' => get_projects($user_id),
            'projects_count' => get_count_task_in_projects($user_id),
            'errors' => $errors,
            'input_errors_class_name' => INPUT_ERROR_CLASS_NAME,
        ];
    }

    return [
        'projects' => get_projects($user_id),
        'projects_count' => get_count_task_in_projects($user_id),
        'input_errors_class_name' => INPUT_ERROR_CLASS_NAME,
    ];
}

/**
 * Данные для шаблона form_task.php
 *
 * @param int|null   $user_id id пользователя
 * @param array|null $errors  список ошибок заполнения формы
 *
 * @return array данные для шаблона
 */
function get_form_task_data($user_id, $errors = null)
{
    if ($errors) {
        return [
            'projects' => get_projects($user_id),
            'projects_count' => get_count_task_in_projects($user_id),
            'errors' => $errors,
            'input_errors_class_name' => INPUT_ERROR_CLASS_NAME,
        ];
    }

    return [
        'projects' => get_projects($user_id),
        'projects_count' => get_count_task_in_projects($user_id),
        'input_errors_class_name' => INPUT_ERROR_CLASS_NAME,
    ];
}

/**
 * Данные для шаблона form_registration.php
 *
 * @param array|null $errors список ошибок заполнения формы
 *
 * @return array данные для шаблона
 */
function get_form_registration_data($errors = null)
{
    if ($errors) {
        return [
            'errors' => $errors,
            'input_errors_class_name' => INPUT_ERROR_CLASS_NAME
        ];
    }

    return [
        'input_errors_class_name' => INPUT_ERROR_CLASS_NAME
    ];
}

/**
 * Данные для шаблона auth.php
 *
 * @param array|null $errors список ошибок заполнения формы
 *
 * @return array данные для шаблона
 */
function get_form_auth_data($errors = null)
{
    $form_auth_data = [];
    if ($errors !== null) {
        $form_auth_data['errors'] = $errors;
    }

    return $form_auth_data;
}

/**
 * Данные для шаблона layout.php
 *
 * @param int|null    $user_id             id пользователя
 * @param int|null    $chosen_project_id   id выбранного проекта
 * @param string|null $current_page        выбранная страница
 * @param string|null $chosen_tasks_filter выбранный фильтр для отображения задач
 * @param int|null    $show_complete_tasks параметр отображения выполненных задач
 * @param string|null $search_string       поисковый запрос
 * @param array|null  $errors              список ошибок заполнения формы
 *
 * @return array данные для формы
 */
function get_layout_data(
    $user_id = null,
    $chosen_project_id = null,
    $current_page = null,
    $search_string = null,
    $chosen_tasks_filter = null,
    $show_complete_tasks = null,
    $errors = null
) {
    // Данные для layout
    $user['id'] = $user_id;
    $title_name = SITE_TITLE;

    // проверка id выбранного проекта
    check_selected_project_id($user_id, $chosen_project_id);

    // выбор страниц
    if (!$user_id) {
        $content = include_template('guest.php');
    }
    if (!$current_page && $user_id) {
        $main_data = get_main_data(
            $user_id,
            $chosen_project_id,
            $search_string,
            $chosen_tasks_filter,
            $show_complete_tasks
        );
        $content = include_template('main.php', $main_data);
    }
    if ($current_page && $current_page == 'auth') {
        $form_auth_data = get_form_auth_data($errors);
        $content = include_template('auth.php', $form_auth_data);
    }
    if ($current_page && $current_page == 'add_task') {
        $form_task_data = get_form_task_data($user_id, $errors);
        $content = include_template('form_task.php', $form_task_data);
    }
    if ($current_page && $current_page == 'add_project') {
        $form_project_data = get_form_project_data($user_id, $errors);
        $content = include_template('form_project.php', $form_project_data);
    }
    if ($current_page && $current_page == 'registration') {
        $form_registration_data = get_form_registration_data($errors);
        $content = include_template(
            'form_registration.php',
            $form_registration_data
        );
    }

    return [
        'user' => $user,
        'title' => $title_name,
        'content' => $content,
    ];
}
