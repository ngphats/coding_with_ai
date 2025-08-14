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

## Insert New User
```sql
INSERT INTO users (first_name, last_name, email, phone) 
VALUES (?, ?, ?, ?);
```

## Validation Constraints
- **first_name**: NOT NULL, VARCHAR(50)
- **last_name**: NOT NULL, VARCHAR(50)  
- **email**: NOT NULL, UNIQUE, VARCHAR(100)
- **phone**: NULLABLE, VARCHAR(20)

## Error Handling
- **Duplicate Email**: Check for UNIQUE constraint violation
- **Required Fields**: Validate NOT NULL constraints
- **Length Limits**: Validate VARCHAR length limits
