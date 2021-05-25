<?php
/** @noinspection ALL */

/** @noinspection ALL */
/** @noinspection ALL */
/** @noinspection ALL */
/** @noinspection ALL */
/** @noinspection ALL */
/** @noinspection ALL */
/**
 * Форма добавления проекта
 *
 * @var array-key $projects массив с проектами
 * @var int $chosen_project_id id выбранного проекта
 * @var array-key $errors список ошибок
 * @var array-key $input данные введённые пользователем
 * @var string $input_errors_class_name имя класса поля ввода с ошибкой
 */

?>

<section class="content__side">
    <h2 class="content__side-heading">Проекты</h2>

    <nav class="main-navigation">
        <ul class="main-navigation__list">
            <!-- добавляем цикл с массивом проектов -->
            <?php
            foreach ($projects as $key => $project): ?>
                <li class="main-navigation__list-item">
                    <a class="main-navigation__list-item-link"
                       href="<?= get_url_id_chosen_project(
                           $project['id']
                       ) ?>"><?= htmlspecialchars(
                            $project['name']
                        ); ?></a>
                    <span class="main-navigation__list-item-count"><?= $projects_count[$project['id']]
                        ?? 0 ?></span>
                </li>
            <?php
            endforeach; ?>
        </ul>
    </nav>

    <a class="button button--transparent button--plus content__side-button"
       href="<?= get_url_add_project_page() ?>" target="project_add">Добавить
        проект</a>
</section>

<main class="content__main">
    <h2 class="content__main-heading">Добавление проекта</h2>

    <form class="form" action="<?= get_url_add_project_script() ?>"
          method="post"
          autocomplete="off">
        <div class="form__row">
            <label class="form__label" for="project_name">Название <sup>*</sup></label>
            <?= isset($errors['name']) ? "<p class='form__message'>"
                . $errors['name'] . "</p>" : "" ?>
            <input class="form__input <?= isset($errors['name'])
                ? $input_errors_class_name : "" ?>" type="text" name="name"
                   id="project_name"
                   value="<?= $input['project_name'] ?? '' ?>"
                   placeholder="Введите название проекта">
        </div>

        <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Добавить">
        </div>
    </form>
</main>
