<?php

require_once '../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

//    валидачия формы
    $errors = validate_auth_form();

    if ($errors) {
        $_GET['page'] = 'auth';
        $layout_data = get_layout_data(errors: $errors);
        print(include_template('layout.php', $layout_data));
        exit(1);
    }

//    аутентификация пользователя
    $errors = auth_user();

    if ($errors) {
        $_GET['page'] = 'auth';
        $layout_data = get_layout_data(errors: $errors);
        print(include_template('layout.php', $layout_data));
        exit(1);
    }

    session_start();
    $_SESSION['user_id'] = get_user_id($_POST['email']);

    header('location: /');
}
