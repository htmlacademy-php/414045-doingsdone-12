<?php
/**
 * @var array $errors
 */

?>

<section class="content__side">
    <p class="content__side-info">Если у вас уже есть аккаунт, авторизуйтесь на
        сайте</p>

    <a class="button button--transparent content__side-button"
       href="/?page=auth">Войти</a>
</section>

<main class="content__main">
    <h2 class="content__main-heading">Регистрация аккаунта</h2>

    <form class="form" action="/pages/registration.php" method="post"
          autocomplete="off">
        <div class="form__row">
            <label class="form__label" for="email">E-mail <sup>*</sup></label>

            <input class="form__input <?= isset($errors['email'])
                ? 'form__input--error' : '' ?>" type="text"
                   name="email" id="email" value=""
                   placeholder="Введите e-mail">
            <?= isset($errors['email'])
                ? '<p class="form__message">E-mail введён некорректно</p>'
                : '' ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="password">Пароль
                <sup>*</sup></label>

            <input class="form__input <?= isset($errors['password'])
                ? 'form__input--error' : '' ?>" type="password"
                   name="password" id="password" value=""
                   placeholder="Введите пароль">
            <?= isset($errors['password'])
                ? '<p class="form__message">Введите пароль</p>' : '' ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="name">Имя <sup>*</sup></label>

            <input class="form__input <?= isset($errors['name'])
                ? 'form__input--error' : '' ?>" type="text" name="name"
                   id="name" value="" placeholder="Введите имя">
            <?= isset($errors['name'])
                ? '<p class="form__message">Введите имя</p>' : '' ?>
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
