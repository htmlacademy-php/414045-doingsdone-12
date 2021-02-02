<?php

require('./helpers.php');
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

$projects = [
    'Входящие',
    'Учеба',
    'Работа',
    'Домашние дела',
    'Авто'
];
$tasks = [
    [
        'task' => 'Собеседование в IT компании',
        'date' => '01.12.2019',
        'project' => 'Работа',
        'done' => false
    ],
    [
        'task' => 'Выполнить тестовое задание',
        'date' => '25.12.2019',
        'project' => 'Работа',
        'done' => false
    ],
    [
        'task' => 'Сделать задание первого раздела',
        'date' => '21.12.2019',
        'project' => 'Учеба',
        'done' => true
    ],
    [
        'task' => 'Встреча с другом',
        'date' => '05.02.2021',
        'project' => 'Входящие',
        'done' => false
    ],
    [
        'task' => 'Купить корм для кота',
        'date' => null,
        'project' => 'Домашние дела',
        'done' => false
    ],
    [
        'task' => 'Заказать пиццу',
        'date' => null,
        'project' => 'Домашние дела',
        'done' => false
    ],
];

// подсчет количества задач

$get_project_count = function($name_project) use ($tasks) {
    $project_count = array_reduce($tasks, function($carry, $item){
        if(!isset($carry[$item['project']])){
            $carry += [$item['project'] => 1];
        } else {
            $carry[$item['project']] += 1;
        }
        return $carry;
    }, []);
    return $project_count[$name_project] ?? 0;
};

// фильтрация спецсимволов html

$filter = function($input_data) {
    return htmlspecialchars($input_data);
};

// проверка времени до истечения срока задачи

$check_importance_task = function($task_time){
    $current_time = time();
    $task_time = strtotime($task_time);
    if ($task_time - $current_time <= 86400) {
        return true;
    }
};

// данные для main

$main_data = [
    'projects' => $projects,
    'tasks' => $tasks,
    'project_count' => $get_project_count,
    'show_complete_tasks' => $show_complete_tasks,
    'filter' => $filter,
    'importance_task' => $check_importance_task
];

// Данные для layout

$user_name = 'User';
$title_name = 'Дела в порядке';
$content = include_template('main.php', $main_data);

$layout_data = [
    'user' => $user_name,
    'title' => $title_name,
    'content' => $content
];

print(include_template('layout.php', $layout_data));
