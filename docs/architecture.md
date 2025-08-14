# Code Structure - Simple

## File: index.php (Everything in one file)

```php
<?php
// 1. Database connection
$pdo = new PDO("pgsql:host=localhost;dbname=user_management", $username, $password);

// 2. Get users
$users = $pdo->query("SELECT id, first_name, last_name, email, phone, created_at FROM users")->fetchAll();

// 3. HTML output
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    <style>/* Table CSS */</style>
</head>
<body>
    <h1>User Management System</h1>
    <table>
        <!-- Display users here -->
    </table>
</body>
</html>
```

## That's the entire architecture
- No functions needed
- No classes needed  
- No routing needed
- Linear execution: connect → query → display

## Design Patterns
- **Single Responsibility**: Mỗi function có 1 nhiệm vụ cụ thể
- **MVC trong 1 file**: Model (DB functions), View (HTML rendering), Controller (request handling)
- **Error Handling**: Try-catch cho tất cả database operations

## Security Considerations
- Prepared statements cho SQL queries
- Input sanitization
- CSRF protection (sẽ thêm sau)
- XSS prevention

## Scalability Notes
- Code được tổ chức để dễ dàng tách thành nhiều files sau này
- Comments chi tiết để AI hiểu context
- Function naming convention rõ ràng
