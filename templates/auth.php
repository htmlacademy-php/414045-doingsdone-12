<?php
/**
 * @var array $errors
 * @var array-key $input данные введеные пользователем
 * @var string $input_errors_class_name имя класса поля ввода с ошибкой
 */

?>

<section class="content__side">
    <p class="content__side-info">Если у вас уже есть аккаунт, авторизуйтесь на
        сайте</p>

    <a class="button button--transparent content__side-button"
       href="<?= get_url_auth_page() ?>">Войти</a>
</section>

<main class="content__main">
    <h2 class="content__main-heading">Вход на сайт</h2>

    <form class="form" action="<?= get_url_auth_script() ?>" method="post"
          autocomplete="off">
        <div class="form__row">
            <label class="form__label" for="email">E-mail <sup>*</sup></label>

            <input class="form__input <?= isset($errors['email'])
                ? $input_errors_class_name : '' ?>" type="text" name="email"
                   id="email" value="<?= $input['email'] ?? '' ?>"
                   placeholder="Введите e-mail">
            <?php
            if (isset($errors['email'])) : ?>
                <p class="form__message"><?= $errors['email'] ?></p>
                <?php
            endif; ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="password">Пароль
                <sup>*</sup></label>

            <input class="form__input <?= isset($errors['password'])
                ? $input_errors_class_name : '' ?>" type="password"
                   name="password"
                   id="password" value="<?= $input['password'] ?? '' ?>"
                   placeholder="Введите пароль">
            <?php
            if (isset($errors['password'])) : ?>
                <p class="form__message"><?= $errors['password'] ?></p>
                <?php
            endif; ?>
        </div>

        <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Войти">
        </div>
    </form>

</main>

