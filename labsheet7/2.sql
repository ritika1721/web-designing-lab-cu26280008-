CREATE DATABASE bookstore;

USE bookstore;

CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100),
    author VARCHAR(100),
    category VARCHAR(50),
    price DECIMAL(10,2),
    stock INT,
    image VARCHAR(255)
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255)
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_amount DECIMAL(10,2),
    shipping_address TEXT,
    status VARCHAR(30) DEFAULT 'Pending',
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    book_id INT,
    quantity INT,
    price DECIMAL(10,2),
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (book_id) REFERENCES books(id)
);

INSERT INTO books
(title, author, category, price, stock, image)
VALUES
('Python Programming', 'John', 'Programming', 400, 10, 'python.jpg'),
('Web Development', 'David', 'Programming', 500, 8, 'web.jpg'),
('Database Systems', 'James', 'Education', 350, 15, 'db.jpg'),
('Computer Networks', 'Andrew', 'Education', 450, 12, 'network.jpg');