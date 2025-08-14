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

function getUserById($pdo, $id) {
    try {
        $sql = "SELECT id, first_name, last_name, email, phone, created_at FROM users WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
}

function updateUser($pdo, $id, $firstName, $lastName, $email, $phone = null) {
    try {
        // Check for duplicate email (excluding current user)
        $checkSql = "SELECT COUNT(*) FROM users WHERE email = ? AND id != ?";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->execute([trim($email), $id]);
        
        if ($checkStmt->fetchColumn() > 0) {
            return ['success' => false, 'error' => 'Email address already exists'];
        }
        
        // Update user
        $sql = "UPDATE users SET first_name = ?, last_name = ?, email = ?, phone = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            trim($firstName),
            trim($lastName),
            trim($email),
            empty(trim($phone)) ? null : trim($phone),
            $id
        ]);
        
        if ($result && $stmt->rowCount() > 0) {
            return ['success' => true, 'message' => 'User đã được cập nhật thành công!'];
        } elseif ($result) {
            return ['success' => true, 'message' => 'No changes were made'];
        } else {
            return ['success' => false, 'error' => 'Failed to update user'];
        }
    } catch (PDOException $e) {
        return ['success' => false, 'error' => 'Database error: ' . $e->getMessage()];
    }
}

// Request Routing
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;
$message = $_GET['message'] ?? '';
$error = $_GET['error'] ?? '';
$errors = [];
$user = null;

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
    
    case 'edit':
        if (!$id || !is_numeric($id)) {
            header('Location: index.php?error=' . urlencode('Invalid user ID'));
            exit;
        }
        
        $user = getUserById($pdo, $id);
        if (!$user) {
            header('Location: index.php?error=' . urlencode('User not found'));
            exit;
        }
        
        if ($_POST) {
            // Process form submission
            $errors = validateUserInput($_POST);
            
            if (empty($errors)) {
                $result = updateUser($pdo, $id, $_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['phone']);
                
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
        /* CSS Variables - Design System */
        :root {
            --primary-color: #2563eb;
            --primary-hover: #1d4ed8;
            --secondary-color: #64748b;
            --secondary-hover: #475569;
            --success-color: #059669;
            --success-bg: #ecfdf5;
            --success-border: #10b981;
            --error-color: #dc2626;
            --error-bg: #fef2f2;
            --error-border: #f87171;
            --warning-color: #d97706;
            --warning-bg: #fffbeb;
            --warning-border: #f59e0b;
            --neutral-50: #f8fafc;
            --neutral-100: #f1f5f9;
            --neutral-200: #e2e8f0;
            --neutral-300: #cbd5e1;
            --neutral-400: #94a3b8;
            --neutral-500: #64748b;
            --neutral-600: #475569;
            --neutral-700: #334155;
            --neutral-800: #1e293b;
            --neutral-900: #0f172a;
            --border-radius: 8px;
            --border-radius-sm: 4px;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        /* Base Styles */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, system-ui, sans-serif;
            line-height: 1.6;
            color: var(--neutral-700);
            background: linear-gradient(135deg, var(--neutral-50) 0%, var(--neutral-100) 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }
        
        h1 {
            color: var(--neutral-800);
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2.5rem;
            font-weight: 700;
            text-shadow: var(--shadow-sm);
        }

        h2 {
            color: var(--neutral-700);
            font-size: 1.875rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Button System */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            line-height: 1.25rem;
            border: 1px solid transparent;
            border-radius: var(--border-radius-sm);
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            box-shadow: var(--shadow-sm);
            margin-bottom: 1rem;
            margin-right: 0.5rem;
        }

        .btn:focus {
            outline: 2px solid transparent;
            outline-offset: 2px;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        /* Primary Button */
        .btn {
            background-color: var(--primary-color);
            color: white;
        }

        .btn:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        /* Secondary Button */
        .btn-secondary {
            background-color: var(--secondary-color);
            color: white;
        }

        .btn-secondary:hover {
            background-color: var(--secondary-hover);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        /* Small Button */
        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.75rem;
            border-radius: var(--border-radius-sm);
        }

        /* Table System */
        .table-container {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--neutral-200);
        }

        th {
            background: linear-gradient(135deg, var(--neutral-50) 0%, var(--neutral-100) 100%);
            font-weight: 600;
            color: var(--neutral-700);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        tbody tr {
            transition: all 0.2s ease-in-out;
        }

        tbody tr:hover {
            background-color: var(--neutral-50);
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .no-data {
            text-align: center;
            padding: 3rem;
            color: var(--neutral-500);
            font-style: italic;
            font-size: 1.125rem;
        }

        /* Form System */
        .form-container {
            background: white;
            padding: 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            max-width: 600px;
            margin: 0 auto 2rem auto;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--neutral-700);
            font-size: 0.875rem;
        }

        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--neutral-200);
            border-radius: var(--border-radius-sm);
            font-size: 1rem;
            transition: all 0.2s ease-in-out;
            background-color: var(--neutral-50);
        }

        input[type="text"]:focus, input[type="email"]:focus {
            outline: none;
            border-color: var(--primary-color);
            background-color: white;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        input[type="text"]:hover, input[type="email"]:hover {
            border-color: var(--neutral-300);
        }

        /* Alert System */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: var(--border-radius);
            margin-bottom: 1.5rem;
            font-weight: 500;
            border: 1px solid;
        }

        .success, .alert-success {
            background-color: var(--success-bg);
            color: var(--success-color);
            border-color: var(--success-border);
        }

        .alert-error {
            background-color: var(--error-bg);
            color: var(--error-color);
            border-color: var(--error-border);
        }

        .error {
            color: var(--error-color);
            font-size: 0.875rem;
            margin-top: 0.5rem;
            font-weight: 500;
        }

        /* Form Actions */
        .form-actions {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--neutral-200);
            display: flex;
            gap: 1rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            h1 {
                font-size: 2rem;
            }

            .container {
                padding: 0;
            }

            .form-container {
                padding: 1.5rem;
                margin: 0 0 1rem 0;
            }

            th, td {
                padding: 0.75rem 0.5rem;
                font-size: 0.875rem;
            }

            .btn {
                width: 100%;
                margin-bottom: 0.5rem;
                margin-right: 0;
            }

            .form-actions {
                flex-direction: column;
                gap: 0.5rem;
            }

            .table-container {
                overflow-x: auto;
            }

            table {
                min-width: 600px;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.75rem;
            }

            .form-container {
                padding: 1rem;
            }

            th, td {
                padding: 0.5rem 0.25rem;
                font-size: 0.75rem;
            }
        }

        /* Loading Animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid var(--neutral-200);
            border-radius: 50%;
            border-top-color: var(--primary-color);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Utility Classes */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .mb-4 { margin-bottom: 1rem; }
        .mt-4 { margin-top: 1rem; }
        .p-4 { padding: 1rem; }
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
        <?php elseif ($action === 'edit'): ?>
            <!-- Edit User Form -->
            <div class="form-container">
                <h2>Chỉnh Sửa User</h2>
                <form method="POST" action="index.php?action=edit&id=<?= $user['id'] ?>">
                    <div class="form-group">
                        <label for="first_name">First Name *</label>
                        <input type="text" id="first_name" name="first_name" 
                               value="<?= htmlspecialchars($_POST['first_name'] ?? $user['first_name']) ?>" required>
                        <?php if (isset($errors['first_name'])): ?>
                            <div class="error"><?= htmlspecialchars($errors['first_name']) ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="last_name">Last Name *</label>
                        <input type="text" id="last_name" name="last_name" 
                               value="<?= htmlspecialchars($_POST['last_name'] ?? $user['last_name']) ?>" required>
                        <?php if (isset($errors['last_name'])): ?>
                            <div class="error"><?= htmlspecialchars($errors['last_name']) ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" 
                               value="<?= htmlspecialchars($_POST['email'] ?? $user['email']) ?>" required>
                        <?php if (isset($errors['email'])): ?>
                            <div class="error"><?= htmlspecialchars($errors['email']) ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" id="phone" name="phone" 
                               value="<?= htmlspecialchars($_POST['phone'] ?? ($user['phone'] ?? '')) ?>">
                        <?php if (isset($errors['phone'])): ?>
                            <div class="error"><?= htmlspecialchars($errors['phone']) ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn">Cập Nhật User</button>
                        <a href="index.php" class="btn btn-secondary">Hủy</a>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <!-- User List -->
            <a href="index.php?action=add" class="btn">Thêm User</a>
            
            <?php if (empty($users)): ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Created Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7" class="no-data">No users found</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Created Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($user['id']) ?></strong></td>
                                <td><?= htmlspecialchars($user['first_name']) ?></td>
                                <td><?= htmlspecialchars($user['last_name']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td><?= htmlspecialchars($user['phone'] ?? '-') ?></td>
                                <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($user['created_at']))) ?></td>
                                <td>
                                    <a href="index.php?action=edit&id=<?= $user['id'] ?>" class="btn btn-sm">Edit</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
