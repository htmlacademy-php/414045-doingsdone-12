<?php

// функция проверки соединения с БД
function show_db_error()
{
    print("Ошибка подключения к БД: " . mysqli_connect_error());
    die;
}

// подключаемся к БД
function connect_db()
{
    $con = mysqli_connect("localhost", "root", "root", "doingsdone");
    if (!$con) {
        show_db_error();
    }
    mysqli_set_charset($con, "utf8");
    return $con;
}
