<?php

// текущий пользователь
$current_user_id = 1;

require_once (__DIR__ . '/functions/functions.php');

// проверка id выбранного проекта
check_selected_project_id($current_user_id);

$layout_data = get_layout_data($current_user_id);

print(include_template('layout.php', $layout_data));
