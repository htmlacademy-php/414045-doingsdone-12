<?php

?>

<section class="content__side">
    <h2 class="content__side-heading">Проекты</h2>

    <nav class="main-navigation">
        <ul class="main-navigation__list">
            <!-- добавляем цикл с массивом проектов -->
            <?php foreach ($projects as $key => $project): ?>
                <li class="main-navigation__list-item<?= is_active_project($project['id']) ? " main-navigation__list-item--active" : "" ?>">
                    <a class="main-navigation__list-item-link"
                       href="/?id_chosen_project=<?= $project['id'] ?>"><?= filter($project['name']); ?></a>
                    <span class="main-navigation__list-item-count"><?= $projects_count[$project['id']] ?? 0 ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <a class="button button--transparent button--plus content__side-button" href="form-project.html">Добавить проект</a>
</section>

<main class="content__main">
    <h2 class="content__main-heading"> Регистрация аккаунта </h2>

    <form class="form" action="index.html" method="post" autocomplete="off">
        <div class="form__row">
            <label class="form__label" for="email"> E - mail <sup>*</sup></label>

            <input class="form__input form__input--error" type="text" name="email" id="email" value=""
                   placeholder="Введите e-mail">

            <p class="form__message"> E - mail введён некорректно </p>
        </div>

        <div class="form__row">
            <label class="form__label" for="password"> Пароль <sup>*</sup></label>

            <input class="form__input" type="password" name="password" id="password" value=""
                   placeholder="Введите пароль">
        </div>

        <div class="form__row">
            <label class="form__label" for="name"> Имя <sup>*</sup></label>

            <input class="form__input" type="text" name="name" id="name" value="" placeholder="Введите имя">
        </div>

        <div class="form__row form__row--controls">
            <p class="error-message"> Пожалуйста, исправьте ошибки в форме </p>

            <input class="button" type="submit" name="" value="Зарегистрироваться">
        </div>
    </form>
</main>
