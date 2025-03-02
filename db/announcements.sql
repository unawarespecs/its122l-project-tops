CREATE DATABASE announcements;
USE announcements;

CREATE TABLE announcements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    content TEXT NOT NULL,
    publication_date DATETIME NOT NULL,
    author VARCHAR(100),
    category VARCHAR(50)
);