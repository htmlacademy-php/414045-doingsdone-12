<?php

require_once '../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//    валидачия формы
    $errors = validate_auth_form($_POST['email'], $_POST['password']);

    if ($errors) {
        $current_page = 'auth';
        $layout_data = get_layout_data(
            current_page: $current_page,
            errors: $errors
        );
        print(include_template('layout.php', $layout_data));
        exit(1);
    }

//    аутентификация пользователя
    $errors = auth_user($_POST['email'], $_POST['password']);

    if ($errors) {
        $current_page = 'auth';
        $layout_data = get_layout_data(
            current_page: $current_page,
            errors: $errors
        );
        print(include_template('layout.php', $layout_data));
        exit(1);
    }

    $_SESSION['user_id'] = get_user_id($_POST['email']);

    header('location: /');
}
