<?php

/**
 * Отображаемые задачи
 *
 * Если пользователь выбрал проект, отображаем только задачи выбранного проекта.
 * Если проект не выбран, отображаются все задачи пользователя
 *
 * @param int|null $user_id id пользователя
 * @param int|null $id_chosen_project id выбранного проекта
 * @param string|null $tasks_filter выбранный фильтр для отображения задач
 *
 * @return array отображаемые задачи
 */
function show_tasks(
    $user_id,
    $id_chosen_project,
    $tasks_filter
) {
    $project_id = $id_chosen_project ?? null;
    $tasks = [];

    if (!$project_id
        && (!$tasks_filter
            || (string)$tasks_filter === TASK_FILTER_ALL_TASKS)
    ) {
        $tasks_result = get_user_all_tasks($user_id);
    }
    if ($project_id) {
        $tasks_result = get_user_tasks_chosen_project($user_id, $project_id);
    }
    if ($tasks_filter && ($tasks_filter != TASK_FILTER_ALL_TASKS)) {
        $tasks_result = get_user_tasks_chosen_filter($user_id, $tasks_filter);
    }

    foreach ($tasks_result as $task) {
        $file_name = null;
        if ($task['file_src']) {
            $file_name = ltrim($task['file_src'], '/');
        }
        $task['file_name'] = $file_name;

        if ($task['time_end']) {
            $task['time_end'] = date("d.m.Y", strtotime($task['time_end']));
        }
        array_push($tasks, $task);
    }

    return $tasks;
}

/**
 * Проверка времени до истечения срока задачи
 *
 * Если до дедлана осталось менее 24ч, возвращает true
 * Если дедлайн не установлен, возвращает false
 *
 * @param string $task_time дата дедлайна
 *
 * @return bool true, если задача срочная
 */
function is_task_important($task_time): bool
{
    if (!$task_time) {
        return false;
    }

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
function save_file($file)
{
    if (!$file['name']) {
        return null;
    }

    $file_name = $file['name'];
    $file_path = '../';
    $file_url = '/' . $file_name;
    move_uploaded_file($file['tmp_name'], $file_path . $file_name);

    return $file_url;
}

/**
 * Добавление новой задачи в БД
 *
 * @param int $user_id id пользователя
 * @param int $project_id id проекта
 * @param string $task_name имя задачи
 * @param string $task_date дедлайн задачи
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

/**
 * Поиск задачи по поисковому запросу пользователя
 *
 * @param int $user_id id пользователя
 * @param string $search_string поисковый запрос
 *
 * @return array|null найденые задачи, null если задачи не найдены
 */
function search_task($user_id, $search_string)
{
    $search_string = trim($search_string) ?? null;

    return $search_string ? get_looking_for_task($user_id, $search_string)
        : null;
}
