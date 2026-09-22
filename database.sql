CREATE DATABASE IF NOT EXISTS food_ordering;
USE food_ordering;

CREATE TABLE users (
 id INT AUTO_INCREMENT PRIMARY KEY,
 username VARCHAR(100) NOT NULL,
 email VARCHAR(150) NOT NULL UNIQUE,
 password VARCHAR(255) NOT NULL,
 role ENUM('customer','admin') NOT NULL DEFAULT 'customer',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE items (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(150) NOT NULL,
 category VARCHAR(100) NOT NULL,
 price DECIMAL(10,2) NOT NULL,
 description TEXT,
 emoji VARCHAR(20) DEFAULT '🍽️',
 status ENUM('available','unavailable') NOT NULL DEFAULT 'available',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE orders (
 id INT AUTO_INCREMENT PRIMARY KEY,
 user_id INT NOT NULL,
 total_amount DECIMAL(10,2) NOT NULL,
 address TEXT NOT NULL,
 phone VARCHAR(30) NOT NULL,
 status ENUM('pending','accepted','preparing','delivered','cancelled') DEFAULT 'pending',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE order_items (
 id INT AUTO_INCREMENT PRIMARY KEY,
 order_id INT NOT NULL,
 item_id INT NOT NULL,
 quantity INT NOT NULL,
 price DECIMAL(10,2) NOT NULL,
 FOREIGN KEY(order_id) REFERENCES orders(id) ON DELETE CASCADE,
 FOREIGN KEY(item_id) REFERENCES items(id) ON DELETE RESTRICT
);

CREATE TABLE messages (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100) NOT NULL,
 email VARCHAR(150) NOT NULL,
 message TEXT NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Demo admin login: admin@foodhub.com / admin123
-- Password hash generated with PHP password_hash('admin123', PASSWORD_DEFAULT)
INSERT INTO users(username,email,password,role) VALUES
('Shop Admin','admin@foodhub.com','$2y$10$ufq5skXRSE/dckeIyo43T.RDbKf/gCPo.7qyo30CrA7OwPCf8m3fG','admin');

INSERT INTO items(name,category,price,description,emoji,status) VALUES
('Chicken Burger','Burgers',850.00,'Crispy chicken burger with fresh vegetables.','🍔','available'),
('Cheese Pizza','Pizza',1500.00,'Cheesy pizza with tomato sauce and herbs.','🍕','available'),
('French Fries','Sides',500.00,'Crispy golden French fries.','🍟','available'),
('Chicken Rice','Rice',1200.00,'Fried rice with chicken and vegetables.','🍚','available'),
('Chocolate Cake','Desserts',650.00,'Soft chocolate cake slice.','🍰','available');
