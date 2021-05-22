<?php

/**
 * Данные для шаблона main.php
 *
 * @param int $user_id id пользователя
 * @param int|null $chosen_project_id id выбранного проекта
 * @param string|null $search_string поисковый запрос
 * @param string|null $chosen_tasks_filter фильтр для отображения задач
 * @param int $show_complete_tasks показывать или нет выполненые задачи
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
 * @param int $user_id id пользователя
 * @param null|array $errors массив с ашибками обработки формы
 *
 * @return array данные для шаблона
 */
function get_form_project_data($user_id, $errors = null, $input = null)
{
    if ($errors) {
        return [
            'projects' => get_projects($user_id),
            'projects_count' => get_count_task_in_projects($user_id),
            'errors' => $errors,
            'input' => $input,
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
 * @param int|null $user_id id пользователя
 * @param array|null $errors список ошибок заполнения формы
 *
 * @return array данные для шаблона
 */
function get_form_task_data($user_id, $errors = null, $input = null)
{
    if ($errors) {
        return [
            'projects' => get_projects($user_id),
            'projects_count' => get_count_task_in_projects($user_id),
            'errors' => $errors,
            'input' => $input,
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
function get_form_registration_data($errors = null, $input = null)
{
    if ($errors) {
        return [
            'errors' => $errors,
            'input' => $input,
            'input_errors_class_name' => INPUT_ERROR_CLASS_NAME,
        ];
    }

    return [
        'input_errors_class_name' => INPUT_ERROR_CLASS_NAME,
    ];
}

/**
 * Данные для шаблона auth.php
 *
 * @param array|null $errors список ошибок заполнения формы
 *
 * @return array данные для шаблона
 */
function get_form_auth_data($errors = null, $input = null)
{
    if ($errors) {
        return [
            'errors' => $errors,
            'input' => $input,
            'input_errors_class_name' => INPUT_ERROR_CLASS_NAME,
        ];
    }

    return [
        'input_errors_class_name' => INPUT_ERROR_CLASS_NAME,
    ];
}

/**
 * Данные для шаблона layout.php
 *
 * @param int|null $user_id id пользователя
 * @param int|null $chosen_project_id id выбранного проекта
 * @param string|null $chosen_tasks_filter выбранный фильтр для отображения задач
 * @param int|null $show_complete_tasks параметр отображения выполненных задач
 * @param string|null $search_string поисковый запрос
 *
 * @return array данные для формы
 */
function get_layout_data(
    $user_id = null,
    $chosen_project_id = null,
    $search_string = null,
    $chosen_tasks_filter = null,
    $show_complete_tasks = null,
    $content = null
) {
    // Данные для layout
    $user['id'] = $user_id;
    $user['name'] = $user_id ? get_user_name($user_id) : null;
    $title_name = SITE_TITLE;

    // проверка id выбранного проекта
    if (check_selected_project_id($user_id, $chosen_project_id)) {
        redirect_to_not_found();
        die;
    }

    if ($user_id) {
        $main_data = get_main_data(
            $user_id,
            $chosen_project_id,
            $search_string,
            $chosen_tasks_filter,
            $show_complete_tasks
        );
        $content = include_template('main.php', $main_data);
    }

    return [
        'user' => $user,
        'title' => $title_name,
        'content' => $content,
    ];
}

/**
 * Данные для шаблона письма напоминания о задачах на текущий день
 *
 * @param $user_data
 *
 * @return array данные для шаблона mail.php
 */
function get_mail_data($user_data)
{
    $name = htmlspecialchars($user_data['name']);
    $tasks = get_today_tasks($user_data['id']);
    $mail_text = null;

    if ($tasks) {
        $task_list = '. У вас запланирована задача: ' . htmlspecialchars($tasks[0]['title']);

        if (count($tasks) > 1) {
            $task_list = '. У вас запланированы задачи:';
            foreach ($tasks as $task) {
                $task_list .= ' ' . htmlspecialchars($task['title']) . ',';
            }
            $task_list = trim($task_list, ',');
        }

        $mail_text = 'Уважаемый, ' . $name . $task_list . ' на ' . date('d-m-Y') . '.';
    }

    return [
        'mail_text' => $mail_text,
    ];
}
