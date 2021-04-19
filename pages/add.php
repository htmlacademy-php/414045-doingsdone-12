<?php
$current_user_id = 1;

require_once('../bootstrap.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // проверяем есть ли ошибки валидачии
    $errors = validate_task_form($current_user_id, $_POST['name'], $_POST['project_id'], $_POST['date']);

    // сохраняем задачу в БД и файл в корень проекта
    if ($errors) {
        $_GET['page'] = 'add_task';
        $layout_data = get_layout_data($current_user_id, $errors);
        print(include_template('layout.php', $layout_data));
        exit(1);
    }
    add_new_task($current_user_id, $_POST['project_id'], $_POST['name'], $_POST['date']);

    // перенаправляем на главную страницу
    header('Location: /');
}







