<?php

function search_task($user_id)
{
    $found_tasks = null;
    $searchString = $_GET['search'] ?? null;

    if ($searchString) {
        $task_name = trim($_GET['search']);
        if ($task_name) {
            $found_tasks = get_looking_for_task($user_id, $task_name);
        }
    }

    return $found_tasks;
}

