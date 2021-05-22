<?php
/**
 * @var array-key $projects             проекты пользователя
 * @var int       $chosen_project_id    id выбранного проекта
 * @var string    $chosen_tasks_filter  выбранный фильтр для задач
 * @var array-key $user_tasks           задачи пользователя
 * @var array-key $found_tasks          задачи пользователя найденые по поисковому запросу
 * @var array     $projects_count       количество задач в проектах
 * @var int       $show_complete_tasks  параметр отображения выполненных задач
 * @var string    $url_all_project_task путь для отображения всех задач в проекте
 */

?>

<section class="content__side">
    <h2 class="content__side-heading">Проекты</h2>

    <nav class="main-navigation">
        <ul class="main-navigation__list">
            <!-- добавляем цикл с массивом проектов -->
            <?php
            foreach ($projects as $key => $project): ?>
                <li class="main-navigation__list-item<?= ($project['id']
                    == $chosen_project_id)
                    ? " main-navigation__list-item--active" : "" ?>">
                    <a class="main-navigation__list-item-link"
                       href="<?= get_url_id_chosen_project(
                           $project['id']
                       ) ?>"><?= filter(
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
    <h2 class="content__main-heading">Список задач</h2>

    <form class="search-form" action="<?= get_url_homepage() ?>" method="get"
          autocomplete="off">
        <input class="search-form__input" type="text" name="search" value=""
               placeholder="Поиск по задачам">
        <input class="search-form__submit" type="submit" name="" value="Искать">
    </form>

    <div class="tasks-controls">
        <nav class="tasks-switch">
            <a href="<?= get_url_all_project_tasks($chosen_project_id) ?>"
               class="tasks-switch__item<?= $chosen_tasks_filter == 'all'
                   ? ' tasks-switch__item--active' : '' ?>">Все
                задачи</a>
            <a href="<?= get_url_tasks_filter_today() ?>"
               class="tasks-switch__item<?= $chosen_tasks_filter
               == 'today_tasks'
                   ? ' tasks-switch__item--active' : '' ?>">Повестка дня</a>
            <a href="<?= get_url_tasks_filter_next_day() ?>"
               class="tasks-switch__item<?= $chosen_tasks_filter
               == 'next_day_tasks'
                   ? ' tasks-switch__item--active' : '' ?>">Завтра</a>
            <a href="<?= get_url_tasks_filter_overdue() ?>"
               class="tasks-switch__item<?= $chosen_tasks_filter
               == 'overdue_tasks'
                   ? ' tasks-switch__item--active' : '' ?>">Просроченные</a>
        </nav>

        <label class="checkbox">
            <!--добавить сюда атрибут "checked", если переменная $show_complete_tasks равна единице-->
            <input class="checkbox__input visually-hidden show_completed"
                   type="checkbox" <?= $show_complete_tasks ? "checked" : "" ?>>
            <span class="checkbox__text">Показывать выполненные</span>
        </label>
    </div>

    <table class="tasks">
        <?= $nothing_found_message ?? '' ?>
        <!-- добавляем цикл для двумерного массива -->
        <?php
        $tasks = $user_tasks ?? $found_tasks ?? []; ?>
        <?php
        foreach ($tasks as $task): ?>
            <?php
            if ($task['is_done'] && !$show_complete_tasks): ?>
                <?php
                continue ?>
            <?php
            endif; ?>
            <tr class="tasks__item task <?= $task['is_done'] ? "task--completed"
                : "" ?><?= is_task_important($task['time_end'])
                ? " task--important" : "" ?>">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <input class="checkbox__input visually-hidden task__checkbox"
                               type="checkbox"
                               name="id_task_for_state_changing"
                               value="<?= $task['id'] ?>" <?= $task['is_done']
                            ? 'checked' : '' ?>>
                        <span class="checkbox__text"><?= htmlspecialchars(
                                $task['name']
                            ); ?></span>
                    </label>
                </td>
                <td class="task__file">
                    <?php
                    if ($task['file_name']): ?>
                        <a class="download-link"
                           href="<?= get_url_task_file(
                               $task
                           ) ?>"><?= $task['file_name'] ?? ''; ?></a>
                    <?php
                    endif; ?>
                </td>
                <td class="task__date"><?= htmlspecialchars($task['time_end']); ?></td>
            </tr>
        <?php
        endforeach; ?>
    </table>
</main>
