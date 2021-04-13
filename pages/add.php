<?php
$current_user_id = 1;

require_once('./../functions/functions.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $required = ['name', 'project'];

    // проверяем есть ли ошибки валидачии
    $errors = validate($current_user_id, $_POST['name'], $_POST['project_id'], $_POST['date']);

    // сохраняем задачу в БД и файл в корень проекта
    if ($errors) {
    // данные для layout
        $user_name = 'user';
        $title_name = 'Дела в порядке';
        $content = include_template('add_task.php', $main_data);
        $layout_data = [
            'user' => $user_name,
            'title' => $title_name,
            'content' => $content
        ];
        print(include_template('layout.php', $layout_data));
        exit(1);
    }
    add_new_task($current_user_id, $_POST['project_id'], $_POST['name'], $_POST['date']);

    // перенаправляем на главную страницу
    header('Location: /');
}







