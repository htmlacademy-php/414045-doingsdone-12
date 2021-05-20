<?php

/**
 * Возвращает путь для отображения всех задач в проекте
 *
 * @param int|null $chosen_project_id id выбранного проекта
 *
 * @return string путь с GET запросом для отображения всех задач
 */
function get_url_all_project_tasks($chosen_project_id = null)
{
    $chosen_project = $chosen_project_id ? '&id_chosen_project='
        .$chosen_project_id : '';

    return '?task_filter=all'.$chosen_project;
}

/**
 * Возвращает путь страницы авторизации
 *
 * @return string url страницы авторизации
 */
function get_url_auth_page()
{
    return '/pages/auth.php';
}

/**
 * Возвращает путь скрипта обработки формы авторизации
 *
 * @return string url скрипта обработки формы авторизации
 */
function get_url_auth_script()
{
    return '/scripts/auth.php';
}

/**
 * Возвращает путь скрипта выхода из учетной записи
 *
 * @return string url скрипта выхода из учетной записи
 */
function get_url_logout_script()
{
    return '/scripts/logout.php';
}

/**
 * Возвращает путь страницы регистрации
 *
 * @return string url страницы регистрации
 */
function get_url_registration_page()
{
    return "/pages/registration.php";
}

/**
 * Возвращает путь скрипта обработки формы регистрации
 *
 * @return string url скрипта обработки формы регистрации
 */
function get_url_registration_script()
{
    return "/scripts/registration.php";
}

/**
 * Возвращает url с get запросом выбранного проекта
 *
 * @param int $project_id id выбранного проекта
 *
 * @return string url с get запросом выбранного проекта
 */
function get_url_id_chosen_project($project_id)
{
    return '/?id_chosen_project='.$project_id;
}

/**
 * Возвращает путь страницы добавления нового проекта
 *
 * @return string url страницы добавление проекта
 */
function get_url_add_project_page()
{
    return '/pages/add_project.php';
}

/**
 * Возвращает путь скрипта добавления нового проекта
 *
 * @return string url скрипт добавления проекта
 */
function get_url_add_project_script()
{
    return '/scripts/add_project.php';
}

/**
 * Возвращает путь страницы добавления новой задачи
 *
 * @return string url страницы добавление задачи
 */
function get_url_add_task_page()
{
    return '/pages/add_task.php';
}

/**
 * Возвращает путь скрипта добавления новой задачи
 *
 * @return string url скрипт добавления задачи
 */
function get_url_add_task_script()
{
    return '/scripts/add_task.php';
}

/**
 * Возвращает url логотипа
 *
 * @return string url логотипа
 */
function get_url_logo()
{
    return '/img/logo.png';
}

/**
 * Возвращает url index.php
 *
 * @return string url index.php
 */
function get_url_homepage()
{
    return '/index.php';
}

/**
 * Возвращает get запрос фильтра отображения задач на сегодня
 *
 * @return string get запрос фильтра отображения задач на сегодня
 */
function get_url_tasks_filter_today()
{
    return '/?tasks_filter=today_tasks';
}

/**
 * Возвращает get запрос фильтра отображения задач на завтра
 *
 * @return string get запрос фильтра отображения задач на завтра
 */
function get_url_tasks_filter_next_day()
{
    return '/?tasks_filter=next_day_tasks';
}

/**
 * Возвращает get запрос фильтра отображения просроченных задач
 *
 * @return string get запрос фильтра отображения просроченных задач
 */
function get_url_tasks_filter_overdue()
{
    return '/?tasks_filter=overdue_tasks';
}

/**
 * Возвращает путь к файлу задачи
 *
 * @param array $task массив с данными задачи
 *
 * @return string url файла задачи
 */
function get_url_task_file($task)
{
    return $task['file_src'];
}