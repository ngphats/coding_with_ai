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
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## Sample Data
```sql
INSERT INTO users (first_name, last_name, email, phone) VALUES
('Nguyen', 'Van A', 'nguyenvana@email.com', '0901234567'),
('Tran', 'Thi B', 'tranthib@email.com', '0902345678'),
('Le', 'Van C', 'levanc@email.com', '0903456789');
```

## Connection in PHP
```php
$pdo = new PDO("pgsql:host=localhost;dbname=user_management", $username, $password);
```

## Query to Use
```sql
SELECT id, first_name, last_name, email, phone, created_at FROM users ORDER BY id;
```

## Migration for Existing Database
```sql
-- Add phone column to existing table
ALTER TABLE users ADD COLUMN phone VARCHAR(20);

-- Update existing users with sample phone numbers
UPDATE users SET phone = '0901234567' WHERE id = 1;
UPDATE users SET phone = '0902345678' WHERE id = 2;
UPDATE users SET phone = '0903456789' WHERE id = 3;
```
