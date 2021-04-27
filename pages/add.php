<?php
/**
 * @var int $current_user_id
 */

require_once('../bootstrap.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // проверяем есть ли ошибки валидачии
    $errors = validate_task_form(
        user_id: $current_user_id,
        task_name: $_POST['name'],
        project_id: $_POST['project_id'],
        task_date: $_POST['date']
    );

    // сохраняем задачу в БД и файл в корень проекта
    if ($errors) {
        $_GET['page'] = 'add_task';
        $layout_data = get_layout_data($errors);
        print(include_template('layout.php', $layout_data));
        exit(1);
    }
    add_new_task(
        current_user_id: $current_user_id,
        project_id: $_POST['project_id'],
        task_name: $_POST['name'],
        task_date: $_POST['date']
    );

    // перенаправляем на главную страницу
    header('Location: /');
}







