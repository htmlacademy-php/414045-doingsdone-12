<?php

function search_task()
{
    $found_tasks = null;
    if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['search'])) {
        $task_name = trim($_GET['search'], " ");
        if ($task_name) {
            $found_tasks = get_looking_for_task($task_name);
        }
    }

    return $found_tasks;
}

