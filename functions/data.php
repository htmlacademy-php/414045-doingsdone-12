<?php
// функция получения данных для шаблона main
function get_main_data ($current_user_id)
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
function get_form_task ($current_user_id)
{
    $form_task_data = get_main_data($current_user_id);
    if (isset($errors)){
        $form_task['errors'] = $errors;
    }
    return $form_task_data;
}

// функция получения данных для шаблона layout
function get_layout_data ($current_user_id)
{
    $main_data = get_main_data($current_user_id);
    $form_task_data = get_form_task($current_user_id);

    // Данные для layout
    $user_name = 'User';
    $title_name = 'Дела в порядке';
    $content = include_template('main.php', $main_data);

    // проверка id выбранного проекта
    check_selected_project_id($current_user_id);

    // выбор страниц
    if (isset($_GET['page']) && $_GET['page'] == 'add_task') {
        $content = include_template('form_task.php', $form_task_data);
    }


    $layout_data = [
        'user' => $user_name,
        'title' => $title_name,
        'content' => $content
    ];
    return $layout_data;
}
