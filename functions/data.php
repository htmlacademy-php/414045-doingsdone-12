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
