<?php
/**
 * @var array $projects
 * @var array $tasks
 * @var array $projects_count
 * @var int $show_complete_tasks
 * @var array $errors
 */
?>


<section class="content__side">
    <h2 class="content__side-heading">Проекты</h2>

    <nav class="main-navigation">
        <ul class="main-navigation__list">
            <!-- добавляем цикл с массивом проектов -->
            <?php foreach ($projects as $key => $project): ?>
                <li class="main-navigation__list-item<?= is_active_project($key) ? " main-navigation__list-item--active": "" ?>">
                    <a class="main-navigation__list-item-link" href="/?id_chosen_project=<?= $key ?>"><?= filter($project['name']); ?></a>
                    <span class="main-navigation__list-item-count"><?= $projects_count[$project['name']] ?? 0 ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <a class="button button--transparent button--plus content__side-button" href="form-project.html">Добавить проект</a>
</section>

<main class="content__main">
    <h2 class="content__main-heading">Добавление задачи</h2>

    <form class="form"  action="./add.php" method="post" autocomplete="off" enctype="multipart/form-data">
        <div class="form__row">
            <label class="form__label" for="name">Название <sup>*</sup></label>
            <?= isset($errors['name']) ? "<p class='form__message'>" . $errors['name'] . "</p>": ""?>
            <input class="form__input <?= isset($errors['name']) ? "form__input--error": ""?>" type="text" name="name" id="name" value="" placeholder="Введите название">
        </div>
        <div class="form__row">
            <label class="form__label" for="project">Проект <sup>*</sup></label>
            <?= isset($errors['project']) ? "<p class='form__message'>" . $errors['project'] . "</p>": ""?>
            <select class="form__input form__input--select <?= isset($errors['project']) ? "form__input--error": ""?>" name="project_id" id="project">
                <?php foreach ($projects as $key => $project): ?>
                    <option value="<?= $project['id']; ?>"><?= filter($project['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form__row">
            <label class="form__label" for="date">Дата выполнения</label>
            <?= isset($errors['date']) ? "<p class='form__message'>" . $errors['date'] . "</p>": ""?>
            <input class="form__input form__input--date <?= isset($errors['date']) ? 'form__input--error': ''?>" type="text" name="date" id="date" value="" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
        </div>

        <div class="form__row">
            <label class="form__label" for="file">Файл</label>

            <div class="form__input-file">
                <input class="visually-hidden" type="file" name="file" id="file" value="">

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

