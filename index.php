<?php
/**
 * @var int|null    $user_id             id пользователя
 * @var int|null    $chosen_project_id   id выбранного объекта
 * @var string|null $current_page        выбранная страница
 * @var string|null $search_string       поисковый запрос
 * @var string|null $chosen_tasks_filter выбранный фильтр для отображения задач
 * @var int|null    $show_complete_tasks параметр отображение выполненных задач
 */

require_once('bootstrap.php');

$layout_data = get_layout_data(
    $user_id,
    $chosen_project_id,
    $current_page,
    $search_string,
    $chosen_tasks_filter,
    $show_complete_tasks
);

print(include_template('layout.php', $layout_data));
