# Database Setup

## Create Database
```sql
CREATE DATABASE user_management;
```

## Create Table
```sql
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## Sample Data
```sql
INSERT INTO users (first_name, last_name, email) VALUES
('Nguyen', 'Van A', 'nguyenvana@email.com'),
('Tran', 'Thi B', 'tranthib@email.com'),
('Le', 'Van C', 'levanc@email.com');
```

## Connection in PHP
```php
$pdo = new PDO("pgsql:host=localhost;dbname=user_management", $username, $password);
```

## Query to Use
```sql
SELECT id, first_name, last_name, email, created_at FROM users ORDER BY id;
```
