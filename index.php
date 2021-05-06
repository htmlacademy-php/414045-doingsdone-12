<?php

require_once('bootstrap.php');

$layout_data = get_layout_data(
    $user_id,
    $chosen_project_id,
    $current_page,
    $search_string,
    $chosen_tasks_filter
);

print(include_template('layout.php', $layout_data));
