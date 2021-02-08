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

function get_projects_count($tasks){
    return array_reduce($tasks, function ($carry, $item){
        if(!isset($carry[$item['project']])){
            $carry += [$item['project'] => 1];
        } else {
            $carry[$item['project']] += 1;
        }
        return $carry;
    }, []);
}

$projects_count = get_projects_count($tasks);

// фильтрация спецсимволов html

function filter($input_data): string
{
    return htmlspecialchars($input_data);
}

// проверка времени до истечения срока задачи

function is_importance_task($task_time): bool
{
    $current_time = time();
    $task_time = strtotime($task_time);
    $task_time_to_end_limit = 24 * 3600; //24 часа
    return $task_time - $current_time < $task_time_to_end_limit;
}

// данные для main

$main_data = [
    'projects' => $projects,
    'tasks' => $tasks,
    'show_complete_tasks' => $show_complete_tasks,
    'projects_count' => $projects_count
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
