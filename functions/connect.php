<?php

/**
 * Функция проверки соединения с БД
 */
function show_db_error()
{
    print("Ошибка подключения к БД: ".mysqli_connect_error());
    die;
}

/**
 * Подключение к БД
 *
 * В случае ошибки подключения, отображает ошибки
 *
 * @return false|mysqli
 */
function connect_db()
{
    $con = mysqli_connect("localhost", "root", "root", "doingsdone");
    if (!$con) {
        show_db_error();
    }
    mysqli_set_charset($con, "utf8");

    return $con;
}
