CREATE DATABASE admin_registration;
USE admin_registration;

CREATE TABLE users
(
    id       INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50)  NOT NULL,
    password VARCHAR(255) NOT NULL,
    email    VARCHAR(100) NOT NULL
);

CREATE TABLE failed_logins
(
    id           INT AUTO_INCREMENT PRIMARY KEY,
    email        VARCHAR(100) NOT NULL,
    user_id      INT,
    attempted_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (id)
);

INSERT INTO `users` (`id`, `username`, `password`, `email`)
VALUES (1, 'Administrator', '$2y$10$MsWQppMjs3hVdLt4kY.zMeqOs4QQYUlCvib13tW1VJFS2R95DYjYG',
        'admin@topsinc.org'), # pass: admin
       (2, 'Test User', '$2y$10$x31fVmz3FVx9RxJj/Y5WhOz.1citwSHhd4bDkF5vgZmjTh2z.8gGm',
        'testuser@topsinc.org') # pass: test