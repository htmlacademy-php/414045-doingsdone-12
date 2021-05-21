<?php
/**
 * @var int $user_id
 */

require_once('../bootstrap.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // проверяем есть ли ошибки валидачии
    $errors = validate_task_form(
        $user_id,
        $_POST['name'],
        $_POST['project_id'],
        $_POST['date']
    );

    // сохраняем задачу в БД и файл в корень проекта
    if ($errors) {
        $current_page = 'add_task';
        $layout_data['content'] = include_template(
            'form_task.php',
            get_form_task_data(
                $user_id,
                $errors
            )
        );
        print(include_template('layout.php', $layout_data));
        exit(1);
    }
    add_new_task(
        $user_id,
        $_POST['project_id'],
        $_POST['name'],
        $_POST['date'],
        $_FILES['file']
    );

    // перенаправляем на главную страницу
    redirect_to_home();
}







