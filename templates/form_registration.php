<?php
/**
 * @var array $errors массив с ошибками формы
 * @var string $input_errors_class_name имя класса поля ввода с ошибкой
 * @var array-key $input данные введеные пользователем
 */

?>

<section class="content__side">
    <p class="content__side-info">Если у вас уже есть аккаунт, авторизуйтесь на
        сайте</p>

    <a class="button button--transparent content__side-button"
       href="<?= get_url_auth_page() ?>">Войти</a>
</section>

<main class="content__main">
    <h2 class="content__main-heading">Регистрация аккаунта</h2>

    <form class="form" action="<?= get_url_registration_script() ?>"
          method="post"
          autocomplete="off">
        <div class="form__row">
            <label class="form__label" for="email">E-mail <sup>*</sup></label>

            <input class="form__input <?= isset($errors['email'])
                ? $input_errors_class_name : '' ?>" type="text"
                   name="email" id="email" value="<?= $input['email'] ?? '' ?>"
                   placeholder="Введите e-mail">
            <?= isset($errors['email'])
                ? '<p class="form__message">' . $errors['email'] . '</p>'
                : '' ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="password">Пароль
                <sup>*</sup></label>

            <input class="form__input <?= isset($errors['password'])
                ? $input_errors_class_name : '' ?>" type="password"
                   name="password" id="password" value="<?= $input['password'] ?? '' ?>"
                   placeholder="Введите пароль">
            <?= isset($errors['password'])
                ? '<p class="form__message">' . $errors['password'] . '</p>' : '' ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="name">Имя <sup>*</sup></label>

            <input class="form__input <?= isset($errors['name'])
                ? $input_errors_class_name : '' ?>" type="text" name="name"
                   id="name" value="<?= $input['name'] ?? '' ?>" placeholder="Введите имя">
            <?= isset($errors['name'])
                ? '<p class="form__message">' . $errors['name'] . '</p>' : '' ?>
        </div>

        <div class="form__row form__row--controls">
            <?= isset($errors)
                ? '<p class="error-message">Пожалуйста, исправьте ошибки в форме</p>'
                : '' ?>

            <input class="button" type="submit" name=""
                   value="Зарегистрироваться">
        </div>
    </form>
</main>
