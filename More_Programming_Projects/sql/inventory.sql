CREATE DATABASE IF NOT EXISTS inventory_demo;
USE inventory_demo;

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL UNIQUE,
    quantity INT NOT NULL DEFAULT 0,
    price DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CHECK (quantity >= 0),
    CHECK (price >= 0)
);

INSERT IGNORE INTO products (name, quantity, price) VALUES
('Notebook', 25, 1200.00),
('USB Flash Drive', 10, 6500.00),
('Computer Mouse', 8, 9000.00);
