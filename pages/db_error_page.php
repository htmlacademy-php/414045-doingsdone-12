<?php

require_once('../bootstrap.php');

$error = $_GET['error'];

print 'Ошибка БД: ' . $error;
