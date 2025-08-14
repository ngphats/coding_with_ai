# AI Development Context

**Last Updated**: 2025-08-14  
**Current Version**: v0.7.0  
**AI Learning Level**: Beginner → Intermediate

## 🧠 Learned Patterns (Auto-updated after each issue)

### 1. Form Handling Pattern (Learned from Issues #003, #004, #005)
```php
// Standard pattern AI should follow for all forms
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Validate input using helper function
    $errors = validateUserInput($_POST);
    
    // 2. If valid, process with database operation
    if (empty($errors)) {
        $result = processUserData($pdo, $_POST);
        
        // 3. Always redirect after successful POST (PRG pattern)
        if ($result['success']) {
            header("Location: index.php?message=" . urlencode($result['message']));
            exit;
        } else {
            $error = $result['error'];
        }
    }
    
    // 4. If errors, preserve form input and show errors
    // Form will re-populate with $_POST data
}
```

### 2. Database Operation Pattern (Learned from All CRUD operations)
```php
// AI should always follow this pattern for DB operations
function databaseOperation($pdo, $params) {
    try {
        // 1. Always use prepared statements
        $sql = "SELECT/INSERT/UPDATE/DELETE with ? placeholders";
        $stmt = $pdo->prepare($sql);
        
        // 2. Execute with parameters array
        $result = $stmt->execute($params);
        
        // 3. Check success and provide meaningful feedback
        if ($result) {
            return ['success' => true, 'message' => 'User-friendly message'];
        } else {
            return ['success' => false, 'error' => 'Operation failed'];
        }
    } catch (PDOException $e) {
        // 4. Always catch and handle database errors
        return ['success' => false, 'error' => 'Database error: ' . $e->getMessage()];
    }
}
```

### 3. Delete Pattern (Learned from Issue #011)
```php
// AI should always implement destructive actions like this
case 'delete':
    // 1. Validate ID parameter
    $id = $_GET['id'] ?? 0;
    if (!$id || !is_numeric($id)) {
        header('Location: index.php?error=' . urlencode('Invalid ID'));
        exit;
    }
    
    // 2. Execute delete operation
    $result = deleteEntity($pdo, $id);
    
    // 3. Redirect with appropriate message
    if ($result['success']) {
        header('Location: index.php?message=' . urlencode($result['message']));
    } else {
        header('Location: index.php?error=' . urlencode($result['error']));
    }
    exit; // Always exit after redirect

// Delete function pattern:
function deleteEntity($pdo, $id) {
    // 1. Always verify entity exists first
    $checkStmt = $pdo->prepare("SELECT name FROM entity WHERE id = ?");
    $checkStmt->execute([$id]);
    $entity = $checkStmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$entity) {
        return ['success' => false, 'error' => 'Entity không tồn tại'];
    }
    
    // 2. Perform deletion
    $deleteStmt = $pdo->prepare("DELETE FROM entity WHERE id = ?");
    $result = $deleteStmt->execute([$id]);
    
    // 3. Provide feedback with entity name
    if ($result && $deleteStmt->rowCount() > 0) {
        return ['success' => true, 'message' => "'{$entity['name']}' đã được xóa thành công!"];
    } else {
        return ['success' => false, 'error' => 'Failed to delete entity'];
    }
}
```

### 4. UI/UX Patterns (Learned from design iterations)
```css
/* AI should follow these UI patterns */

/* Color System - Professional Yellow Theme */
:root {
    --primary-color: #f59e0b;      /* Main brand color */
    --primary-hover: #d97706;      /* Hover states */
    --success-color: #059669;      /* Success messages */
    --danger-color: #dc2626;       /* Delete/danger actions */
    --danger-hover: #b91c1c;       /* Delete hover */
}

/* Button Patterns */
.btn {
    /* Standard button base */
    padding: 0.75rem 1.5rem;
    border-radius: var(--border-radius);
    transition: all 0.2s ease;
}

.btn-danger {
    /* Always use for destructive actions */
    background-color: var(--danger-color);
    color: white;
    border: 2px solid var(--danger-color);
}

.btn-danger:hover {
    background-color: var(--danger-hover);
    transform: translateY(-1px);
}
```

