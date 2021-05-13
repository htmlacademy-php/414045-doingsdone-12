<?php

/**
 * Получает путь для отображения всех задач в проекте
 *
 * @param int|null $chosen_project_id id выбранного проекта
 *
 * @return string путь с GET запросом для отображения всех задач
 */
function get_url_all_project_tasks($chosen_project_id = null)
{
    $chosen_project = $chosen_project_id ? '&id_chosen_project=' . $chosen_project_id : '';
    return '?task_filter=all'.$chosen_project;
}

