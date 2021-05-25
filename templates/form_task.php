<?php /** @noinspection PhpCSValidationInspection */
/** @noinspection PhpCSValidationInspection */
/** @noinspection PhpCSValidationInspection */
/** @noinspection PhpCSValidationInspection */
/** @noinspection PhpCSValidationInspection */
/** @noinspection PhpCSValidationInspection */
/** @noinspection PhpCSValidationInspection */
/** @noinspection PhpCSValidationInspection */
/** @noinspection PhpCSValidationInspection */
/** @noinspection PhpCSValidationInspection */
/** @noinspection PhpCSValidationInspection */
/** @noinspection PhpCSValidationInspection */
/**
 * @var array $projects проекты пользователя
 * @var array $tasks задачи пользователя
 * @var array $projects_count количество задач в каждом проекте
 * @var int $show_complete_tasks параметр отображения выполненных задач
 * @var int $chosen_project_id выбранный проект
 * @var array-key $errors список ошибок
 * @var array-key $input данные введёные пользователем
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
                       ) ?>"><?= filter($project['name']) ?></a>
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
    <h2 class="content__main-heading">Добавление задачи</h2>

    <form class="form" action="<?= get_url_add_task_script() ?>" method="post"
          autocomplete="off"
          enctype="multipart/form-data">
        <div class="form__row">
            <label class="form__label" for="name">Название <sup>*</sup></label>
            <?= isset($errors['name']) ? "<p class='form__message'>"
                . $errors['name'] . "</p>" : "" ?>
            <input class="form__input <?= isset($errors['name'])
                ? $input_errors_class_name : "" ?>" type="text" name="name"
                   id="name" value="<?= $input['task_name'] ?? '' ?>"
                   placeholder="Введите название">
        </div>
        <div class="form__row">
            <label class="form__label" for="project">Проект <sup>*</sup></label>
            <?= isset($errors['project']) ? "<p class='form__message'>"
                . $errors['project'] . "</p>" : "" ?>
            <select class="form__input form__input--select <?= isset($errors['project'])
                ? $input_errors_class_name : "" ?>"
                    name="project_id" id="project">
                <?php
                foreach ($projects as $key => $project): ?>
                    <option <?php
                    if (isset($input['project_id'])): ?>
                        <?= (int)$project['id'] === (int)$input['project_id'] ? 'selected'
                            : '' ?>
                    <?php
                    endif; ?>
                            value="<?= $project['id'] ?>"><?= filter($project['name']) ?></option>
                <?php
                endforeach; ?>
            </select>
        </div>

        <div class="form__row">
            <label class="form__label" for="date">Дата выполнения</label>
            <?= isset($errors['date']) ? "<p class='form__message'>"
                . $errors['date'] . "</p>" : "" ?>
            <input class="form__input form__input--date <?= isset($errors['date'])
                ? $input_errors_class_name : '' ?>"
                   type="text" name="date" id="date"
                   value="<?= $input['task_time_end'] ?? '' ?>"
                   placeholder="Введите дату в формате ГГГГ-ММ-ДД">
        </div>

        <div class="form__row">
            <label class="form__label" for="file">Файл</label>
            <?= isset($errors['file']) ? "<p class='form__message'>"
                . $errors['file'] . "</p>" : "" ?>
            <div class="form__input-file <?= isset($errors['file'])
                ? $input_errors_class_name : '' ?>">
                <input class="visually-hidden" type="file" name="file" id="file"
                       value="">

                <label class="button button--transparent" for="file">
                    <span>Выберите файл</span>
                </label>
            </div>
        </div>

        <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Добавить">
        </div>
    </form>
</main>

