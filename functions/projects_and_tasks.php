<?php

/**
 * Фильтр для отображения задач
 *
 * @param string $chosen_tasks_filter выбранный фильтр для отображения задач
 *
 * @return string|null
 */
function tasks_filter($chosen_tasks_filter)
{
    $today = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
    $next_day = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y'));
    if ($chosen_tasks_filter == 'today_tasks') {
        return '=='.$today;
    }
    if ($chosen_tasks_filter == 'next_day_tasks') {
        return '=='.$next_day;
    }
    if ($chosen_tasks_filter == 'overdue_tasks') {
        return '<'.$today;
    }

    return null;
}

/**
 * Отображаемые задачи
 *
 * Если пользователь выбрал проект, отображаем только задачи выбранного проекта. Если проект не выбран, отображаются все задачи пользователя
 *
 * @param int $user_id           id пользователя
 * @param int $id_chosen_project id выбранного проекта
 * @param string $chosen_tasks_filter выбранный фильтр для отображения задач
 *
 * @return array отображаемые задачи
 */
function show_tasks($user_id, $id_chosen_project, $chosen_tasks_filter): array
{
    $chosenProject = $id_chosen_project ?? null;

    return get_chosen_tasks($user_id, $chosenProject, $chosen_tasks_filter);
}

/**
 * Проверка времени до истечения срока задачи
 *
 * Если до дедлана осталось менее 24ч, возвращает true
 *
 * @param string $task_time дата дедлайна
 *
 * @return bool
 */
function is_task_important($task_time): bool
{
    $current_time = time();
    $task_time = strtotime($task_time);
    $task_time_to_end_limit = 24 * 3600; //24 часа

    return $task_time - $current_time < $task_time_to_end_limit;
}

/**
 * Сохранение файла
 *
 * Сохраняет файл на сервере и возврящает путь к файлу
 *
 * @param array $file массив с файлом
 *
 * @return string|null путь к файлу на сервере
 */
function save_file($file): string|null
{
    $file_url = null;
    if ($file['name']) {
        $file_name = $file['name'];
        $file_path = '../';
        $file_url = '/'.$file_name;
        move_uploaded_file($file['tmp_name'], $file_path.$file_name);
    }

    return $file_url;
}

/**
 * Добавление новой задачи в БД
 *
 * @param int    $user_id    id пользователя
 * @param int    $project_id id проекта
 * @param string $task_name  имя задачи
 * @param string $task_date  дедлайн задачи
 */
function add_new_task($user_id, $project_id, $task_name, $task_date, $file)
{
    // сохраняем файл
    $file_url = save_file($file);

    // запись в БД
    add_task_in_db(
        $user_id,
        $project_id,
        $task_name,
        $file_url,
        $task_date
    );
}