### 5. Validation Pattern (Learned from form implementations)
```php
// AI should always validate like this
function validateUserInput($data) {
    $errors = [];
    
    // 1. Required field validation
    if (empty(trim($data['first_name'] ?? ''))) {
        $errors['first_name'] = 'First name is required';
    }
    
    // 2. Format validation with regex
    if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address';
    }
    
    // 3. Length validation
    if (strlen(trim($data['first_name'] ?? '')) > 50) {
        $errors['first_name'] = 'First name must be less than 50 characters';
    }
    
    // 4. Optional field handling
    if (!empty($data['phone']) && !preg_match('/^[\d\-\+\(\)\s]+$/', $data['phone'])) {
        $errors['phone'] = 'Please enter a valid phone number';
    }
    
    return $errors;
}
```

## 🎯 Current Capabilities & Status

### ✅ Completed Features
- **CRUD Operations**: Full Create, Read, Update, Delete functionality
- **Form Validation**: Client-side and server-side validation
- **Error Handling**: Comprehensive error handling and user feedback
- **UI/UX**: Professional yellow theme with responsive design
- **Security**: PDO prepared statements, input sanitization

### 🔧 Technical Architecture
- **Single File**: Everything in index.php (appropriate for MVP)
- **Database**: PostgreSQL with users table
- **Styling**: CSS Variables system for maintainable theming
- **Layout**: 1280px container width for professional appearance

### 🧠 AI Understanding Level
- **Database Patterns**: ✅ Mastered
- **Form Handling**: ✅ Mastered  
- **Error Handling**: ✅ Mastered
- **UI Consistency**: ✅ Mastered
- **Security Basics**: ✅ Mastered

## 🚫 Anti-Patterns (Things AI Should AVOID)

### ❌ Database Anti-Patterns
```php
// NEVER do this - SQL injection risk
$sql = "SELECT * FROM users WHERE id = " . $_GET['id'];

// ALWAYS do this instead
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_GET['id']]);
```

### ❌ Error Handling Anti-Patterns
```php
// NEVER expose internal errors
die("Database connection failed: " . $pdo->errorInfo());

// ALWAYS provide user-friendly messages
return ['success' => false, 'error' => 'Something went wrong. Please try again.'];
```

### ❌ UI Anti-Patterns
```php
// NEVER output unescaped data
echo $user['name'];

// ALWAYS escape output
echo htmlspecialchars($user['name']);
```

## 📝 AI Development Guidelines

### When Adding New Features:
1. **Follow Existing Patterns**: Use established code patterns from ai-context.md
2. **Update Documentation**: Add new patterns to this file after implementation
3. **Maintain Consistency**: Follow naming conventions and code structure
4. **Security First**: Always use prepared statements and input validation
5. **User Experience**: Provide clear feedback messages and error handling

### Code Quality Standards:
- **Comments**: Add inline comments explaining business logic
- **Variable Names**: Use descriptive names ($userEmail not $e)
- **Functions**: Single responsibility, clear purpose
- **Error Messages**: User-friendly, not technical
- **Validation**: Both client-side and server-side

### Testing Checklist:
- [ ] Happy path works correctly
- [ ] Error cases handled gracefully
- [ ] Edge cases considered (empty input, invalid IDs, etc.)
- [ ] UI/UX is intuitive and consistent
- [ ] Security measures in place
- [ ] Documentation updated

## 🔄 Continuous Learning Process

This file should be updated after every issue completion with:
1. **New patterns learned**
2. **Refined existing patterns**
3. **Anti-patterns discovered**
4. **Performance insights**
5. **User feedback integration**

Last learning update: Issue #011 - Delete User Functionality
Next expected update: When new feature is implemented
