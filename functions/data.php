<?php

/**
 * Данные для шаблона main.php
 *
 * @param int        $user_id           id пользователя
 * @param int|null   $chosen_project_id id выбранного проекта
 * @param sting|null $search_string     поисковый запрос
 *
 * @return array данные для шаблона
 */
function get_main_data(
    $user_id,
    $chosen_project_id = null,
    $search_string = null
) {
    $show_complete_tasks = 0;
    $user_tasks = !$search_string ? show_tasks($user_id, $chosen_project_id)
        : null;
    $found_tasks = $search_string ? search_task($user_id, $search_string)
        : null;
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
    $form_project_data = get_main_data($user_id);
    if (isset($errors)) {
        $form_project_data['errors'] = $errors;
    }

    return $form_project_data;
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
    $form_task_data = get_main_data($user_id);
    if (isset($errors)) {
        $form_task_data['errors'] = $errors;
    }

    return $form_task_data;
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
    $form_registration_data = [];
    if ($errors !== null) {
        $form_registration_data['errors'] = $errors;
    }

    return $form_registration_data;
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
 * @param int|null    $user_id           id пользователя
 * @param int|null    $chosen_project_id id выбранного проекта
 * @param string|null $current_page      выбранная страница
 * @param string|null $search_string     поисковый запрос
 * @param array|null  $errors            список ошибок заполнения формы
 *
 * @return array данные для формы
 */
function get_layout_data(
    $user_id = null,
    $chosen_project_id = null,
    $current_page = null,
    $search_string = null,
    $errors = null
) {
    // Данные для layout
    $user['id'] = $user_id;
    $title_name = 'Дела в порядке';

    // проверка id выбранного проекта
    check_selected_project_id($user_id, $chosen_project_id);

    // выбор страниц
    if (!$user_id) {
        $content = include_template('guest.php');
    }
    if (!$current_page) {
        $main_data = get_main_data(
            $user_id,
            $chosen_project_id,
            $search_string
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

    $layout_data = [
        'user' => $user,
        'title' => $title_name,
        'content' => $content,
    ];

    return $layout_data;
}
