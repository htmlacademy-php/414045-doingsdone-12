<?php

session_start();
$current_user_id = $_SESSION['user_id'] ?? null;

require_once (__DIR__ . '/functions/functions.php');
