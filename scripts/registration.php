<?php

require_once('../bootstrap.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = validate_registration_form(
        $_POST['email'],
        $_POST['password'],
        $_POST['name']
    );
//    если есть ошибки показываем страницу регистрации с подсвечеными полями
    if ($errors) {
        $layout_data['content'] = include_template(
            'form_registration.php',
            get_form_registration_data(errors: $errors)
        );
        print(include_template('layout.php', $layout_data));
        exit(1);
    }
//    при успехе перенаправляем на главную
    add_new_user($_POST['email'], $_POST['password'], $_POST['name']);

    $_SESSION['user_id'] = get_user_id($_POST['email']);

    redirect_to_home();
}
