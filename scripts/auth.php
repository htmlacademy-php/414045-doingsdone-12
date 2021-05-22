<?php

require_once '../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//    валидачия формы
    $errors = validate_auth_form($_POST['email'], $_POST['password']) ??
        auth_user($_POST['email'], $_POST['password']) ?? null;

    if ($errors) {
        $layout_data['content'] = include_template(
            'auth.php',
            get_form_auth_data($errors)
        );
        print(include_template('layout.php', $layout_data));
        exit(1);
    }

    $_SESSION['user_id'] = get_user_id($_POST['email']);

    redirect_to_home();
}
