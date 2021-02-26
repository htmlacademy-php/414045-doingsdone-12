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
    user_id INT REFERENCES users(id),
    title VARCHAR(64) NOT NULL
);

CREATE INDEX p_user_id ON projects(user_id);

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT REFERENCES users(id),
    project_id INT REFERENCES projects(id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_done INT(1) DEFAULT 0,
    title VARCHAR(64) NOT NULL,
    file_src VARCHAR(128),
    time_end TIMESTAMP NOT NULL
);

CREATE INDEX t_user_id ON tasks(user_id);
CREATE INDEX t_project_id ON tasks(project_id);

