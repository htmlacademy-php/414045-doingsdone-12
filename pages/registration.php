<?php
$current_user_id = 1;

require_once('../bootstrap.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = validate_registration_form();
//    если есть ошибки показываем страницу регистрации с подсвечеными полями
    if ($errors) {
        $_GET['page'] = 'registration';
        $layout_data = get_layout_data($current_user_id, $errors);
        print(include_template('layout.php', $layout_data));
        exit(1);
    }
//    при успехе перенаправляем на главную
    add_new_user($_POST['email'], $_POST['password'], $_POST['name']);
    header('Location: /');
}
