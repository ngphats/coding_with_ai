<?php
// Database configuration
$host = 'localhost';
$dbname = 'user_management';
$username = 'postgres';  // Update this with your PostgreSQL username
$password = 'mysql';  // Update this with your PostgreSQL password
$port = '5433'; // Default PostgreSQL port

// Connect to PostgreSQL database
try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Helper Functions
function validateUserInput($data) {
    $errors = [];
    
    // First Name validation
    if (empty(trim($data['first_name']))) {
        $errors['first_name'] = 'First name is required';
    } elseif (strlen(trim($data['first_name'])) > 50) {
        $errors['first_name'] = 'First name must be 50 characters or less';
    } elseif (!preg_match('/^[a-zA-Z\s]+$/', trim($data['first_name']))) {
        $errors['first_name'] = 'First name can only contain letters and spaces';
    }
    
    // Last Name validation
    if (empty(trim($data['last_name']))) {
        $errors['last_name'] = 'Last name is required';
    } elseif (strlen(trim($data['last_name'])) > 50) {
        $errors['last_name'] = 'Last name must be 50 characters or less';
    } elseif (!preg_match('/^[a-zA-Z\s]+$/', trim($data['last_name']))) {
        $errors['last_name'] = 'Last name can only contain letters and spaces';
    }
    
    // Email validation
    if (empty(trim($data['email']))) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var(trim($data['email']), FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address';
    } elseif (strlen(trim($data['email'])) > 100) {
        $errors['email'] = 'Email must be 100 characters or less';
    }
    
    // Phone validation (optional)
    if (!empty(trim($data['phone']))) {
        if (strlen(trim($data['phone'])) > 20) {
            $errors['phone'] = 'Phone number must be 20 characters or less';
        } elseif (!preg_match('/^[0-9\+\-\(\)\s]+$/', trim($data['phone']))) {
            $errors['phone'] = 'Phone number can only contain numbers, +, -, (, ), and spaces';
        }
    }
    
    return $errors;
}

function createUser($pdo, $firstName, $lastName, $email, $phone = null) {
    try {
        // Check for duplicate email
        $checkSql = "SELECT COUNT(*) FROM users WHERE email = ?";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->execute([trim($email)]);
        
        if ($checkStmt->fetchColumn() > 0) {
            return ['success' => false, 'error' => 'Email address already exists'];
        }
        
        // Insert new user
        $sql = "INSERT INTO users (first_name, last_name, email, phone) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            trim($firstName),
            trim($lastName),
            trim($email),
            empty(trim($phone)) ? null : trim($phone)
        ]);
        
        if ($result) {
            return ['success' => true, 'message' => 'User đã được thêm thành công!'];
        } else {
            return ['success' => false, 'error' => 'Failed to create user'];
        }
    } catch (PDOException $e) {
        return ['success' => false, 'error' => 'Database error: ' . $e->getMessage()];
    }
}

function getUsers($pdo) {
    try {
        $sql = "SELECT id, first_name, last_name, email, phone, created_at FROM users ORDER BY id";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}

// Request Routing
$action = $_GET['action'] ?? 'list';
$message = $_GET['message'] ?? '';
$error = $_GET['error'] ?? '';
$errors = [];

switch ($action) {
    case 'add':
        if ($_POST) {
            // Process form submission
            $errors = validateUserInput($_POST);
            
            if (empty($errors)) {
                $result = createUser($pdo, $_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['phone']);
                
                if ($result['success']) {
                    header('Location: index.php?message=' . urlencode($result['message']));
                    exit;
                } else {
                    $error = $result['error'];
                }
            }
        }
        break;
    
    case 'list':
    default:
        $users = getUsers($pdo);
        break;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        
        /* Button Styles */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            margin-bottom: 20px;
        }
        
        .btn:hover {
            background-color: #0056b3;
        }
        
        .btn-secondary {
            background-color: #6c757d;
        }
        
        .btn-secondary:hover {
            background-color: #545b62;
        }
        
        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
        }
        
        tr:hover {
            background-color: #f5f5f5;
        }
        
        .no-data {
            text-align: center;
            padding: 20px;
            color: #666;
            font-style: italic;
        }
        
        /* Form Styles */
        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }
        
        input[type="text"]:focus, input[type="email"]:focus {
            border-color: #007bff;
            outline: none;
        }
        
        .error {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
        
        .form-actions {
            margin-top: 30px;
        }
        
        .form-actions .btn {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Management System</h1>
        
        <?php if ($message): ?>
            <div class="success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <?php if ($action === 'add'): ?>
            <!-- Add User Form -->
            <div class="form-container">
                <h2>Thêm User Mới</h2>
                <form method="POST" action="index.php?action=add">
                    <div class="form-group">
                        <label for="first_name">First Name *</label>
                        <input type="text" id="first_name" name="first_name" 
                               value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>" required>
                        <?php if (isset($errors['first_name'])): ?>
                            <div class="error"><?= htmlspecialchars($errors['first_name']) ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="last_name">Last Name *</label>
                        <input type="text" id="last_name" name="last_name" 
                               value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>" required>
                        <?php if (isset($errors['last_name'])): ?>
                            <div class="error"><?= htmlspecialchars($errors['last_name']) ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" 
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                        <?php if (isset($errors['email'])): ?>
                            <div class="error"><?= htmlspecialchars($errors['email']) ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" id="phone" name="phone" 
                               value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                        <?php if (isset($errors['phone'])): ?>
                            <div class="error"><?= htmlspecialchars($errors['phone']) ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn">Thêm User</button>
                        <a href="index.php" class="btn btn-secondary">Hủy</a>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <!-- User List -->
            <a href="index.php?action=add" class="btn">Thêm User</a>
            
            <?php if (empty($users)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Created Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" class="no-data">No users found</td>
                        </tr>
                    </tbody>
                </table>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Created Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['first_name']) ?></td>
                            <td><?= htmlspecialchars($user['last_name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['phone'] ?? '') ?></td>
                            <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($user['created_at']))) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
