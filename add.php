<?php
$current_user_id = 1;
require_once('./functions/functions.php');
$errors = [];
$project_id = null;
$task_date = null;
$task_name = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $required = ['name', 'project'];

//    проверяем название задачи на валидность
    if (validate_task_name($_POST['name'])) {
        $task_name = $_POST['name'];
    } else {
        $errors['name'] = 'Введите название задачи!';
    }

//    проверяем проект на валидность
    if (isset($_POST['project']) && validate_project($_POST['project'], $current_user_id)) {
        $project_id = $_POST['project'];
    } else {
        $errors['project'] = 'Не выбран проект!';
    }
    //    проверяем дату на валидность
    if ($_POST['date']) {
        if (validate_date($_POST['date'])) {
            $task_date = $_POST['date'];
        } else {
            $errors['date'] = 'Введите дату в формате ГГГГ-ММ-ДД, дата ранее текущей не может быть выбранна.';
        }
    }
    // проверяем есть ли ошибки валидачии, если нет, то сохраняем задачу в БД и файл в корень проекта
    if (!$errors) {

        // сохраняем файл
        $file_url = null;
        if ($_FILES['file']['name']) {
            $file_name = $_FILES['file']['name'];
            $file_path = __DIR__ . '/';
            $file_url = "/". $file_name;
            move_uploaded_file($_FILES['file']['tmp_name'], $file_path . $file_name);
        }

        // запись в БД
        add_task($current_user_id, $project_id, $task_name, file_src: $file_url, time_end: $task_date);

        // перенаправляем на главную страницу
        header('Location: http://414045-doingsdone-12/');
    } else {
        $_GET['page'] = 'add_task';
        require_once 'index.php';
    }
}







