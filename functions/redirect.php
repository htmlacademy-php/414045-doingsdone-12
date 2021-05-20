<?php

/**
 * Перенаправляет на главную страницу
 */
function redirect_to_home()
{
    header('location: /');
    die;
}

/**
 * Перенаправляет неавторизованного пользователя на страницу гостя
 */
function redirect_guest()
{
    if (!isset($_SESSION['user_id'])) {
        header('location: /pages/guest.php');
        die;
    }
}

/**
 * Перенаправляет на страницу ошибки 404
 */
function redirect_to_not_found()
{
    header('location: /error404/');
    die;
}

function redirect_to_db_error_page()
{
    header('location: /db_error_page.php');
    die;
}