<?php
$current_user_id = 1;

require_once('./functions/functions.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $required = ['name', 'project'];

    // проверяем есть ли ошибки валидачии
    $errors = validate($current_user_id, $_POST['name'], $_POST['project_id'], $_POST['date']);

    // сохраняем задачу в БД и файл в корень проекта
    if ($errors) {
        $_GET['page'] = 'add_task';
        require_once './index.php';
        exit(1);
    }
    add_new_task($current_user_id, $_POST['project_id'], $_POST['name'], $_POST['date']);

    // перенаправляем на главную страницу
    header('Location: ./index.php');
}







