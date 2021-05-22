<?php

session_start();

require_once(__DIR__ . '/constants.php');
require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/vendor/autoload.php');

$user_id = $_SESSION['user_id'] ?? null;
$chosen_project_id = $_GET['id_chosen_project'] ?? null;
$search_string = $_GET['search'] ?? null;
$chosen_tasks_filter = $_GET['tasks_filter'] ?? TASK_FILTER_ALL_TASKS;
$show_complete_tasks = $_GET['show_completed'] ?? 0;
$task_state = $_GET['check'] ?? null;
$task_id = $_GET['task_id'] ?? null;

require_once(__DIR__ . '/functions/functions.php');

$layout_data = get_layout_data(
    $user_id,
    $chosen_project_id,
    $search_string,
    $chosen_tasks_filter,
    $show_complete_tasks
);
