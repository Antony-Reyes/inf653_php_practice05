CREATE DATABASE IF NOT EXISTS quotesdb;
USE quotesdb;

CREATE TABLE authors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    author VARCHAR(255) NOT NULL
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(255) NOT NULL
);

CREATE TABLE quotes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quote TEXT NOT NULL,
    author_id INT NOT NULL,
    category_id INT NOT NULL,
    FOREIGN KEY (author_id) REFERENCES authors(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);
