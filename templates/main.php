<?php
/**
 * @var array $projects
 * @var array $tasks
 * @var array $projects_count
 * @var int $show_complete_tasks
 */
?>

<section class="content__side">
    <h2 class="content__side-heading">Проекты</h2>

    <nav class="main-navigation">
        <ul class="main-navigation__list">
            <!-- добавляем цикл с массивом проектов -->
            <?php foreach ($projects as $key => $project): ?>
                <li class="main-navigation__list-item">
                    <a class="main-navigation__list-item-link" href="#"><?= filter($project); ?></a>
                    <span class="main-navigation__list-item-count"><?= $projects_count[$project] ?? 0 ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <a class="button button--transparent button--plus content__side-button" href="../pages/form-project.html" target="project_add">Добавить проект</a>
</section>

<main class="content__main">
    <h2 class="content__main-heading">Список задач</h2>

    <form class="search-form" action="../index.php" method="post" autocomplete="off">
        <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">
        <input class="search-form__submit" type="submit" name="" value="Искать">
    </form>

    <div class="tasks-controls">
        <nav class="tasks-switch">
            <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
            <a href="/" class="tasks-switch__item">Повестка дня</a>
            <a href="/" class="tasks-switch__item">Завтра</a>
            <a href="/" class="tasks-switch__item">Просроченные</a>
        </nav>

        <label class="checkbox">
            <!--добавить сюда атрибут "checked", если переменная $show_complete_tasks равна единице-->
            <input class="checkbox__input visually-hidden show_completed" type="checkbox" <?= $show_complete_tasks ? "checked" : "" ?>>
            <span class="checkbox__text">Показывать выполненные</span>
        </label>
    </div>

    <table class="tasks">
        <!-- добавляем цикл для двумерного массива -->
        <?php foreach ($tasks as $task): ?>
            <?php if ($task['done'] && !$show_complete_tasks): ?>
            <?php continue?>
            <?php endif; ?>
            <tr class="tasks__item task <?= $task['done'] ? "task--completed" : "" ?><?= is_importance_task($task['date']) ? " task--important" : "" ?>">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="1">
                        <span class="checkbox__text"><?= filter($task['task']); ?></span>
                    </label>
                </td>
                <td class="task__file">
                    <a class="download-link" href="#">Home.psd</a>
                </td>
                <td class="task__date"><?= filter($task['date']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</main>