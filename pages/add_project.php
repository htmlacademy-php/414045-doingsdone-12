<?php
/**
 * Обработка формы добавления нового проекта
 *
 * @var int $user_id id пользователя
 */

require_once('../bootstrap.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = validate_project_form($user_id, $_POST['name']);
    if ($errors) {
        $current_page = 'add_project';
        $layout_data = get_layout_data(
            user_id: $user_id,
            current_page: $current_page,
            errors: $errors
        );
        print(include_template('layout.php', $layout_data));
        exit(1);
    }
    add_new_project(user_id: $user_id, project_name: $_POST['name']);

    header('Location: /');
}