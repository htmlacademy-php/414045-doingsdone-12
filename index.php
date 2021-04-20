<?php

session_start();

require_once(__DIR__ . '/functions/functions.php');

$layout_data = get_layout_data();

print(include_template('layout.php', $layout_data));
