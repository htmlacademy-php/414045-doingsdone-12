<?php
/** @noinspection ALL */

/**
 * Проверка на существование проекта у пользователя
 *
 * Проверяет в БД существует ли проект у пользователя
 *
 * @param int $user_id id пользователя
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
 * Проверка формата даты
 *
 * Проверяет соответствует ли дата формату, по умолчанию Y-m-d
 *
 * @param string $date дата
 * @param string $format формат даты
 *
 * @return bool true, в случае успеха
 */
function check_format_date($date, $format = DEFAULT_DATE_FORMAT): bool
{
    $d = date_create_from_format($format, $date);

    return $d && date_format($d, $format) === (string)$date && (string)$date >= date($format);
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
function validate_date($date)
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
function validate_file()
{
    return ((int)$_FILES['file']['error'] === UPLOAD_ERR_OK || (int)$_FILES['file']['error'] === UPLOAD_ERR_NO_FILE);
}

/**
 * Валидация формы добавления задачи
 *
 * Если валидация прохзодит без ошибок, возвращает пустой массив.
 *
 * @param int $user_id id ползователя
 * @param string $task_name имя задачи
 * @param int $project_id id проекта
 * @param string $task_date дата дедлайна
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
    if (strlen($task_name) > MAX_LENGTH_TASK_NAME) {
        $errors['name'] = 'Название задачи не может быть длиннее ' . MAX_LENGTH_TASK_NAME . ' символов';
    }
    if (!find_project_id($user_id, $project_id)) {
        $errors['project']
            = 'Ошибка, у вас нет проектов или выбранного проекта не существует!';
    }
    if (!validate_date($task_date)) {
        $errors['date']
            = 'Введитие дату в формате ГГГГ-ММ-ДД. Дата ранее создания задачи не может быть выбранна.';
    }
    if (!validate_file()) {
        $errors['file'] = 'Ошибка загрузки файла';
    }
    if (strlen($_FILES['file']['name']) > MAX_LENGTH_FILE_NAME) {
        $errors['file'] = 'Слишком длинное имя файла, имя файла должно быть не длинее ' . MAX_LENGTH_FILE_NAME . ' символов';
    }

    return $errors;
}

/**
 * Валидация формы добавления нового проекта
 *
 * Проверяет что введено название и проекта с таким именем нет у текущего пользователя
 *
 * @param int $user_id id пользователя
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
    if (strlen($project_name) > MAX_LENGTH_PROJECT_NAME) {
        $errors['name'] = 'Название проекта не может быть длиннее ' . MAX_LENGTH_PROJECT_NAME . ' символов';
    }
    if (project_name_is_be($user_id, $project_name)) {
        $errors['name'] = 'Проект с таким именем уже существует';
    }

    return $errors;
}

/**
 * Валидация электронной почты
 *
 * Если почта введена, не длинее 128 символов и соответствует формату возвращает true
 *
 * @param string $email почта
 *
 * @return bool true, при успешной валидации
 */
function validate_email($email)
{
    if (!$email || strlen($email) > MAX_LENGTH_EMAIL) {
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
 * Если пароль введён и он длиннее 4, но не более 64 символов возвращает true
 *
 * @param string $password пароль
 *
 * @return bool true, при успешной валидации
 */
function validate_password($password)
{
    if (!$password || strlen($password) < MIN_LENGTH_PASSWORD || strlen($password) > MAX_LENGTH_PASSWORD) {
        return false;
    }

    return true;
}

/**
 * Валидация имени
 *
 * Если имя введено возвращает и оно не длинее 64 символов true
 *
 * @param string $name имя
 *
 * @return bool true, при успешной валидации
 */
function validate_name($name)
{
    if (!$name || strlen($name) > MAX_LENGTH_USER_NAME) {
        return false;
    }

    return true;
}

/**
 * Валидация формы регистрации
 *
 * Проверяет введён ли корректно email, введено ли имя, введён ли пароль
 *
 * @param string $email почта
 * @param string $name имя
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
        $errors['name'] = 'введите имя, должно быть не длиннее ' . MAX_LENGTH_USER_NAME . ' символов';
    }
    if (!validate_password($password)) {
        $errors['password'] = 'введите пароль, должен быть длинее ' . MIN_LENGTH_PASSWORD . ' символов, но не длинее ' . MAX_LENGTH_PASSWORD;
    }

    return $errors;
}

/**
 * Валидация формы аутентификации
 *
 * Проверяет корректно ли введены email и пароль
 *
 * @param string $email почта
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
    if (!$password) {
        $errors['password'] = 'введите пароль';
    }
    if (strlen($password) > MAX_LENGTH_PASSWORD) {
        $errors['password'] = 'введён неверный пароль';
    }

    return $errors;
}

/**
 * Аутентификация пользователя
 *
 * Проверяет существует ли пользователь с таким email в БД, если существет проверяет совпадает ли хеш введённого пароля с хешем из БД
 *
 * @param string $email почта
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
