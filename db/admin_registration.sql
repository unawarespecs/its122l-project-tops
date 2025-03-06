CREATE DATABASE admin_registration;
USE admin_registration;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL
);

CREATE TABLE failed_logins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    user_id INT,
    attempted_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);