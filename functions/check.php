<?php

/**
 * Фильтрация спецсимволов html
 *
 * @param string $input_data входные данные для фильтрации
 *
 * @return string отфильтрованые данные
 */
function filter($input_data)
{
    return htmlspecialchars($input_data);
}

/**
 * Проверка на существование проекта у пользователя
 *
 * Проверяет в БД существует ли проект у пользователя
 *
 * @param int $user_id           id пользователя
 * @param int $id_chosen_project id выбранного проета
 *
 * @return bool true в случае успеха, false если выбранного проекта нет в БД
 */
function check_selected_project_id($user_id, $id_chosen_project)
{
    return $id_chosen_project && !find_project_id($user_id, $id_chosen_project);
}

/**
 * Валидация названия задачи
 *
 * Проверяет не пустое ли переменная, а так-же является ли она строкой
 *
 * @param string $task_name имя задачи
 *
 * @return bool true в случае успаеха
 */
function validate_task_name($task_name)
{
    return $task_name && is_string($task_name);
}

/**
 * Валидация id проекта
 *
 * Проверяет существует ли проект у пользователя
 *
 * @param int $project_id id проекта
 * @param int $user_id    id пользователя
 *
 * @return bool true, если проект у пользователя существует
 */
function validate_project($project_id, $user_id)
{
    return find_project_id($user_id, $project_id);
}

/**
 * Проверка формата даты
 *
 * Проверяет соответствует ли дата формату, по умолчанию Y-m-d
 *
 * @param string $date   дата
 * @param string $format формат даты
 *
 * @return bool true, в случае успеха
 */
function check_format_date($date, $format = DEFAULT_DATE_FORMAT): bool
{
    $d = date_create_from_format($format, $date);

    return $d && date_format($d, $format) == $date && $date >= date($format);
}

/**
 * Валидация даты
 *
 * Проверяет существует выбранна ли дата, если да, соответствует ли она формату
 *
 * @param string $date
 *
 * @return bool true если дата не выбранна, или выбранна и соответствует формату
 */
function validate_date($date): bool
{
    if (!$date) {
        return true;
    }

    return check_format_date($date);
}

/**
 * Проверка ошибок загрузки файла
 *
 * @return bool true, если ошибок при загрузке не было
 */
function validate_file(): bool
{
    return ($_FILES['file']['error'] == 0 || $_FILES['file']['error'] == 4);
}

/**
 * Валидация формы добавления задачи
 *
 * Если валидация прохзодит без ошибок, возвращает пустой массив.
 *
 * @param int    $user_id    id ползователя
 * @param string $task_name  имя задачи
 * @param int    $project_id id проекта
 * @param string $task_date  дата дедлайна
 *
 * @return array список ошибок
 */
function validate_task_form(
    $user_id,
    $task_name,
    $project_id,
    $task_date
): array {
    $errors = [];

    if (!validate_task_name($task_name)) {
        $errors['name'] = 'Введите название задачи!';
    }
    if (!validate_project($project_id, $user_id)) {
        $errors['project'] = 'Ошибка, выбранного проекта не существует!';
    }
    if (!validate_date($task_date)) {
        $errors['date']
            = 'Введитие дату в формате ГГГГ-ММ-ДД. Дата ранее создания задачи не может быть выбранна.';
    }
    if (!validate_file()) {
        $errors['file'] = 'Ошибка загрузки файла';
    }

    return $errors;
}

/**
 * Валидация формы добавления нового проекта
 *
 * Проверяет что введено название и проекта с таким именем нет у текущего пользователя
 *
 * @param int    $user_id      id пользователя
 * @param string $project_name название проекта
 *
 * @return array список ошибок, если ошибок нет, возвращает пустой массив.
 */
function validate_project_form($user_id, $project_name)
{
    $errors = [];

    if (!$project_name) {
        $errors['name'] = 'Название проета не может быть пустым';
    }
    if (project_name_is_be($user_id, $project_name)) {
        $errors['name'] = 'Проект с таким именем уже существует';
    }

    return $errors;
}

/**
 * Валидация электронной почты
 *
 * Если почта введена и соответствует формату возвращает true
 *
 * @param string $email почта
 *
 * @return bool true, при успешной валидации
 */
function validate_email($email)
{
    if (!$email) {
        return false;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    return true;
}

/**
 * Валидация паролья
 *
 * Если пароль введён возвращает true
 *
 * @param string $password пароль
 *
 * @return bool true, при успешной валидации
 */
function validate_password($password)
{
    if (!$password) {
        return false;
    }

    return true;
}

/**
 * Валидация имени
 *
 * Если имя введено возвращает true
 *
 * @param string $name имя
 *
 * @return bool true, при успешной валидации
 */
function validate_name($name)
{
    if (!$name) {
        return false;
    }

    return true;
}

/**
 * Валидация формы регистрации
 *
 * Проверяет введён ли корректно email, введено ли имя, введён ли пароль
 *
 * @param string $email    почта
 * @param string $name     имя
 * @param string $password пароль
 *
 * @return array список ошибок, если ошибок нет возвращает пустой массив
 */
function validate_registration_form($email, $name, $password)
{
    $errors = [];

    if (!validate_email($email)) {
        $errors['email'] = 'не введён, или не корректно указан email';
    }
    if (email_exist($email)) {
        $errors['email'] = 'пользователь с таким email уже зарегистрирован';
    }
    if (!validate_name($name)) {
        $errors['name'] = 'введите имя';
    }
    if (!validate_password($password)) {
        $errors['password'] = 'введите пароль';
    }

    return $errors;
}

/**
 * Валидация формы аутентификации
 *
 * Проверяет корректно ли введены email и пароль
 *
 * @param string $email    почта
 * @param string $password пароль
 *
 * @return array|null список ошибок, если ошибок нет возвращает null
 */
function validate_auth_form($email, $password)
{
    $errors = null;

    if (!validate_email($email)) {
        $errors['email'] = 'некорректно указан email';
    }
    if (!validate_password($password)) {
        $errors['password'] = 'введите пароль';
    }

    return $errors;
}

/**
 * Аутентификация пользователя
 *
 * Проверяет существует ли пользователь с таким email в БД, если существет проверяет совпадает ли хеш введённого пароля с хешем из БД
 *
 * @param string $email    почта
 * @param string $password пароль
 *
 * @return array|null список ошибок, если ошибок нет возвращает null
 */
function auth_user($email, $password)
{
    $errors = null;

    if (!email_exist($email)) {
        $errors['email'] = 'пользователя с введённым вами email не существует';

        return $errors;
    }

    $user_data = get_user_auth_data($email);

    if (!password_verify($password, $user_data['password'])) {
        $errors['password'] = 'введён неверный пароль';

        return $errors;
    }

    return $errors;
}
