<?php

/**
 * Функция проверки соединения с БД
 */
function show_db_error()
{
    print("Ошибка подключения к БД: " . mysqli_connect_error());
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
    $con = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if (!$con) {
        show_db_error();
    }
    mysqli_set_charset($con, DB_CHARSET);

    return $con;
}
