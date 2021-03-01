USE doingsdone;

INSERT INTO users(email, name, password) VALUES ('mail@mail.ru', 'Евген', '1234');
INSERT INTO users(email, name, password) VALUES ('gmail@gmail.com', 'Мария', 'qwerty');

INSERT INTO projects(user_id, title) VALUES (1, 'Входящие');
INSERT INTO projects(user_id, title) VALUES (1, 'Учеба');
INSERT INTO projects(user_id, title) VALUES (2, 'Работа');
INSERT INTO projects(user_id, title) VALUES (1, 'Домашние дела');
INSERT INTO projects(user_id, title) VALUES (2, 'Авто');

INSERT INTO tasks(user_id, project_id, title, is_done, time_end) VALUES (2, 3, 'Собеседование в IT компании', false, '19.12.01');
INSERT INTO tasks(user_id, project_id, title, is_done, time_end) VALUES (2, 3, 'Выполнить тестовое задание', false, '19.12.25');
INSERT INTO tasks(user_id, project_id, title, is_done, time_end) VALUES (1, 2, 'Сделать задание первого раздела', true, '19.12.21');
INSERT INTO tasks(user_id, project_id, title, is_done, time_end) VALUES (1, 1, 'Встреча с другом', false, '21.02.05');
INSERT INTO tasks(user_id, project_id, title, is_done, time_end) VALUES (1, 4, 'Купить корм для кота', false, '00.00.00');
INSERT INTO tasks(user_id, project_id, title, is_done, time_end) VALUES (1, 4, 'Заказать пиццу', false, '00.00.00');

-- получить список из всех проектов для одного пользователя

SELECT title FROM projects WHERE user_id = 1;

-- получить список из всех задач для одного проекта

SELECT title FROM tasks WHERE project_id = 3;

-- пометить задачу как выполненную

UPDATE tasks SET is_done = true WHERE id = 1;

-- обновить название задачи по её идентификатору

UPDATE tasks SET title = 'новое название' WHERE id = 1;