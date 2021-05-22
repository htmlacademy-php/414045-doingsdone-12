<?php
/**
 * @var int $user_id
 */

require_once('../bootstrap.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // проверяем есть ли ошибки валидачии
    $project_id = (int) $_POST['project_id'] ?? null;
    $task_name = $_POST['name'];
    $task_time_end = $_POST['date'];
    $errors = validate_task_form(
        $user_id,
        $task_name,
        $project_id,
        $task_time_end
    );

    // сохраняем задачу в БД и файл в корень проекта
    if ($errors) {
        $input = [
            'task_name' => $task_name,
            'project_id' => $project_id,
            'task_time_end' => $task_time_end
        ];
        $current_page = 'add_task';
        $layout_data['content'] = include_template(
            'form_task.php',
            get_form_task_data(
                $user_id,
                $errors,
                $input
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







