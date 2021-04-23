<?php

require_once('../bootstrap.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = validate_registration_form();
//    если есть ошибки показываем страницу регистрации с подсвечеными полями
    if ($errors) {
        $_GET['page'] = 'registration';
        $layout_data = get_layout_data($errors);
        print(include_template('layout.php', $layout_data));
        exit(1);
    }
//    при успехе перенаправляем на главную
    add_new_user($_POST['email'], $_POST['password'], $_POST['name']);

    $_SESSION['user_id'] = get_user_id($_POST['email']);

    header('Location: /');
}
