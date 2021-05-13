CREATE DATABASE doingsdone
    DEFAULT CHARACTER  SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE doingsdone;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email VARCHAR(128) NOT NULL UNIQUE,
    name VARCHAR(64) NOT NULL,
    password VARCHAR(64) NOT NULL
);

CREATE INDEX u_email ON users(email);

CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    title VARCHAR(64) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE INDEX p_user_id ON projects(user_id);

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT REFERENCES users(id),
    project_id INT REFERENCES projects(id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_done BOOL DEFAULT false,
    title VARCHAR(64) NOT NULL,
    file_src VARCHAR(128),
    time_end TIMESTAMP DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (project_id) REFERENCES projects(id)
);

CREATE INDEX t_user_id ON tasks(user_id);
CREATE INDEX t_project_id ON tasks(project_id);
CREATE FULLTEXT INDEX ft_title ON tasks(title);
