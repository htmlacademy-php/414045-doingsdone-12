<?php

session_start();

$user_id = $_SESSION['user_id'] ?? null;
$chosen_project_id = $_GET['id_chosen_project'] ?? null;
$current_page = $_GET['page'] ?? null;
$search_string = $_GET['search'] ?? null;
$chosen_tasks_filter = $_GET['tasks_filter'] ?? 'all';
$show_complete_tasks = $_GET['show_completed'] ?? 0;
$task_state = $_GET['check'] ?? null;
$task_id = $_GET['task_id'] ?? null;

require_once(__DIR__.'/functions/functions.php');

if (isset($_GET['check'])) {
    change_task_done_state($user_id, $task_id);
    header('location: /');
}
