<?php

session_start();

$user_id = $_SESSION['user_id'] ?? null;
$chosen_project_id = $_GET['id_chosen_project'] ?? null;
$current_page = $_GET['page'] ?? null;
$search_string = $_GET['search'] ?? null;
$chosen_tasks_filter = $_GET['tasks_filter'] ?? 'all';

require_once(__DIR__.'/functions/functions.php');
